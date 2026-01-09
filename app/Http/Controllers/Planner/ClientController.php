<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;


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
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'bsn' => 'required|string|max:255|unique:clients,bsn',
        'phone' => 'nullable|string|max:50',
        'address' => 'nullable|string|max:255',
    ]);
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bsn' => 'required|string|max:255|unique:clients,bsn',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'visit_time' => 'nullable|date_format:H:i',
        ]);

        Client::create($data);

    return redirect()->route('planner.clients.index')
        ->with('success', 'Cliënt toegevoegd.');
    }
}

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bsn' => 'required|string|max:255|unique:clients,bsn,' . $client->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'visit_time' => 'nullable|date_format:H:i',
        ]);

        $client->update($data);

        return redirect()->route('planner.clients.index')
            ->with('success', 'Cliënt bijgewerkt.');
    }

        public function edit(Client $client)
    {
        return view('planner.clients.edit', compact('client'));
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('planner.clients.index')
            ->with('success', 'Cliënt verwijderd.');
        return redirect()->route('planner.clients.index')
            ->with('success', 'Cliënt toegevoegd.');
    }

}
