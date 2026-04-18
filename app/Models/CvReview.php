<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvReview extends Model
{
    protected $fillable = [
        'cv_id',
        'score',
        'summary',
        'strengths',
        'weaknesses',
        'suggestions',
        'is_valid',
        'validator_reason'
    ];

    // Chuyển chuỗi JSON trong DB thành mảng PHP tự động
    protected $casts = [
        'strengths' => 'array',
        'weaknesses' => 'array',
        'suggestions' => 'array',
        'is_valid' => 'boolean'
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}