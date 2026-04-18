import json
import re
from fastapi import FastAPI, HTTPException
from fastapi.responses import JSONResponse
from pydantic import BaseModel
from typing import Dict, Any
from openai import OpenAI

app = FastAPI()

# Kết nối đến Ollama đang chạy dưới Localhost (Cổng mặc định 11434)
client = OpenAI(
    base_url='http://localhost:11434/v1',
    api_key='ollama' # Tham số bắt buộc phải có nhưng giá trị gì cũng được
)

# Model mặc định sử dụng Llama 3.1 8B của bạn
REVIEW_MODEL = "llama3.1:8b"
VALIDATOR_MODEL = "llama3.1:8b"

class ReviewRequest(BaseModel):
    cv_data: Dict[str, Any]

def extract_json_from_text(text: str) -> dict:
    """Hàm dọn dẹp phòng trường hợp Local Model trả về cả markdown ```json...```"""
    try:
        # Tìm đoạn nằm giữa ngoặc nhọn
        match = re.search(r'\{.*\}', text, re.DOTALL)
        if match:
            return json.loads(match.group(0))
        return json.loads(text)
    except Exception:
        return None

def ai_reviewer_agent(cv_text: str) -> dict:
    """AI SỐ 1: CHUYÊN GIA ĐÁNH GIÁ CV"""
    prompt = f"""
    You are an expert IT Tech Recruiter. Review the following candidate's CV data.
    Provide a professional evaluation strictly in JSON format.
    All feedback must be written in VIETNAMESE language.
    
    Required JSON structure:
    {{
        "score": <float between 1.0 and 10.0>,
        "summary": "<2-3 sentences overall impression in Vietnamese>",
        "strengths": ["<strength 1>", "<strength 2>"],
        "weaknesses": ["<area for improvement 1>", "<area for improvement 2>"],
        "suggestions": ["<actionable advice 1>", "<actionable advice 2>"]
    }}

    Candidate CV Data:
    {cv_text}
    """
    
    print("🤖 [AI 1] Đang phân tích và chấm điểm CV...")
    response = client.chat.completions.create(
        model=REVIEW_MODEL,
        messages=[
            {"role": "system", "content": "You are an HR expert API. Output valid JSON only."},
            {"role": "user", "content": prompt}
        ],
        temperature=0.3 # Giảm nhiệt độ để AI bớt "bay bổng", tập trung vào logic
    )
    
    raw_output = response.choices[0].message.content.strip()
    return extract_json_from_text(raw_output)

def ai_validator_agent(review_data: dict) -> dict:
    """AI SỐ 2: NGƯỜI KIỂM DUYỆT CHẤT LƯỢNG"""
    prompt = f"""
    You are a Quality Assurance (QA) Auditor. Review the following AI-generated CV assessment.
    Check if the assessment is fair, professional, and properly formatted.
    
    Rules:
    1. If the "score" is below 8.0, but the "strengths" are clearly very strong, mark as unfair.
    2. If the text contains strange characters, AI hallucinations, or is not in Vietnamese, mark as invalid.
    
    Review Data to evaluate:
    {json.dumps(review_data, ensure_ascii=False)}
    
    Required JSON structure strictly in English:
    {{
        "is_valid": <boolean true or false>,
        "reason": "<Brief explanation of why it is valid or invalid>"
    }}
    """
    
    print("🛡️ [AI 2] Đang kiểm duyệt lại kết quả của AI 1...")
    response = client.chat.completions.create(
        model=VALIDATOR_MODEL,
        messages=[
            {"role": "system", "content": "You are a strict QA auditor. Output valid JSON only."},
            {"role": "user", "content": prompt}
        ],
        temperature=0.1
    )
    
    raw_output = response.choices[0].message.content.strip()
    return extract_json_from_text(raw_output)


@app.post("/api/review")
async def review_cv(request: ReviewRequest):
    try:
        # Chuyển Dict JSON thành Text thuần để nhét vào Prompt
        cv_text = json.dumps(request.cv_data, ensure_ascii=False, indent=2)
        
        # BƯỚC 1: Gọi AI Reviewer (Tối đa thử 2 lần nếu lỗi)
        review_result = None
        for attempt in range(2):
            review_result = ai_reviewer_agent(cv_text)
            if review_result and "score" in review_result:
                break
                
        if not review_result:
            return JSONResponse(content={"status": "error", "message": "AI 1 không thể tạo Review."}, status_code=500)
            
        # BƯỚC 2: Gọi AI Validator để kiểm tra chéo
        validator_result = ai_validator_agent(review_result)
        
        if not validator_result:
            return JSONResponse(content={"status": "error", "message": "AI 2 gặp lỗi khi kiểm duyệt."}, status_code=500)
            
        # BƯỚC 3: Áp dụng Logic Lọc (Filter)
        is_valid = validator_result.get("is_valid", False)
        score = float(review_result.get("score", 0))
        
        # Quyết định cuối cùng
        if is_valid and score >= 8.0:
            final_status = "approved"
            message = "CV xuất sắc, đạt tiêu chuẩn!"
        elif is_valid and score < 8.0:
            final_status = "needs_improvement"
            message = "CV cần được cải thiện thêm theo gợi ý của AI."
        else:
            final_status = "rejected_by_qa"
            message = f"Bài đánh giá bị AI 2 từ chối vì: {validator_result.get('reason', 'Lý do không rõ')}"

        # BƯỚC 4: Trả kết quả về cho Laravel
        return JSONResponse(content={
            "status": "success",
            "review_status": final_status,
            "validator_reason": validator_result.get("reason", ""),
            "review_data": review_result
        })
        
    except Exception as e:
        return JSONResponse(content={"status": "error", "message": str(e)}, status_code=500)