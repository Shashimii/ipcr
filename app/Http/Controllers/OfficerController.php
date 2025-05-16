<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
}
