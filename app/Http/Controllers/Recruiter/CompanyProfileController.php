<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Thêm thư viện để xử lý file
use App\Models\Company;

class CompanyProfileController extends Controller
{
    // Hiển thị trang chỉnh sửa
    public function edit()
    {
        // Sử dụng quan hệ đã định nghĩa trong User Model
        $company = Auth::user()->company;

        if (!$company) {
            return redirect()->route('recruiter.dashboard')->with('error', 'Không tìm thấy thông tin công ty.');
        }

        return view('recruiter.company_profile', compact('company'));
    }

    // Cập nhật thông tin
    public function update(Request $request)
    {
        $company = Auth::user()->company;

        $request->validate([
            'company_name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'address' => 'nullable|string|max:255', // Thêm validation cho address
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'company_name.required' => 'Tên công ty không được để trống.',
            'website.url' => 'Địa chỉ website không đúng định dạng.',
            'logo.image' => 'File tải lên phải là hình ảnh.',
        ]);

        // Lấy các dữ liệu text
        $data = $request->only(['company_name', 'website', 'address', 'description']);

        // Xử lý upload Logo
        if ($request->hasFile('logo')) {
            // 1. Xóa logo cũ nếu có để tiết kiệm bộ nhớ
            if ($company->logo_url && Storage::disk('public')->exists($company->logo_url)) {
                Storage::disk('public')->delete($company->logo_url);
            }

            // 2. Lưu logo mới vào thư mục 'logos' trên disk 'public'
            $path = $request->file('logo')->store('logos', 'public');

            // 3. Gán vào cột logo_url (khớp với Database của bạn)
            $data['logo_url'] = $path;
        }

        // Cập nhật vào Database
        $company->update($data);

        return back()->with('success', 'Hồ sơ công ty đã được cập nhật thành công!');
    }
}