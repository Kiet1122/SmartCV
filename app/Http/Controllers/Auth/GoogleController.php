<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $existingUser = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($existingUser) {
                if (!$existingUser->google_id) {
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }

                // Đề phòng trường hợp user cũ là ứng viên nhưng trước đó bị lỗi chưa có profile
                if ($existingUser->role === 'candidate' && !$existingUser->candidateProfile) {
                    $profile = new CandidateProfile();
                    $profile->user_id = $existingUser->id;
                    $profile->save();
                }

                Auth::login($existingUser);

            } else {
                $newUser = User::create([
                    'name' => $googleUser->getName() ?? 'Google User',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'role' => 'candidate',
                    // BẮT BUỘC PHẢI CÓ để tránh lỗi cột password not null trong DB
                    'password' => Hash::make(Str::random(24)),
                ]);

                // 👉 TẠO PROFILE (Dùng cách này để lách lỗi $fillable)
                $profile = new CandidateProfile();
                $profile->user_id = $newUser->id;
                $profile->save();

                Auth::login($newUser);
            }

            return $this->redirectByRole(Auth::user());

        } catch (Exception $e) {
            // 👉 GHI LOG ĐỂ BIẾT CHÍNH XÁC LỖI GÌ
            Log::error('Lỗi đăng nhập Google: ' . $e->getMessage());

            // Tạm thời in thẳng lỗi ra màn hình để bạn dễ debug (Khi nào web chạy thật thì xóa nối chuỗi $e->getMessage() đi nhé)
            return redirect('/login')->with('error', 'Google Auth failed: ' . $e->getMessage());
        }
    }

    private function redirectByRole($user)
    {
        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'recruiter' => redirect('/recruiter/dashboard'),
            default => redirect('/candidate/dashboard'),
        };
    }
}