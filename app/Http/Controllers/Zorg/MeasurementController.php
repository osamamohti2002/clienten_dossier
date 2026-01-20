<?php

namespace App\Http\Controllers\Zorg;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function create(Client $client)
    {
        return view('zorg.measurements.create', compact('client'));
    }
}