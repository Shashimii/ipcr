<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficerRequest;
use App\Http\Requests\UpdateOfficerRequest;
use App\Http\Resources\OfficerResource;
use App\Models\Officer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficerController extends Controller
{
    public function index(Request $request)
    {
        $officersQuery = Officer::search($request);
        $officers = OfficerResource::collection($officersQuery->paginate(10));

        return Inertia::render('Officers/Index', [
            'officers' => $officers
        ]);
    }

    public function create()
    {
        return Inertia::render('Officers/Create');
    }

    public function store(StoreOfficerRequest $request)
    {
        Officer::create($request->validated());
        return redirect()->route('officers.index');
    }

    public function edit(Officer $officer)
    {
        return Inertia('Officers/Edit', [
            'officer' => OfficerResource::make($officer)
        ]);
    }

    public function update(UpdateOfficerRequest $request, Officer $officer)
    {
        $officer->update($request->validated());
        return redirect()->route('officers.index');
    }

    public function destroy(Officer $officer)
    {
        $officer->delete();
        return redirect()->back();
    }
}
