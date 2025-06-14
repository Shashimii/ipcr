<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAssignedDutyRequest;
use Illuminate\Http\Request;

use App\Http\Requests\StoreAssignedDutyRequest;
use App\Http\Resources\OfficerResource;
use App\Http\Resources\DutyResource;
use App\Http\Resources\AssignedDutyResource;
use App\Models\AssignedDuty;
use App\Models\User;
use App\Models\Duty;
use Inertia\Inertia;

class AssignedDutyController extends Controller
{
    public function index(Request $request)
    {
        // search query
        $assignedDutiesQuery = AssignedDuty::search($request)->with(['officer', 'duty']);

        $assignedDuties = AssignedDutyResource::collection($assignedDutiesQuery->paginate(10));
        $officers = OfficerResource::collection(User::where('role', 0)->get());

        return Inertia::render('AssignedDuties/Index', [
            'search' => $request->search ?? '',
            'officer_id' => $request->officer_id ?? '',
            'status_filter' => $request->status ?? '',
            'assignedDuties' => $assignedDuties,
            'officers' => $officers
        ]);
    }

    public function create()
    {
        $officers = OfficerResource::collection(User::where('role', 0)->get());
        $duties = DutyResource::collection(Duty::all());

        return Inertia::render('AssignedDuties/Create', [
            'officers' => $officers,
            'duties' => $duties
        ]);
    }

    public function store(StoreAssignedDutyRequest $request)
    {
        AssignedDuty::create($request->validated());
        return redirect()->route('assigned-duties.index');
    }

    public function edit(AssignedDuty $assignedDuty)
    {
        $officers = OfficerResource::collection(User::where('role', 0)->get());
        $duties = DutyResource::collection(Duty::all());

        return inertia('AssignedDuties/Edit', [
            'officers' => $officers,
            'duties' => $duties,
            'assigned_duties' => AssignedDutyResource::make($assignedDuty)
        ]);
    }

    public function update(UpdateAssignedDutyRequest $request, AssignedDuty $assignedDuty)
    {
        $assignedDuty->update($request->validated());

        return redirect()->route('assigned-duties.index');
    }

    public function destroy(AssignedDuty $assignedDuty)
    {
        $assignedDuty->delete();
        return redirect()->back();
    }

}
