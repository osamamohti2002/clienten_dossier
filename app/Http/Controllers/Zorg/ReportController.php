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

    public function edit(Report $report)
    {
        // ✅ Beveiliging: alleen eigenaar mag bewerken
        if ($report->user_id !== auth()->id()) {
            abort(403, 'Je mag alleen je eigen rapportage bewerken.');
        }

        // Voor de "terug naar rapportages" link hebben we de client nodig
        $report->load('client');

        return view('zorg.reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        // ✅ Beveiliging: alleen eigenaar mag updaten
        if ($report->user_id !== auth()->id()) {
            abort(403, 'Je mag alleen je eigen rapportage bijwerken.');
        }

        $validated = $request->validate([
            'report' => ['required', 'string', 'min:3'],
        ]);

        $report->update([
            'report' => $validated['report'],
        ]);

        return redirect()
            ->route('zorg.reports.index', $report->client_id)
            ->with('success', 'Rapportage bijgewerkt.');
    }
}