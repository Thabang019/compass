<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'date',
        'start_time',
        'end_time',
        'lesson_type',
        'vehicle_registration',
        'instructor_name',
        'lesson_price',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
