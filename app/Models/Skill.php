<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function cvs()
    {
        return $this->belongsToMany(Cv::class, 'cv_skill');
    }

    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'job_post_skill');
    }
}
