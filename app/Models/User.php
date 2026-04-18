<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function cvs()
    {
        return $this->hasMany(Cv::class, 'user_id', 'id');
    }

    public function savedJobs()
    {
        return $this->belongsToMany(JobPost::class, 'saved_jobs', 'candidate_id', 'job_post_id')
            ->withPivot('created_at')
            ->orderByPivot('created_at', 'desc');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }
}
