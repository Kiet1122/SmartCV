<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Application;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ với danh sách việc làm mới nhất
     */
    public function index()
    {
        $featuredJobs = JobPost::with('company')
            ->where('status', 'open')
            ->latest()
            ->take(4)
            ->get();

        return view('public.home', compact('featuredJobs'));
    }

    public function about()
    {
        return view('public.about');
    }
}