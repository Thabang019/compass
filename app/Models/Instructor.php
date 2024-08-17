<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = ['name','driving_school_id','user_id', 'phone_number', 'status'];

    public function drivingSchool()
    {
        return $this->belongsTo(DrivingSchool::class);
    }

    public function bookings()
    {
    return $this->hasMany(Booking::class);
    }
}
