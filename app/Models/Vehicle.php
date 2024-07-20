<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'driving_school_id',
        'registration_number',
        'code',
        'vin_number',
        'status',
    ];

    public function drivingSchool()
    {
        return $this->belongsTo(DrivingSchool::class);
    }
}
