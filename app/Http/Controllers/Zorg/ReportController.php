<?php

namespace App\Http\Controllers\Zorg;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Toon alle rapportages van een client (van iedereen).
     */
    public function index(Client $client)
    {
        $reports = Report::with('user')
            ->where('client_id', $client->id)
            ->latest()
            ->get();

        return view('zorg.reports.index', compact('client', 'reports'));
    }

    /**
     * Sla een nieuwe rapportage op (altijd van de ingelogde zorgmedewerker).
     */
    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'report' => ['required', 'string', 'min:3'],
        ]);

        Report::create([
            'client_id' => $client->id,
            'user_id' => auth()->id(),
            'report' => $validated['report'],
        ]);

        return redirect()
            ->route('zorg.reports.index', $client)
            ->with('success', 'Rapportage opgeslagen.');
    }

    // Stap 4 doen we: edit/update/destroy + beveiliging (alleen eigen)
}