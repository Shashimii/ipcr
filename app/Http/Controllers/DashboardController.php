<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssignedDutyResource;
use App\Http\Resources\DutyResource;
use App\Http\Resources\OfficerResource;
use App\Models\AssignedDuty;
use App\Models\Officer;
use App\Models\Duty;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {

        $officers = OfficerResource::collection(Officer::all());
        $duties = DutyResource::collection(Duty::all());
        $assignedDuties = AssignedDutyResource::collection(AssignedDuty::all());

        return Inertia::render('Dashboard', [
            'officers' => $officers,
            'duties' => $duties,
            'assignedDuties' => $assignedDuties
        ]);
    }
}
