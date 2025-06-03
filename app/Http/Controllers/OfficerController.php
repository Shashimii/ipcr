<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficerRequest;
use App\Http\Requests\UpdateOfficerRequest;
use App\Http\Resources\OfficerResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficerController extends Controller
{
    public function index(Request $request)
    {
        $officersQuery = User::search($request);
        $officers = OfficerResource::collection($officersQuery->where('role', 0)->paginate(10));

        return Inertia::render('Officers/Index', [
            'officers' => $officers
        ]);
    }

    public function create()
    {
        return redirect()->route('admin.register');
    }

    public function edit(User $officer)
    {
        return Inertia('Officers/Edit', [
            'officer' => OfficerResource::make($officer)
        ]);
    }

    public function update(UpdateOfficerRequest $request, User $officer)
    {
        $officer->update($request->validated());
        return redirect()->route('officers.index');
    }

    public function destroy(User $officer)
    {
        $officer->delete();
        return redirect()->back();
    }
}
