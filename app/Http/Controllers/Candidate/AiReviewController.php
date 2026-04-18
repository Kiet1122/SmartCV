<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Cv;
use App\Models\CvReview;

class AiReviewController extends Controller
{
    // Hiển thị trang chọn CV
    public function index()
    {
        $cvs = Auth::user()->cvs()->whereNotNull('parsed_data')->get();
        return view('candidate.ai_review.index', compact('cvs'));
    }

    // Xử lý luồng: Kiểm tra DB -> Gọi AI (nếu cần) -> Lưu kết quả -> Trả về View
    public function process(Request $request)
    {
        $request->validate(['cv_id' => 'required|exists:cvs,id']);
        $cv = Cv::findOrFail($request->cv_id);

        // ==========================================
        // BƯỚC 1: CHECK DB
        // ==========================================
        $existingReview = CvReview::where('cv_id', $cv->id)->first();

        if ($existingReview) {
            return response()->json([
                'success' => true,
                'from_cache' => true, // 🔥 rất quan trọng cho UI
                'review_status' => $existingReview->is_valid
                    ? ($existingReview->score >= 8 ? 'approved' : 'needs_improvement')
                    : 'rejected_by_qa',
                'validator_reason' => $existingReview->validator_reason ?? 'Loaded from history',
                'review_data' => [
                    'score' => $existingReview->score,
                    'summary' => $existingReview->summary,
                    'strengths' => $existingReview->strengths ?? [],
                    'weaknesses' => $existingReview->weaknesses ?? [],
                    'suggestions' => $existingReview->suggestions ?? [],
                ]
            ]);
        }

        // ==========================================
        // BƯỚC 2: CALL AI
        // ==========================================
        try {
            $response = Http::timeout(45)->post('http://localhost:8002/api/review', [
                'cv_data' => $cv->parsed_data
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $reviewData = $result['review_data'] ?? [];
                $isValid = ($result['review_status'] !== 'rejected_by_qa');

                // Save DB
                CvReview::create([
                    'cv_id' => $cv->id,
                    'score' => $reviewData['score'] ?? 0,
                    'summary' => $reviewData['summary'] ?? null,
                    'strengths' => $reviewData['strengths'] ?? [],
                    'weaknesses' => $reviewData['weaknesses'] ?? [],
                    'suggestions' => $reviewData['suggestions'] ?? [],
                    'is_valid' => $isValid,
                    'validator_reason' => $result['validator_reason'] ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'from_cache' => false, // 🔥 phân biệt AI vs cache
                    'review_status' => $isValid
                        ? ($reviewData['score'] >= 8 ? 'approved' : 'needs_improvement')
                        : 'rejected_by_qa',
                    'validator_reason' => $result['validator_reason'] ?? null,
                    'review_data' => $reviewData
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'AI Service error: ' . $response->body()
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to AI service',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}