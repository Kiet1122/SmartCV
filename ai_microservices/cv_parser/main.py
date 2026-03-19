# import fitz  # Thư viện PyMuPDF
# import json
# import datetime
# from fastapi import FastAPI, UploadFile, File
# from fastapi.responses import JSONResponse
# from openai import OpenAI

# app = FastAPI()

# # Khởi tạo Client kết nối đến Groq API (Biến toàn cục)
# client = OpenAI(
#     api_key=os.getenv("GROQ_API_KEY"), # API Key của bạn
#     base_url="https://api.groq.com/openai/v1"
# )

# def extract_text_from_pdf(file_bytes):
#     """Hàm đọc file PDF và trả về văn bản thô"""
#     text = ""
#     doc = fitz.open(stream=file_bytes, filetype="pdf")
#     for page in doc:
#         text += page.get_text()
#     return text

# def calculate_exact_experience(work_experience_list):
#     """Hàm tính toán tổng số năm kinh nghiệm bằng Code Python thuần"""
#     total_months = 0
#     now = datetime.datetime.now()
    
#     if not work_experience_list:
#         return 0.0
        
#     for job in work_experience_list:
#         try:
#             start_y = job.get("start_year")
#             start_m = job.get("start_month") or 1
#             is_current = job.get("is_current", False)
            
#             # Nếu AI không bóc tách được năm bắt đầu thì bỏ qua công việc này
#             if not start_y:
#                 continue
                
#             # Xác định thời gian kết thúc
#             if is_current:
#                 end_y = now.year
#                 end_m = now.month
#             else:
#                 end_y = job.get("end_year") or now.year
#                 end_m = job.get("end_month") or 1
                
#             # Tính toán tổng số tháng cho công việc này
#             months = (end_y - start_y) * 12 + (end_m - start_m)
            
#             if months > 0:
#                 total_months += months
                
#         except Exception:
#             continue
            
#     # Trả về số năm (làm tròn 1 chữ số thập phân, VD: 6.5)
#     return round(total_months / 12, 1)

# def parse_cv_with_groq(raw_text):
#     """Hàm yêu cầu AI bóc tách dữ liệu ra thành các trường cấu trúc bằng Tiếng Anh"""
#     prompt = f"""
#     You are an expert Human Resources (HR) professional. Read the raw CV text below and extract the information into a structured JSON format.
#     You MUST return a valid JSON object. If information for a specific field is not found, leave it as an empty array [] or null.
#     Absolutely do not calculate the total years of experience yourself.
    
#     CRITICAL: You must translate ALL extracted content (including summary, descriptions, job titles, etc.) into ENGLISH, regardless of the original language of the CV.

#     Required JSON Structure:
#     {{
#         "personal_info": {{
#             "name": "Candidate Name",
#             "email": "Email",
#             "phone": "Phone Number"
#         }},
#         "skills": ["Skill 1", "Skill 2"],
#         "summary": "Brief summary of competencies in 2 sentences",
#         "education": [
#             {{
#                 "degree": "Degree Name or Major",
#                 "institution": "Institution Name",
#                 "start_year": 2018,
#                 "end_year": 2022
#             }}
#         ],
#         "work_experience": [
#             {{
#                 "job_title": "Job Title",
#                 "company": "Company Name",
#                 "start_month": 1,
#                 "start_year": 2014,
#                 "end_month": 9,
#                 "end_year": 2017,
#                 "is_current": false,
#                 "description": "Brief description of tasks performed"
#             }}
#         ],
#         "certifications": ["Certification Name 1", "Certification Name 2"],
#         "languages": ["Language 1", "Language 2"]
#     }}

#     IMPORTANT NOTES FOR 'work_experience':
#     - If it is the current job (e.g., working until "present", "now", "hiện tại"), set "is_current": true and leave "end_month" and "end_year" as null.
#     - If the CV does not explicitly state the month, leave "start_month" and "end_month" as null.

#     Raw CV text:
#     {raw_text}
#     """

#     try:
#         response = client.chat.completions.create(
#             model="llama-3.3-70b-versatile",
#             messages=[
#                 {"role": "system", "content": "You are a data extraction API. You strictly output valid JSON objects matching the requested schema in English."},
#                 {"role": "user", "content": prompt}
#             ],
#             temperature=0.1,
#             response_format={"type": "json_object"}
#         )

#         result_text = response.choices[0].message.content.strip()
#         return json.loads(result_text)
#     except Exception as e:
#         print(f"Lỗi khi bóc tách bằng Groq: {e}")
#         return None

# @app.post("/api/parse-cv")
# async def parse_cv(file: UploadFile = File(...)):
#     try:
#         # 1. Đọc file
#         file_bytes = await file.read()
#         raw_text = extract_text_from_pdf(file_bytes)
        
#         # 2. Bắt AI bóc tách ngữ nghĩa
#         parsed_data = parse_cv_with_groq(raw_text)
        
#         if not parsed_data:
#             return JSONResponse(content={"status": "error", "message": "Failed to parse CV with AI."}, status_code=500)
            
#         # 3. Backend tự động tính toán kinh nghiệm bằng Code truyền thống
#         if "work_experience" in parsed_data:
#             calculated_years = calculate_exact_experience(parsed_data["work_experience"])
#             parsed_data["experience_years"] = calculated_years # Bơm ngược vào JSON
#         else:
#             parsed_data["experience_years"] = 0.0
        
#         # 4. Trả về kết quả hoàn chỉnh
#         return JSONResponse(content={
#             "status": "success",
#             "raw_text": raw_text,
#             "parsed_data": parsed_data
#         })
        
#     except Exception as e:
#         return JSONResponse(content={"status": "error", "message": str(e)}, status_code=500)