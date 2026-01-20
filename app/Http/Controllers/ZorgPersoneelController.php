<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ZorgPersoneelController extends Controller
{
    public function dashboard()
    {
        return view('zorg.dashboard');
    }

    public function clients(Request $request)
    {
        $search = $request->input('search');

        $clients = Client::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('bsn', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get();

        return view('zorg.clients.index', compact('clients', 'search'));
    }

    public function reports(Client $client)
    {
        return view('zorg.clients.reports', compact('client'));
    }

    public function storeReport(Request $request, Client $client)
    {
        $data = $request->validate([
            'report' => 'required|string|min:5',
        ]);

        // Voor nu: alleen testen dat POST binnenkomt
        // Later vervangen we dit door echte database opslag.
        return redirect()
            ->route('zorg.clients.reports', $client->id)
            ->with('success', 'Rapportage ontvangen (test).');
    }
}