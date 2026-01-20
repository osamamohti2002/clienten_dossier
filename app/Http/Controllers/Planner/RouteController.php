<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Route;
use App\Models\Zorgpersoneel;
use Illuminate\Http\Request;
use App\Models\ClientRoute;
use Carbon\Carbon;
use App\Services\RoutePlannerService;


use function Symfony\Component\Clock\now;

class RouteController extends Controller
{

    public function index()
    {
        $routes = Route::with([
                'zorgpersoneel.user',
                'visits.client',
                'visits.zorgMoment',   // ✅ deze toevoegen
            ])
            ->orderBy('datum', 'desc')
            ->orderByRaw("FIELD(shift,'ochtend','avond')")
            ->get();

        $routesTodayCount = Route::whereDate('datum', Carbon::today())->count();
        $clientsCount = Client::count();

        return view('planner/dashboard', compact('routes', 'routesTodayCount', 'clientsCount'));
    }



    public function create()
    {
        // Zorgpersoneel rows + their linked user (for name)o
        $zorgpersoneel = Zorgpersoneel::with('user')->get();
        // All clients for multiselect
        $clients = Client::with('zorgMomenten')->get();

        $datum = request('datum') ?? Carbon::now()->toDateString();
        $usedMomentIds = ClientRoute::whereHas('route', function ($q) use ($datum){
            $q->where('datum', $datum);
        })->pluck('client_zorg_moment_id')->unique()->values()->toArray();

        return view('planner.routes.create', compact('zorgpersoneel', 'clients', 'usedMomentIds', 'datum'));
    }

    public function store(Request $request, RoutePlannerService $planner)
    {
        // 1) Alleen aangevinkte visits bewaren
        $visits = collect($request->input('visits', []))
            ->filter(fn($v) => isset($v['enabled']) && $v['enabled'])
            ->values()
            ->all();

        $request->merge(['visits' => $visits]);

        // 2) Valideren
        $data = $request->validate([
            'zorgpersoneel_id' => ['required', 'exists:zorg_personeel,id'],
            'datum'            => ['required', 'date'],
            'shift'            => ['required', 'in:ochtend,avond'],
            'starttijd'        => ['required', 'date_format:H:i'],

            'visits'                         => ['required', 'array', 'min:1'],
            'visits.*.client_id'             => ['required', 'exists:clients,id'],
            'visits.*.client_zorg_moment_id' => ['required', 'exists:client_zorg_moments,id'],
            'visits.*.sequence'              => ['required', 'integer', 'min:1'],
        ]);

        // ✅ 3) Optie 2: blokkeren als route al bestaat
        $exists = Route::where('zorgpersoneel_id', $data['zorgpersoneel_id'])
            ->where('datum', $data['datum'])
            ->where('shift', $data['shift'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'shift' => 'Er bestaat al een planning voor deze medewerker op deze datum en shift. Ga naar "Bewerken" om deze aan te passen.',
                ]);
        }

        $usedMomentId = ClientRoute::whereHas('route', function($q) use ($data){
            $q->where('datum', $data['datum']);
        })->pluck('client_zorg_moment_id')->toArray();
        foreach($data['visits'] as $visits){
            if(in_array($visits['client_zorg_moment_id'], $usedMomentId)){
                return back()
                ->withInput()
                ->withErrors([
                    'visits' => 'Eén of meerdere zorgmomenten zijn al ingepland op deze datum.',
                ]);
            }
        }

        // 4) Service uitvoeren
        $planner->createRouteWithVisits($data);

        return redirect()
            ->route('planner.dashboard')
            ->with('success', 'Route succesvol aangemaakt');       
    }
}
