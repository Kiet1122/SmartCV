<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\CandidateProfile;
use App\Models\User;


class ProfileController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa hồ sơ
     */
    public function edit()
    {
        $user = Auth::user();
        // Load quan hệ profile nếu bạn đã định nghĩa trong Model User
        // Nếu chưa, chúng ta lấy trực tiếp từ bảng candidate_profiles
        $profile = $user->candidateProfile;

        return view('candidate.profile', compact('user', 'profile'));
    }

    /**
     * Cập nhật thông tin hồ sơ
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Họ và tên không được để trống.',
        ]);

        // 2. Cập nhật bảng users
        $user->update([
            'name' => $request->name,
        ]);

        // 3. Cập nhật bảng candidate_profiles
        // Sử dụng updateOrCreate để đảm bảo nếu chưa có profile thì sẽ tự tạo mới
        $user->candidateProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'address' => $request->address,
                'bio' => $request->bio,
            ]
        );

        return back()->with('success', 'Hồ sơ cá nhân đã được cập nhật thành công!');
    }

    public function updateAvatar(Request $request)
    {
        // Kiểm tra file hợp lệ (tối đa 2MB)
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'avatar.image' => 'File tải lên phải là hình ảnh.',
            'avatar.max' => 'Dung lượng ảnh không được vượt quá 2MB.'
        ]);

        $user = Auth::user();

        // Lấy profile hiện tại (nếu chưa có thì tạo mới)
        // Đổi từ $user->profile() thành $user->candidateProfile()
        $profile = $user->candidateProfile()->firstOrCreate(['user_id' => $user->id]);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar && Storage::disk('public')->exists($profile->avatar)) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $profile->update(['avatar' => $path]);
        }

        return back()->with('success', 'Đã cập nhật ảnh đại diện thành công!');
    }
}