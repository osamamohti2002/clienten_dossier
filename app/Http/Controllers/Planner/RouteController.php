<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Route;
use App\Models\Zorgpersoneel;
use Illuminate\Http\Request;
use App\Models\ClientRoute;
use Carbon\Carbon;
;

class RouteController extends Controller
{

    public function index()
    {
        $routes = Route::with(['zorgpersoneel.user', 'visits.client'])
            ->orderBy('datum', 'desc')
            ->orderByRaw("FIELD(shift,'ochtend','avond')")
            ->get();

        $routesTodayCount = Route::whereDate('datum', Carbon::today())->count();
        $clientsCount = Client::count();

        return view('planner/dashboard', compact('routes', 'routesTodayCount', "clientsCount"));
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
        // eindtijd NIET meer valideren/vragen
        'clients'          => ['required', 'array', 'min:1'],
        'clients.*'        => ['exists:clients,id'],
    ]);

    // Route alvast aanmaken (eindtijd berekenen we straks)
    $route = Route::create([
        'zorgpersoneel_id' => $data['zorgpersoneel_id'],
        'datum'            => $data['datum'],
        'shift'            => $data['shift'],
        'starttijd'        => $data['starttijd'],
        'eindtijd'         => $data['starttijd'], // tijdelijk
    ]);

    // Startmoment = datum + starttijd
    $current = Carbon::parse($data['datum'] . ' ' . $data['starttijd']);

    // Clients ophalen (met zorgmomenten)
    // Let op: dit vereist dat Client een relatie 'zorgMomenten' heeft.
    $clients = Client::with('zorgMomenten')
        ->whereIn('id', $data['clients'])
        ->get()
        ->keyBy('id');

    // Als je later reistijd wilt meenemen, zet dit bv. op 5/10 min
    $travelMinutesBetweenClients = 0;

    foreach ($data['clients'] as $clientId) {
        $client = $clients->get($clientId);

        // 1) Zorgduur in minuten bepalen
        // Probeer eerst op shift te filteren (als jouw moment waarden "ochtend/avond" zijn)
        $duration = $client->zorgMomenten
            ->where('moment', $data['shift'])
            ->sum('duration_minutes');

        // Fallback: als shift-filter niks oplevert, pak totaal
        if ($duration <= 0) {
            $duration = $client->zorgMomenten->sum('duration_minutes');
        }

        // Extra fallback zodat je nooit 0 minuten krijgt
        if ($duration <= 0) {
            $duration = 30; // kies wat logisch is bij jou
        }

        // 2) Aankomst/vertrek berekenen
        $visitStart = $current->copy();
        $visitEnd   = $current->copy()->addMinutes($duration);

        // 3) Client koppelen aan route
        // Als je kolommen start_time/end_time hebt, kun je die opslaan
        ClientRoute::create([
            'route_id'         => $route->id,
            'client_id'        => $clientId,
            'zorgpersoneel_id' => $data['zorgpersoneel_id'],
            // 'start_time'    => $visitStart->format('H:i:s'),
            // 'end_time'      => $visitEnd->format('H:i:s'),
        ]);

        // 4) Volgende client start na einde (+ eventuele reistijd)
        $current = $visitEnd->copy()->addMinutes($travelMinutesBetweenClients);
    }

    // Eindtijd = einde van laatste bezoek
    $route->update([
        'eindtijd' => $current->copy()->subMinutes($travelMinutesBetweenClients)->format('H:i:s'),
        // als travelMinutesBetweenClients=0 is dit gewoon het einde van de laatste client
    ]);

    return redirect()
        ->route('planner.dashboard')
        ->with('success', 'Route succesvol aangemaakt');
}
}