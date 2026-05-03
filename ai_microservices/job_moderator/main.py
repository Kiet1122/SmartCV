from fastapi import FastAPI
from pydantic import BaseModel
from openai import OpenAI
import json

app = FastAPI()

# Cấu hình kết nối Ollama qua chuẩn OpenAI
client = OpenAI(
    base_url='http://localhost:11434/v1',
    api_key='ollama'  # Ollama không cần key nhưng SDK yêu cầu phải có chuỗi bất kỳ
)

class JobData(BaseModel):
    title: str
    description: str

@app.post("/api/check-job")
async def check_job(job: JobData):
    prompt = f"""
        Bạn là AI kiểm duyệt tin tuyển dụng cho hệ thống SmartCV.

        Hãy phân tích tin sau:

        Tiêu đề: {job.title}
        Mô tả: {job.description}

        TIÊU CHÍ:
        1. Lừa đảo (đa cấp, cờ bạc, kiếm tiền nhanh bất thường)
        2. Nội dung không rõ ràng (mô tả quá ngắn, thiếu trách nhiệm công việc)
        3. Spam / không chuyên nghiệp

        QUY TẮC:
        - Nếu vi phạm bất kỳ tiêu chí nào → is_safe = false
        - Nếu hợp lệ → is_safe = true
        - Chỉ trả về JSON, không giải thích thêm

        FORMAT:
        {{
            "is_safe": true hoặc false,
            "reason": "Lý do ngắn gọn bằng tiếng Việt"
        }}
        """

    try:
        # Sử dụng chat.completions theo chuẩn OpenAI
        response = client.chat.completions.create(
            model="llama3.1:8b",
            messages=[
                {"role": "system", "content": "Bạn là một AI kiểm duyệt nội dung chuyên nghiệp, chỉ trả về JSON."},
                {"role": "user", "content": prompt}
            ],
            response_format={ "type": "json_object" }, # Ép AI trả về JSON
            temperature=0
        )
        
        # Lấy nội dung text từ response
        content = response.choices[0].message.content
        return json.loads(content)

    except Exception as e:
        print(f"Lỗi AI: {e}")
        return {
            "is_safe": True, 
            "reason": "Tạm thời bỏ qua kiểm duyệt do hệ thống AI đang bận."
        }