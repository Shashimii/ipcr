<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DutyResource;
use App\Models\Duty;
use Inertia\Inertia;

class DutyController extends Controller
{
    public function index()
    {
        $duties = DutyResource::collection(Duty::all());

        return Inertia::render('Duties/Index', [
            'duties' => $duties
        ]);
    }
}
