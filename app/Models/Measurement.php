<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'type',

        // Gewicht
        'weight_kg',
        'height_cm',

        // Bloeddruk
        'systolic',
        'diastolic',
        'heart_rate',

        // Temperatuur
        'temperature_c',

        // Bloedsuiker
        'blood_sugar',
    ];

    /*
     * Relatie: meting hoort bij een cliënt
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /*
     * Relatie: meting is ingevoerd door een zorgmedewerker (user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}