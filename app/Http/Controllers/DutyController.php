<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDutyRequest;
use App\Http\Requests\UpdateDutyRequest;
use Illuminate\Http\Request;
use App\Http\Resources\DutyResource;
use App\Models\Duty;
use Inertia\Inertia;

class DutyController extends Controller
{
    public function index(Request $request)
    {
        $dutiesQuery = Duty::search($request);
        $duties = DutyResource::collection($dutiesQuery->paginate(10));

        return Inertia::render('Duties/Index', [
            'duties' => $duties
        ]);
    }

    public function create()
    {
        return Inertia::render('Duties/Create');
    }

    public function store(StoreDutyRequest $request)
    {
        Duty::create($request->validated());
        return redirect()->route('duties.index');
    }

    public function edit(Duty $duty) {
        return Inertia('Duties/Edit', [
            'duty' => DutyResource::make($duty)
        ]);
    }

    public function update(UpdateDutyRequest $request, Duty $duty)
    {
        $duty->update($request->validated());
        return redirect()->route('duties.index');
    }

    public function destroy(Duty $duty)
    {
        $duty->delete();
        return redirect()->back();
    }
}
