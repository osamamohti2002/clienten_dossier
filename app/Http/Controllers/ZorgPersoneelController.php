<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\Route;
use App\Models\ClientRoute;

class ZorgPersoneelController extends Controller
{
   public function dashboard()
{
    $user = Auth::user();
    $zorgpersoneel = $user->zorgpersoneel;
    $todayDate = now()->toDateString();

    $todayRoute = Route::where('zorgpersoneel_id', $zorgpersoneel->id)
        ->where('datum', $todayDate)
        ->first();

    // NEW: load visits if route exists
    $visits = [];

    if ($todayRoute) {
        $visits = ClientRoute::where('route_id', $todayRoute->id)
            ->orderBy('sequence')
            ->with('client')
            ->get();
    }

    return view('zorg.dashboard', [
        'today' => now()->translatedFormat('d F Y'),
        'todayRoute' => $todayRoute,
        'visits' => $visits,
    ]);
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

        Report::create([
            'client_id' => $client->id,
            'user_id'   => auth()->id(),
            'report'    => $data['report'],
        ]);

        return redirect()
            ->route('zorg.clients.reports', $client->id)
            ->with('success', 'Rapportage opgeslagen.');
    }
}