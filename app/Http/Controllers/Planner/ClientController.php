<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientZorgMoment;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('name')->get();
        $clientsCount = Client::count();

        return view('planner.clients.index', compact('clients', 'clientsCount'));
    }

    public function create()
    {
        return view('planner.clients.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bsn' => 'required|string|max:255|unique:clients,bsn',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',

            'zorg' => 'nullable|array',
            'zorg.*' => 'nullable|integer|min:1|max:1440', 
        ]);

        $client = Client::create([
            'name' => $validated['name'],
            'bsn' => $validated['bsn'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $zorgMomenten = $validated['zorg'] ?? [];

        foreach ($zorgMomenten as $moment => $minutes) {
            if (empty($minutes)) {
                continue;
            }

            ClientZorgMoment::create([
                'client_id' => $client->id,
                'moment' => $moment, 
                'duration_minutes' => (int) $minutes,
            ]);
        }
        return redirect()->route('planner.clients.index')
            ->with('success', 'Cliënt toegevoegd.');
    }

    public function edit(Client $client)
    {
        $zorgMomenten = $client->zorgMomenten()->get()->keyBy('moment');

        return view('planner.clients.edit', compact('client', 'zorgMomenten'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bsn' => 'required|string|max:255|unique:clients,bsn,' . $client->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',

            'zorg' => 'nullable|array',
            'zorg.*' => 'nullable|integer|min:1|max:1440',
        ]);

        $client->update([
            'name' => $validated['name'],
            'bsn' => $validated['bsn'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $client->zorgMomenten()->delete();

        // nieuwe zorgmomenten opslaan
        foreach ($validated['zorg'] ?? [] as $moment => $minutes) {
            if (empty($minutes)) {
                continue;
            }

            ClientZorgMoment::create([
                'client_id' => $client->id,
                'moment' => $moment,
                'duration_minutes' => (int) $minutes,
            ]);
        }

        return redirect()->route('planner.clients.index')
            ->with('success', 'Cliënt bijgewerkt.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->zorgMomenten()->delete();
        $client->delete();

        return redirect()->route('planner.clients.index')
            ->with('success', 'Cliënt verwijderd.');
    }
}