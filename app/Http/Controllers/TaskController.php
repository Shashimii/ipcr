<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class TaskController extends Controller
{
    public function index(Request $request)
    {
        // $officersQuery = User::search($request);
        // $officers = OfficerResource::collection($officersQuery->where('role', 0)->paginate(10));

        return Inertia::render('Tasks/Index', [
            // 'officers' => $officers
        ]);
    }
}
