<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'candidate_id',
        'job_post_id',
        'cv_id',
        'match_score',
        'status'
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateProfile::class, 'candidate_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

    public function logs()
    {
        return $this->hasMany(ApplicationLog::class);
    }

    public function aiMatchingLog()
    {
        return $this->hasOne(AiMatchingLog::class);
    }
    public function aiMatching()
    {
        return $this->hasOne(\App\Models\AiMatchingLog::class, 'application_id');
    }
}