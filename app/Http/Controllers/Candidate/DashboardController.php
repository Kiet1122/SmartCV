<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Cv;
use App\Models\SavedJob; // Thêm model này nếu có

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 📊 Stats
        $stats = [
            'total_cv' => Cv::where('user_id', $user->id)->count(),
            'applied_jobs' => Application::where('candidate_id', $user->id)->count(),
            'saved_jobs' => 0,
            'views' => Application::where('candidate_id', $user->id)
                ->whereNotNull('match_score')
                ->count()
        ];

        // 📄 Recent Applications
        $applications = Application::with('jobPost.company')
            ->where('candidate_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('candidate.dashboard', compact('user', 'stats', 'applications'));
    }
}