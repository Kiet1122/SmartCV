
# 🚀 SmartCV - Hệ Thống Tuyển Dụng Thông Minh Tích Hợp AI

<div align="center">
  
<div align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"/>
  <img src="https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white" alt="Python"/>
  <img src="https://img.shields.io/badge/FastAPI-009688?style=for-the-badge&logo=FastAPI&logoColor=white" alt="FastAPI"/>
  <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/Llama_3.1-0467DF?style=for-the-badge&logo=meta&logoColor=white" alt="Llama"/>
</div>

**Nền tảng tuyển dụng thông minh kết nối ứng viên và nhà tuyển dụng bằng sức mạnh của Trí tuệ nhân tạo**

</div>

---

## 📌 Giới thiệu

**SmartCV** là một nền tảng tuyển dụng hiện đại, giải quyết bài toán kết nối giữa ứng viên và nhà tuyển dụng thông qua sức mạnh của **Trí tuệ nhân tạo (AI)**. 

Thay vì sàng lọc hồ sơ thủ công tốn thời gian, hệ thống sử dụng các **Mô hình Ngôn ngữ Lớn (LLM)** và **kỹ thuật nhúng ngữ nghĩa (Semantic Embedding)** để:
- 📄 **Thấu hiểu nội dung CV** của ứng viên một cách chuyên sâu
- 🎯 **Phân tích yêu cầu công việc** từ nhà tuyển dụng
- 🤝 **Đưa ra điểm số tương thích (Match Score)** và gợi ý việc làm chính xác nhất

---

## ✨ Tính năng cốt lõi

### 🎯 Dành cho Ứng viên (Candidate)

| Tính năng | Mô tả |
|-----------|-------|
| **AI CV Parsing** | Tự động bóc tách thông tin từ file CV (PDF/DOCX) sang dữ liệu có cấu trúc |
| **Phân tích CV chuyên sâu** | Nhận đánh giá chi tiết về điểm mạnh, điểm yếu và gợi ý cải thiện từ AI |
| **Gợi ý việc làm thông minh** | Nhận đề xuất việc làm phù hợp dựa trên kỹ năng và kinh nghiệm |
| **Theo dõi trạng thái ứng tuyển** | Quản lý lịch sử ứng tuyển và nhận thông báo kết quả |
| **Lưu tin yêu thích** | Lưu lại những công việc quan tâm để ứng tuyển sau |

### 🏢 Dành cho Nhà tuyển dụng (Recruiter)

| Tính năng | Mô tả |
|-----------|-------|
| **Quản lý tin tuyển dụng** | Đăng, sửa, đóng tin tuyển dụng với quy trình kiểm duyệt AI |
| **Xếp hạng ứng viên thông minh** | Sắp xếp ứng viên theo điểm số tương thích với công việc |
| **Dashboard phân tích** | Biểu đồ thống kê số lượng ứng viên theo thời gian thực |
| **Duyệt hồ sơ & Gửi mail tự động** | Xét duyệt ứng viên và gửi thông báo kết quả qua email |

### 🔧 Dành cho Quản trị viên (Admin)

| Tính năng | Mô tả |
|-----------|-------|
| **Quản lý người dùng** | Xem, chỉnh sửa, khóa tài khoản và chuyển đổi vai trò |
| **Quản lý kỹ năng & ngôn ngữ** | Duy trì danh mục kỹ năng và ngôn ngữ chuẩn hóa |
| **Giám sát AI Logs** | Theo dõi lịch sử matching và hiệu suất xử lý của AI |
| **Thống kê toàn hệ thống** | Dashboard tổng quan về người dùng, việc làm và ứng tuyển |

### 🤖 Hệ thống AI (Microservices)

| Dịch vụ | Cổng | Chức năng |
|---------|------|-----------|
| **CV Parsing** | 8001 | Bóc tách thông tin CV thành cấu trúc JSON |
| **Semantic Matching** | 8002 | Tính điểm tương thích giữa CV và Job Description |
| **Job Approval** | 8003 | Kiểm duyệt nội dung tin tuyển dụng |
| **Dual-Agent Review** | 8080 | Đánh giá CV chéo bằng 2 luồng AI độc lập |

---


**Công nghệ sử dụng:**

| Thành phần | Công nghệ | Vai trò |
|------------|-----------|---------|
| **Web Framework** | Laravel 12.x (PHP) | Xử lý logic nghiệp vụ, database, authentication |
| **AI Framework** | FastAPI (Python) | Cung cấp API cho các tác vụ AI |
| **LLM Model** | Llama 3.1 (8B) | Xử lý ngôn ngữ tự nhiên, phân tích CV |
| **Embedding Model** | sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2 | Tạo vector nhúng đa ngôn ngữ |
| **Database** | MySQL 8.0 | Lưu trữ dữ liệu người dùng, việc làm, ứng tuyển |
| **Frontend** | TailwindCSS + Alpine.js | Giao diện responsive, tương tác mượt mà |

---

## 🛠️ Hướng dẫn cài đặt

### Yêu cầu hệ thống

| Công cụ | Phiên bản tối thiểu |
|---------|---------------------|
| PHP | 8.1+ |
| Composer | 2.x |
| Node.js | 18.x+ |
| Python | 3.10+ |
| MySQL | 8.0+ |
| RAM | 8GB (khuyến nghị 16GB cho AI) |

