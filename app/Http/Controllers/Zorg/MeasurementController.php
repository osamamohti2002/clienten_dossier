<?php

namespace App\Http\Controllers\Zorg;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    /**
     * Overzicht metingen voor een client
     */
    public function index(Client $client)
    {
        $measurements = Measurement::where('client_id', $client->id)
            ->with('user')
            ->latest()
            ->get();

        return view('zorg.measurements.index', compact('client', 'measurements'));
    }

    /**
     * Form: nieuwe meting invullen
     */
    public function create(Client $client)
    {
        return view('zorg.measurements.create', compact('client'));
    }

    /**
     * Opslaan nieuwe meting
     */
    public function store(Request $request, Client $client)
    {
        // Basisregel: type is verplicht
        $baseRules = [
            'type' => 'required|in:weight,blood_pressure,temperature,blood_sugar',
        ];

        $type = $request->input('type');

        // Per type: juiste velden verplicht maken
        $typeRules = match ($type) {
            'weight' => [
                'weight_kg' => 'required|numeric|min:0|max:500',
                'height_cm' => 'required|integer|min:30|max:300',
            ],
            'blood_pressure' => [
                'systolic' => 'required|integer|min:50|max:300',
                'diastolic' => 'required|integer|min:30|max:200',
                'heart_rate' => 'required|integer|min:20|max:250',
            ],
            'temperature' => [
                'temperature_c' => 'required|numeric|min:30|max:45',
            ],
            'blood_sugar' => [
                'blood_sugar' => 'required|numeric|min:0|max:40',
            ],
            default => [],
        };

        $validated = $request->validate($baseRules + $typeRules);

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
            ->with('success', 'Meting opgeslagen.');
    }
}