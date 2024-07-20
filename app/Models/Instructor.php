<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = ['driving_school_id','user_id', 'name', 'phone_number', 'status'];

    public function drivingSchool()
    {
        return $this->belongsTo(DrivingSchool::class);
    }
}
