<?php

namespace App\Http\Controllers\Zorg;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index(Client $client)
    {
        $measurements = Measurement::with('user')
            ->where('client_id', $client->id)
            ->latest()
            ->get();

        return view('zorg.measurements.index', compact('client', 'measurements'));
    }

    public function create(Client $client)
    {
        return view('zorg.measurements.create', compact('client'));
    }

    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'type' => 'required|in:weight,blood_pressure,temperature,blood_sugar',

            'weight_kg' => 'nullable|numeric|min:0|max:500',
            'height_cm' => 'nullable|integer|min:30|max:300',

            'systolic' => 'nullable|integer|min:50|max:300',
            'diastolic' => 'nullable|integer|min:30|max:200',
            'heart_rate' => 'nullable|integer|min:20|max:250',

            'temperature_c' => 'nullable|numeric|min:30|max:45',

            'blood_sugar' => 'nullable|numeric|min:0|max:40',
        ]);

        // Extra check: per type minimaal de juiste velden ingevuld
        $this->validatePerType($validated);

        Measurement::create([
            'client_id' => $client->id,
            'user_id' => auth()->id(),
            'type' => $validated['type'],

            'weight_kg' => $validated['weight_kg'] ?? null,
            'height_cm' => $validated['height_cm'] ?? null,

            'systolic' => $validated['systolic'] ?? null,
            'diastolic' => $validated['diastolic'] ?? null,
            'heart_rate' => $validated['heart_rate'] ?? null,

            'temperature_c' => $validated['temperature_c'] ?? null,
            'blood_sugar' => $validated['blood_sugar'] ?? null,
        ]);

        return redirect()
            ->route('zorg.measurements.index', $client)
            ->with('success', 'Metingen opgeslagen.');
    }

    public function edit(Measurement $measurement)
    {
        // ✅ Alleen eigenaar mag bewerken
        if ($measurement->user_id !== auth()->id()) {
            abort(403, 'Je mag alleen je eigen metingen bewerken.');
        }

        $measurement->load('client');

        return view('zorg.measurements.edit', compact('measurement'));
    }

    public function update(Request $request, Measurement $measurement)
    {
        // ✅ Alleen eigenaar mag updaten
        if ($measurement->user_id !== auth()->id()) {
            abort(403, 'Je mag alleen je eigen metingen bijwerken.');
        }

        $validated = $request->validate([
            'type' => 'required|in:weight,blood_pressure,temperature,blood_sugar',

            'weight_kg' => 'nullable|numeric|min:0|max:500',
            'height_cm' => 'nullable|integer|min:30|max:300',

            'systolic' => 'nullable|integer|min:50|max:300',
            'diastolic' => 'nullable|integer|min:30|max:200',
            'heart_rate' => 'nullable|integer|min:20|max:250',

            'temperature_c' => 'nullable|numeric|min:30|max:45',

            'blood_sugar' => 'nullable|numeric|min:0|max:40',
        ]);

        $this->validatePerType($validated);

        // Eerst alles leegzetten, dan alleen relevante velden vullen (voorkomt oude data per type)
        $measurement->update([
            'type' => $validated['type'],

            'weight_kg' => null,
            'height_cm' => null,

            'systolic' => null,
            'diastolic' => null,
            'heart_rate' => null,

            'temperature_c' => null,
            'blood_sugar' => null,
        ]);

        $measurement->update([
            'weight_kg' => $validated['weight_kg'] ?? null,
            'height_cm' => $validated['height_cm'] ?? null,

            'systolic' => $validated['systolic'] ?? null,
            'diastolic' => $validated['diastolic'] ?? null,
            'heart_rate' => $validated['heart_rate'] ?? null,

            'temperature_c' => $validated['temperature_c'] ?? null,
            'blood_sugar' => $validated['blood_sugar'] ?? null,
        ]);

        return redirect()
            ->route('zorg.measurements.index', $measurement->client_id)
            ->with('success', 'Meting bijgewerkt.');
    }

    public function destroy(Measurement $measurement)
    {
        // ✅ Alleen eigenaar mag verwijderen
        if ($measurement->user_id !== auth()->id()) {
            abort(403);
        }

        $clientId = $measurement->client_id;
        $measurement->delete();

        return redirect()
            ->route('zorg.measurements.index', $clientId)
            ->with('success', 'Meting verwijderd.');
    }

    private function validatePerType(array $validated): void
    {
        $type = $validated['type'] ?? null;

        if ($type === 'weight') {
            if (empty($validated['weight_kg']) || empty($validated['height_cm'])) {
                abort(422, 'Voor Gewicht zijn gewicht en lengte verplicht.');
            }
        }

        if ($type === 'blood_pressure') {
            if (empty($validated['systolic']) || empty($validated['diastolic']) || empty($validated['heart_rate'])) {
                abort(422, 'Voor Bloeddruk zijn bovendruk, onderdruk en hartslag verplicht.');
            }
        }

        if ($type === 'temperature') {
            if (empty($validated['temperature_c'])) {
                abort(422, 'Voor Temperatuur is de temperatuur verplicht.');
            }
        }

        if ($type === 'blood_sugar') {
            if (empty($validated['blood_sugar'])) {
                abort(422, 'Voor Bloedsuiker is de bloedsuikerwaarde verplicht.');
            }
        }
    }
}