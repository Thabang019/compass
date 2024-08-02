<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\DrivingSchool;

class SystemAdminController extends Controller

{
    public function dashboard() : View
    {
        $allDrivingSchools = DrivingSchool::where('status', 'approved')->get();
        $drivingSchools = DrivingSchool::where('status', 'pending')->get();
        return view('systemAdmin.dashboard', compact('allDrivingSchools','drivingSchools'));
    }

}