### 1. Web Server (Laravel)

```bash
# Clone dự án
git clone https://github.com/Kiet1122/SmartCV.git
cd SmartCV

# Cài đặt các thư viện PHP
composer install

# Cài đặt các thư viện Node.js (CSS, JS)
npm install
npm run build

# Cấu hình môi trường
cp .env.example .env
php artisan key:generate

# Cấu hình database trong file .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=smartcv
# DB_USERNAME=root
# DB_PASSWORD=yourpassword

# Chạy migration và tạo dữ liệu mẫu
php artisan migrate --seed

# Khởi chạy server Laravel
php artisan serve
# Server chạy tại: http://localhost:8000
```

### 2. AI Service (Python Microservices)

Hệ thống AI được chia thành nhiều dịch vụ chạy song song trên các Port khác nhau:

| Dịch vụ | Port | Chức năng |
|---------|------|-----------|
| CV Parsing | 8001 | Bóc tách thông tin CV |
| Semantic Matching | 8002 | Tính điểm tương thích |
| Job Approval | 8003 | Kiểm duyệt tin tuyển dụng |
| Dual-Agent | 8080 | Đánh giá CV chéo |

```bash
# Mở một Terminal/PowerShell mới tại thư mục gốc của dự án (SmartCV)

# Tạo môi trường ảo Python
python -m venv venv

# Kích hoạt môi trường ảo
# Trên Windows:
venv\Scripts\activate
# Trên macOS/Linux:
source venv/bin/activate

# Cài đặt các thư viện AI cần thiết
pip install -r requirements.txt

# Khởi chạy đồng loạt tất cả các AI Microservices
python ai_microservices/run_all.py
```

**Lưu ý quan trọng:** 
- Lần chạy đầu tiên hệ thống sẽ mất thời gian để tải mô hình `sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2` từ Hugging Face (~500MB)
- Đảm bảo các Port 8001, 8002, 8003, 8080 không bị chiếm dụng

---

## 📁 Cấu trúc thư mục dự án

```
SmartCV/
├── app/                           # Laravel Application Core
│   ├── Http/
│   │   ├── Controllers/           # Controllers xử lý request
│   │   │   ├── Admin/             # Quản trị hệ thống
│   │   │   ├── Candidate/         # Ứng viên
│   │   │   ├── Recruiter/         # Nhà tuyển dụng
│   │   │   └── Public/            # Trang công khai
│   │   └── Middleware/            # Middleware xác thực
│   ├── Models/                    # Eloquent Models
│   └── Mail/                      # Email templates
├── resources/
│   └── views/                     # Blade Templates
│       ├── layouts/               # Layout chính
│       ├── admin/                 # Giao diện Admin
│       ├── candidate/             # Giao diện Ứng viên
│       ├── recruiter/             # Giao diện Nhà tuyển dụng
│       └── public/                # Trang chủ, giới thiệu, liên hệ
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/                   # Dữ liệu mẫu
├── ai_microservices/              # Python AI Microservices
│   ├── run_all.py                 # Khởi chạy tất cả services
│   ├── cv_parser.py               # CV Parsing (Port 8001)
│   ├── semantic_matcher.py        # Semantic Matching (Port 8002)
│   ├── job_approval.py            # Job Approval (Port 8003)
│   ├── dual_agent_review.py       # Dual-Agent Review (Port 8080)
│   └── requirements.txt           # Python dependencies
├── public/
│   └── storage/                   # File uploads (CVs, logos)
├── routes/
│   └── web.php                    # Định tuyến Laravel
└── .env                           # Cấu hình môi trường
```

---

## 👥 Vai trò người dùng & Phân quyền

| Vai trò | Quyền hạn |
|---------|-----------|
| **Admin** | Quản lý toàn hệ thống: người dùng, kỹ năng, ngôn ngữ, AI logs |
| **Recruiter** | Đăng tin tuyển dụng, quản lý ứng viên, dashboard phân tích |
| **Candidate** | Tải CV, xem đánh giá AI, ứng tuyển việc làm, theo dõi trạng thái |
---

## 📝 Nhật ký phát triển (Vibe Coding)

Dự án này được triển khai theo phương pháp **Vibe Coding**, đề cao việc:

- ✅ **Làm chủ kiến trúc** và logic hệ thống
- ✅ **Tận dụng AI làm trợ thủ** để tối ưu hóa tốc độ viết mã
- ✅ **Xử lý lỗi chủ động** dựa trên hiểu biết về luồng dữ liệu
- ✅ **Thiết kế cơ sở dữ liệu** dựa trên nghiên cứu độc lập

Mọi quyết định về luồng dữ liệu và thiết kế cơ sở dữ liệu đều được thực hiện dựa trên nghiên cứu độc lập để đảm bảo tính **học thuật** và **kỹ thuật bền vững**.

---

## 🤝 Liên hệ

- **Tác giả:** Kiet1122
- **Dự án:** Đồ án xây dựng hệ thống tuyển dụng thông minh tích hợp AI
- **Năm thực hiện:** 2026

---

<div align="center">
  
**© 2026 SmartCV Project. All rights reserved.**

*Nền tảng tuyển dụng thông minh - Kết nối nhân tài với cơ hội*

</div>
```
