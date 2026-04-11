TÀI LIỆU ĐẶC TẢ DỰ ÁN: SMARTCV (AI-POWERED ATS)

#I. Tổng quan dự án (Project Overview)
SmartCV là một nền tảng tuyển dụng và quản lý hồ sơ ứng viên (Applicant Tracking System - ATS) thông minh. Dự án ứng dụng kiến trúc Microservices, kết hợp giữa hệ thống Web truyền thống và các mô hình Trí tuệ nhân tạo (AI) tiên tiến để tự động hóa quy trình tuyển dụng. 

Hệ thống giải quyết hai bài toán lớn:
1. Đối với Ứng viên: Tự động đọc hiểu và bóc tách dữ liệu từ CV (PDF/Word) thay vì phải nhập liệu thủ công.
2. Đối với Nhà tuyển dụng: Tự động chấm điểm độ phù hợp (Match Score) giữa CV và Yêu cầu công việc (JD), giúp lọc hồ sơ nhanh chóng và chính xác.

#II. Kiến trúc & Công nghệ (Tech Stack)
Dự án được phân tách thành 2 hệ thống cốt lõi giao tiếp với nhau qua API:

 Hệ thống Web lõi (Backend/Frontend):
   Framework: PHP (Laravel)
   Giao diện: Blade Template, Tailwind CSS
   Cơ sở dữ liệu: MySQL
 Hệ thống AI Microservices (Xử lý ngầm):
   Framework: Python (FastAPI)
   AI Model 1: Llama 3 / Groq API (Dùng để Extract JSON từ văn bản CV).
   AI Model 2: MiniLM (Sentence-Transformers) (Dùng để tính toán Vector Embeddings và Cosine Similarity).

#III. Phân quyền Người dùng (Actors)
Hệ thống được thiết kế phục vụ 4 nhóm đối tượng:
1. Guest (Khách vãng lai): Xem tin tuyển dụng, xem danh sách công ty.
2. Candidate (Ứng viên): Người tìm việc, tải CV lên hệ thống.
3. Recruiter (Nhà tuyển dụng / HR): Đăng tin tuyển dụng, quản lý quy trình xét duyệt hồ sơ.
4. Admin (Quản trị viên): Quản lý toàn bộ hệ thống, kiểm duyệt nội dung, theo dõi log AI.

---

#IV. Đặc tả Chức năng Cốt lõi (Core Features)

##1. Phân hệ Ứng viên (Candidate Module)
 Smart CV Parser: Người dùng tải lên file PDF, hệ thống gọi AI để tự động trích xuất thông tin (Kinh nghiệm, Kỹ năng, Học vấn) thành form dữ liệu chuẩn. Ứng viên có thể review và chỉnh sửa lại trước khi lưu.
 Quản lý Kho CV: Lưu trữ nhiều phiên bản CV khác nhau, cài đặt CV mặc định.
 Ứng tuyển Nhanh (1-Click Apply): Nộp đơn vào các Job đang mở chỉ với một click chọn CV.
 AI Job Recommendation: Hệ thống tự động đề xuất các công việc phù hợp dựa trên kỹ năng có trong CV mặc định.
 Theo dõi Trạng thái (Application Tracking): Xem CV của mình đang ở vòng nào (Chờ duyệt, Phỏng vấn, Rớt).

##2. Phân hệ Nhà tuyển dụng (Recruiter Module)
 Quản lý Chiến dịch Tuyển dụng (Job Posting): Tạo, chỉnh sửa, đóng/mở các tin đăng tuyển.
 Smart ATS Dashboard (Bảng xếp hạng AI): Tự động danh sách ứng viên nộp vào 1 Job theo Điểm số phù hợp (Match Score) từ cao xuống thấp.
 AI Insights (Giải thích điểm số): Màn hình chia đôi hiển thị CV gốc và Báo cáo AI:
   Highlight kỹ năng ứng viên đáp ứng được (Matched Skills).
   Báo cáo các kỹ năng ứng viên còn thiếu (Missing Skills).
 Quản lý Quy trình (Pipeline): Chuyển trạng thái ứng viên (Pending $\rightarrow$ Interview $\rightarrow$ Rejected) và gửi thông báo.

##3. Phân hệ Quản trị (Admin Module)
 Kiểm duyệt Nội dung (Moderation): Duyệt hoặc gỡ bỏ các tin tuyển dụng vi phạm, khóa tài khoản người dùng lạm dụng hệ thống.
 Quản lý Danh mục chuẩn (Master Data): Chuẩn hóa từ điển Kỹ năng (Skills) và Ngôn ngữ (Languages) để AI so khớp chính xác (VD: Gom "ReactJS", "React.js" thành ID chuẩn "React").
 AI Matching Logs: Lưu vết toàn bộ các lần tính toán điểm của AI (Tốc độ xử lý, Model sử dụng, Điểm thô) để kiểm toán tính minh bạch.

---

#V. Luồng nghiệp vụ AI cốt lõi (AI Core Flows)

Luồng 1: Bóc tách CV (CV Parsing Flow)
1. Ứng viên upload file `CV.pdf` qua màn hình Laravel.
2. Laravel gửi file qua cổng `8000` (FastAPI).
3. Python dùng `pdfplumber` đọc text, đẩy prompt vào `Llama 3` yêu cầu trả về chuẩn định dạng JSON.
4. Python trả JSON về cho Laravel.
5. Laravel hiển thị JSON lên màn hình để ứng viên kiểm tra (Review Parsed Data).

Luồng 2: Chấm điểm So khớp (Semantic Matching Flow)
1. HR bấm xem danh sách ứng viên của Job A.
2. Laravel gom mảng `[Kỹ năng CV]` và `[Yêu cầu JD]` gửi sang cổng `8001` (FastAPI).
3. Python dùng mô hình `MiniLM` biến 2 đoạn text thành 2 mảng Vector toán học.
4. Tính toán Cosine Similarity giữa 2 Vector để ra phần trăm ($0.0 \rightarrow 1.0 \sim 0\% \rightarrow 100\%$).
5. Python trả điểm số về, Laravel sắp xếp bảng ứng viên theo thứ tự điểm số từ cao xuống thấp.