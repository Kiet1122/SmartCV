<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = [
        'user_id',
        'file_url',
        'raw_text',
        'parsed_data',
        'experience_years',
        'is_default'
    ];

    protected $casts = [
        'parsed_data' => 'array',
        'is_default' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'cv_skill');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'cv_language')
            ->withPivot('proficiency');
    }
}