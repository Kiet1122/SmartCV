<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function cvs()
    {
        return $this->belongsToMany(Cv::class, 'cv_language')
            ->withPivot('proficiency');
    }
}