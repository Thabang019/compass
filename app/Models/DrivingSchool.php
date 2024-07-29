<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingSchool extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'user_id',
        'name',
        'phone_number',
        'image',
        'location',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function instructors()
    {
        return $this->hasMany(Vehicle::class);
    }
}
