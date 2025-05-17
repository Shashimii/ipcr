<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficerRequest;
use App\Http\Resources\OfficerResource;
use App\Models\Officer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficerController extends Controller
{
    public function index()
    {
        $officers = OfficerResource::collection(Officer::all());

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
}
