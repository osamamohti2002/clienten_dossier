<?php

namespace App\Services;

use App\Models\Route;
use App\Models\ClientRoute;
use App\Models\ClientZorgMoment;
use Carbon\Carbon;

class RoutePlannerService
{
    public function createRouteWithVisits(array $data): Route
    {
        // Route aanmaken (let op: dit maakt altijd een nieuwe route)
        $route = Route::create([
            'zorgpersoneel_id' => $data['zorgpersoneel_id'],
            'datum'            => $data['datum'],
            'shift'            => $data['shift'],
            'starttijd'        => $data['starttijd'],
            'eindtijd'         => $data['starttijd'], // tijdelijk
        ]);

        $current = Carbon::parse($data['datum'] . ' ' . $data['starttijd']);
        $travelMinutes = 10;

        // ✅ Shift -> toegestane momenten (AANGEPAST op jouw DB)
        // ochtend route: ochtend + middag_1 (eind ochtend)
        // avond route: middag_2 (eind middag) + avond
        $allowedMoments = match ($data['shift']) {
            'ochtend' => ['ochtend', 'middag_1'],
            'avond'   => ['middag_2', 'avond'],
            default   => [],
        };

        // visits sorteren op volgorde
        $visits = collect($data['visits'])
            ->sortBy('sequence')
            ->values();

        // alle zorgmomenten ophalen in 1 query
        $momentIds = $visits->pluck('client_zorg_moment_id')->unique()->values();
        $moments = ClientZorgMoment::whereIn('id', $momentIds)->get()->keyBy('id');

        $lastIndex = $visits->count() - 1;

        foreach ($visits as $i => $visit) {
            $moment = $moments->get($visit['client_zorg_moment_id']);

            if (!$moment) {
                throw new \InvalidArgumentException('Zorgmoment niet gevonden.');
            }

            // ✅ Shift-validatie (met normalisatie)
            $momentName = mb_strtolower(trim((string) $moment->moment));
            $allowed = array_map(
                fn ($m) => mb_strtolower(trim((string) $m)),
                $allowedMoments
            );

            if (!in_array($momentName, $allowed, true)) {
                throw new \InvalidArgumentException(
                    "Dit zorgmoment ({$moment->moment}) past niet bij de gekozen shift ({$data['shift']})."
                );
            }

            // duur bepalen
            $duration = (int) $moment->duration_minutes;
            if ($duration <= 0) {
                $duration = 30;
            }

            // start/eind per bezoek
            $visitStart = $current->copy();
            $visitEnd   = $current->copy()->addMinutes($duration);

            // bezoek opslaan (Model B)
            ClientRoute::create([
                'route_id'              => $route->id,
                'client_id'             => $visit['client_id'],
                'zorgpersoneel_id'      => $data['zorgpersoneel_id'],
                'client_zorg_moment_id' => $visit['client_zorg_moment_id'],
                'sequence'              => (int) $visit['sequence'],
                'start_time'            => $visitStart->format('H:i:s'),
                'end_time'              => $visitEnd->format('H:i:s'),
            ]);

            // volgende bezoek: + reistijd behalve na de laatste
            $current = ($i !== $lastIndex)
                ? $visitEnd->copy()->addMinutes($travelMinutes)
                : $visitEnd;
        }

        // route eindtijd = einde laatste bezoek
        $route->update([
            'eindtijd' => $current->format('H:i:s'),
        ]);

        return $route;
    }
}
