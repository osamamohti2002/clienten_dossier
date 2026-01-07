<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Zorgpersoneel;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function create()
    {
        $zorgpersoneel = Zorgpersoneel::all();
        return view('planner.routes.create', compact('zorgpersoneel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zorgpersoneel_id' => 'required|exists:zorgpersoneel,id',
        ]);

        Route::create([
            'zorgpersoneel_id' => $request->zorgpersoneel_id,
        ]);

        return redirect()
            ->route('planner.dashboard')
            ->with('success', 'Route succesvol aangemaakt');
    }
}