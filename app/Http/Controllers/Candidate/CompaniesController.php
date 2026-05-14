<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Danh sách công ty
     */
    public function index(Request $request)
    {
        $query = Company::query();

        // Search theo tên công ty
        if ($request->filled('keyword')) {
            $query->where('company_name', 'like', '%' . $request->keyword . '%');
        }

        // Filter theo lĩnh vực
        if ($request->filled('industry')) {
            $query->where('industry', $request->industry);
        }

        // Lấy công ty mới nhất
        $companies = $query
            ->latest()
            ->paginate(9);

        // Danh sách ngành nghề
        $industries = Company::whereNotNull('industry')
            ->distinct()
            ->pluck('industry');

        return view('candidate.company.companies', compact(
            'companies',
            'industries'
        ));
    }

    /**
     * Chi tiết công ty
     */
    public function show($id)
    {
        $company = Company::with([
            'jobPosts.skills'
        ])->findOrFail($id);

        // Danh sách jobs
        $jobs = $company->jobPosts()
            ->latest()
            ->paginate(10);

        // Stats
        $stats = [
            'total_jobs' => $company->jobPosts()->count(),

            // nếu có cột status
            'active_jobs' => $company->jobPosts()
                ->where('status', 'open')
                ->count(),
        ];

        return view('candidate.company.company_detail', compact(
            'company',
            'jobs',
            'stats'
        ));
    }
}