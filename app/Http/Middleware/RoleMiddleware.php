<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Chưa đăng nhập → về login
        if (!auth()->check()) {
            return redirect('/login');
        }

        $userRole = strtolower(trim(auth()->user()->role));
        $requiredRole = strtolower($role);

        // Không đúng role → chặn
        if ($userRole !== $requiredRole) {
            abort(403, 'Bạn không có quyền truy cập');
        }

        return $next($request);
    }
}