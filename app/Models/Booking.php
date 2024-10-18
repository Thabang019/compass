<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'driving_school_name',
        'total_price',
    ];

    // A booking can have many lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    // A booking belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
