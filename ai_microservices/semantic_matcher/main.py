from fastapi import FastAPI
from fastapi.responses import JSONResponse
from pydantic import BaseModel
from typing import Dict, Any
from sentence_transformers import SentenceTransformer
from sklearn.metrics.pairwise import cosine_similarity

app = FastAPI()

print("Loading Multilingual AI model...")  
# Upgraded to a model with excellent multilingual support (approx. 400MB)
embedding_model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')
print("Matching system is ready!")

class MatchRequest(BaseModel):
    cv_data: Dict[str, Any]
    job_description: str

def build_rich_text_from_json(cv_data: dict) -> str:
    """Helper function to convert JSON CV data into a rich text block for embedding"""
    text_parts = []
    
    if cv_data.get("summary"):
        text_parts.append(f"Summary: {cv_data['summary']}")
        
    if cv_data.get("experience_years"):
        text_parts.append(f"Total work experience: {cv_data['experience_years']} years.")
        
    if cv_data.get("skills"):
        skills_str = ", ".join(cv_data['skills'])
        text_parts.append(f"Professional skills: {skills_str}.")
        
    if cv_data.get("work_experience"):
        for job in cv_data["work_experience"]:
            title = job.get('job_title', '')
            desc = job.get('description', '')
            if title or desc:
                text_parts.append(f"Worked as {title}. Job details: {desc}.")
                
    if cv_data.get("education"):
        for edu in cv_data["education"]:
            degree = edu.get('degree', '')
            if degree:
                text_parts.append(f"Education: {degree}.")
                
    return " ".join(text_parts)

@app.post("/api/match")
async def match_cv_job(request: MatchRequest):
    try:
        rich_cv_text = build_rich_text_from_json(request.cv_data)
        
        embeddings = embedding_model.encode([rich_cv_text, request.job_description])
        cv_vector = embeddings[0].reshape(1, -1)
        job_vector = embeddings[1].reshape(1, -1)
        
        # 1. Calculate raw Cosine score
        raw_score = float(cosine_similarity(cv_vector, job_vector)[0][0])
        
        # 2. Professional normalization formula (Golden Formula)
        lower_bound = 0.45 # Fail threshold: Below 45% raw score -> 0 points
        upper_bound = 0.85 # Top threshold: Above 85% raw score -> 100 absolute points
        
        if raw_score <= lower_bound:
            final_score = 0.0
        elif raw_score >= upper_bound:
            final_score = 100.0
        else:
            # Stretch the score within the 45% -> 85% range
            final_score = ((raw_score - lower_bound) / (upper_bound - lower_bound)) * 100
            
        final_score = round(final_score, 2)
        
        return JSONResponse(content={
            "status": "success",
            "raw_cosine_score": round(raw_score * 100, 2), # Output raw score for reference/logging
            "match_score": final_score,                    # Normalized score (Used to save in DB)
            "message": "Match score calculated successfully"
        })
        
    except Exception as e:
        return JSONResponse(content={"status": "error", "message": str(e)}, status_code=500)