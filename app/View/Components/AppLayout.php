<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;

        $drivingSchoolId = $drivingSchool ? $drivingSchool->id : null;

        return view('layouts.app', ['driving_school_id' => $drivingSchoolId]);
    }
}