from fastapi import FastAPI
from fastapi.responses import JSONResponse
from pydantic import BaseModel
from typing import Dict, Any, List
from sentence_transformers import SentenceTransformer
from sklearn.metrics.pairwise import cosine_similarity

app = FastAPI(title="SmartCV Semantic Matcher")

print("Loading Multilingual AI model...")  
# Upgraded to a model with excellent multilingual support (approx. 400MB)
embedding_model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')
print("Matching system is ready!")

# ==========================================
# 1. ĐỊNH NGHĨA CẤU TRÚC DỮ LIỆU
# ==========================================
class JobItem(BaseModel):
    id: int
    description: str

class CvItem(BaseModel):
    id: int
    cv_data: Dict[str, Any]

class CandidateToJobsRequest(BaseModel):
    cv_data: Dict[str, Any]
    jobs: List[JobItem]

class JobToCandidatesRequest(BaseModel):
    job_description: str
    cvs: List[CvItem]


# ==========================================
# 2. CÁC HÀM LOGIC LÕI (Từ code của bạn)
# ==========================================
def build_rich_text_from_json(cv_data: dict) -> str:
    """Helper function to convert JSON CV data into a rich text block for embedding"""
    if not cv_data:
        return ""
        
    text_parts = []
    
    # 1. Tóm tắt & Năm kinh nghiệm
    if cv_data.get("summary"):
        text_parts.append(f"Summary: {cv_data['summary']}")
        
    if cv_data.get("experience_years"):
        text_parts.append(f"Total work experience: {cv_data['experience_years']} years.")
        
    # 2. Kỹ năng chuyên môn
    if cv_data.get("skills"):
        skills_str = ", ".join(cv_data['skills'])
        text_parts.append(f"Professional skills: {skills_str}.")
        
    # 3. Kinh nghiệm làm việc (Nếu có)
    if cv_data.get("work_experience"):
        for job in cv_data["work_experience"]:
            title = job.get('job_title', '')
            desc = job.get('description', '')
            if title or desc:
                text_parts.append(f"Worked as {title}. Job details: {desc}.")
                
    # 👉 4. DỰ ÁN VÀ CÔNG NGHỆ
    if cv_data.get("projects"):
        for proj in cv_data["projects"]:
            p_name = proj.get('name', '')
            p_desc = proj.get('description', '')
            p_tech = ", ".join(proj.get('technologies', []))
            tech_str = f" Technologies used: {p_tech}." if p_tech else ""
            if p_name or p_desc:
                text_parts.append(f"Project '{p_name}': {p_desc}.{tech_str}")
                
    # 5. Học vấn
    if cv_data.get("education"):
        for edu in cv_data["education"]:
            degree = edu.get('degree', '')
            if degree:
                text_parts.append(f"Education: {degree}.")
                
    # 👉 6. THÀNH TỰU, CHỨNG CHỈ & NGÔN NGỮ
    if cv_data.get("achievements"):
        achiev_str = "; ".join(cv_data["achievements"])
        text_parts.append(f"Key Achievements: {achiev_str}.")
        
    if cv_data.get("certifications"):
        cert_str = ", ".join(cv_data["certifications"])
        text_parts.append(f"Certifications: {cert_str}.")
        
    if cv_data.get("languages"):
        lang_str = ", ".join(cv_data["languages"])
        text_parts.append(f"Languages known: {lang_str}.")
                
    return " ".join(text_parts)

def calculate_golden_score(raw_score: float) -> float:
    """Professional normalization formula (Golden Formula)"""
    lower_bound = 0.45 # Fail threshold: Below 45% raw score -> 0 points
    upper_bound = 0.85 # Top threshold: Above 85% raw score -> 100 points
    
    if raw_score <= lower_bound:
        final_score = 0.0
    elif raw_score >= upper_bound:
        final_score = 100.0
    else:
        # Stretch the score within the 45% -> 85% range
        final_score = ((raw_score - lower_bound) / (upper_bound - lower_bound)) * 100
        
    return round(final_score, 2)


# ==========================================
# 3. API ENDPOINTS (Đã tối ưu cho luồng Batch)
# ==========================================

@app.post("/api/match-candidate-to-jobs")
async def match_candidate_to_jobs(request: CandidateToJobsRequest):
    """
    DÀNH CHO ỨNG VIÊN: Truyền 1 CV và N Jobs. Trả về điểm Match để làm Gợi ý Việc làm.
    """
    try:
        rich_cv_text = build_rich_text_from_json(request.cv_data)
        job_texts = [job.description for job in request.jobs]
        
        if not rich_cv_text or not job_texts:
            return JSONResponse(content={"status": "success", "results": []})

        # Encode toàn bộ một lượt (Siêu tốc)
        cv_vector = embedding_model.encode([rich_cv_text])
        job_vectors = embedding_model.encode(job_texts)
        
        # So sánh 1 CV với N Jobs
        similarities = cosine_similarity(cv_vector, job_vectors)[0]
        
        results = []
        for i, job in enumerate(request.jobs):
            raw_score = float(similarities[i])
            final_score = calculate_golden_score(raw_score)
            
            results.append({
                "job_id": job.id,
                "raw_cosine_score": round(raw_score * 100, 2),
                "match_score": final_score
            })
            
        results.sort(key=lambda x: x['match_score'], reverse=True)
        return JSONResponse(content={"status": "success", "results": results})
        
    except Exception as e:
        return JSONResponse(content={"status": "error", "message": str(e)}, status_code=500)


@app.post("/api/match-job-to-candidates")
async def match_job_to_candidates(request: JobToCandidatesRequest):
    """
    DÀNH CHO HR: Truyền 1 Job Description và N CVs. Trả về điểm Match để Xếp hạng Ứng viên.
    """
    try:
        job_text = request.job_description
        cv_texts = []
        valid_cv_ids = []
        
        for cv in request.cvs:
            text = build_rich_text_from_json(cv.cv_data)
            if text.strip():
                cv_texts.append(text)
                valid_cv_ids.append(cv.id)
                
        if not job_text or not cv_texts:
            return JSONResponse(content={"status": "success", "results": []})

        # Encode toàn bộ
        job_vector = embedding_model.encode([job_text])
        cv_vectors = embedding_model.encode(cv_texts)
        
        # So sánh 1 Job với N CVs
        similarities = cosine_similarity(job_vector, cv_vectors)[0]
        
        results = []
        for i, cv_id in enumerate(valid_cv_ids):
            raw_score = float(similarities[i])
            final_score = calculate_golden_score(raw_score)
            
            results.append({
                "cv_id": cv_id,
                "raw_cosine_score": round(raw_score * 100, 2),
                "match_score": final_score
            })
            
        results.sort(key=lambda x: x['match_score'], reverse=True)
        return JSONResponse(content={"status": "success", "results": results})
        
    except Exception as e:
        return JSONResponse(content={"status": "error", "message": str(e)}, status_code=500)