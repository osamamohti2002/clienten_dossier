<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Route;
use App\Models\Zorgpersoneel;
use Illuminate\Http\Request;
use App\Models\ClientRoute;

class RouteController extends Controller
{

    public function index()
    {
        $routes = Route::with(['zorgpersoneel.user', 'visits.client'])
            ->orderBy('datum', 'desc')
            ->orderByRaw("FIELD(shift,'ochtend','avond')")
            ->get();

        return view('planner/dashboard', compact('routes'));
    }


    public function create()
    {
        // Zorgpersoneel rows + their linked user (for name)o
        $zorgpersoneel = Zorgpersoneel::with('user')->get();

        // All clients for multiselect
        $clients = Client::orderBy('name')->get();

        return view('planner.routes.create', compact('zorgpersoneel', 'clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'zorgpersoneel_id' => ['required', 'exists:zorg_personeel,id'],
            'datum'            => ['required', 'date'],
            'shift'            => ['required', 'in:ochtend,avond'],
            'starttijd'        => ['required', 'date_format:H:i'],
            'eindtijd'         => ['required', 'date_format:H:i', 'after:starttijd'],
            'clients'          => ['required', 'array', 'min:1'],
            'clients.*'        => ['exists:clients,id'],
        ]);

        $route = Route::create([
            'zorgpersoneel_id' => $data['zorgpersoneel_id'],
            'datum'            => $data['datum'],
            'shift'            => $data['shift'],
            'starttijd'        => $data['starttijd'],
            'eindtijd'         => $data['eindtijd'],
        ]);

        // $route->clients()->sync($data['clients']);
        foreach ($data['clients'] as $clientId) {
        ClientRoute::create([
            'route_id'         => $route->id,
            'client_id'        => $clientId,
            'zorgpersoneel_id' => $data['zorgpersoneel_id'],
        ]);
    }




        return redirect()
            ->route('planner.dashboard')
            ->with('success', 'Route succesvol aangemaakt');
    }
}
