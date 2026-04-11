<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

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

    // Quan hệ
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
        return $this->hasMany(Cv::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }
}
