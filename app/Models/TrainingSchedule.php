<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'coach_id',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
