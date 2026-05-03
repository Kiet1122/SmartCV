<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'description',
        'experience_required',
        'education_required',
        'salary_range',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_post_skill', 'job_post_id', 'skill_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function savedBy()
    {
        return $this->belongsToMany(
            CandidateProfile::class,
            'saved_jobs',
            'job_post_id',
            'candidate_id'
        );
    }
}