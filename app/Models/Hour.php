<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    use HasFactory;

    protected $fillable = [
        'driving_school_id', 'user_id', 'day_of_week', 'opening_time', 'closing_time',
    ];

    public function drivingSchool()
    {
        return $this->belongsTo(DrivingSchool::class);
    }
}
