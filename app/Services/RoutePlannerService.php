<?php

namespace App\Services;

use App\Models\Route;
use App\Models\Client;
use App\Models\ClientRoute;
use Carbon\Carbon;

class RoutePlannerService
{
    public function createRouteWithClients(array $data): Route
    {
        // 1. Route aanmaken
        $route = Route::create([
            'zorgpersoneel_id' => $data['zorgpersoneel_id'],
            'datum'            => $data['datum'],
            'shift'            => $data['shift'],
            'starttijd'        => $data['starttijd'],
            'eindtijd'         => $data['starttijd'], // tijdelijk
        ]);

        // 2. Startmoment
        $current = Carbon::parse($data['datum'] . ' ' . $data['starttijd']);

        // 3. Clients + zorgmomenten
        $clients = Client::with('zorgMomenten')
            ->whereIn('id', $data['clients'])
            ->get()
            ->keyBy('id');

        foreach ($data['clients'] as $clientId) {
            $client = $clients->get($clientId);

            // 4. Zorgduur bepalen
            $duration = $client->zorgMomenten
                ->where('moment', $data['shift'])
                ->sum('duration_minutes');

            if ($duration <= 0) {
                $duration = $client->zorgMomenten->sum('duration_minutes');
            }

            if ($duration <= 0) {
                $duration = 30;
            }

            // 5. Tijden berekenen
            $visitStart = $current->copy();
            $visitEnd   = $current->copy()->addMinutes($duration);

            // 6. Client koppelen
            ClientRoute::create([
                'route_id'         => $route->id,
                'client_id'        => $clientId,
                'zorgpersoneel_id' => $data['zorgpersoneel_id'],
            ]);

            // 7. Volgende client start na deze
            $current = $visitEnd;
        }

        // 8. Eindtijd opslaan
        $route->update([
            'eindtijd' => $current->format('H:i:s'),
        ]);

        return $route;
    }
}
