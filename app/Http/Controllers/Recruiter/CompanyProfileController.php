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
            'email' => 'required|email|max:255',
            'website' => 'nullable|url',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'company_name.required' => 'Tên công ty không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'website.url' => 'Địa chỉ website không đúng định dạng.',
            'logo.image' => 'File tải lên phải là hình ảnh.',
        ]);

        // Lấy dữ liệu text
        $data = $request->only([
            'company_name',
            'email',
            'website',
            'industry',
            'company_size',
            'address',
            'description'
        ]);

        // Upload logo
        if ($request->hasFile('logo')) {

            // Xóa logo cũ
            if ($company->logo_url && Storage::disk('public')->exists($company->logo_url)) {
                Storage::disk('public')->delete($company->logo_url);
            }

            // Lưu logo mới
            $path = $request->file('logo')->store('logos', 'public');

            $data['logo_url'] = $path;
        }

        // Update database
        $company->update($data);

        return back()->with('success', 'Hồ sơ công ty đã được cập nhật thành công!');
    }
}