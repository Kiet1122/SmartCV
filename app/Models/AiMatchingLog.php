<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiMatchingLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'application_id',
        'model_used',
        'raw_score',
        'final_score',
        'processing_time_ms'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}