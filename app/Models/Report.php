<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'type',
        'weight_kg',
        'height_cm',
        'systolic',
        'diastolic',
        'heart_rate',
        'temperature_c',
        'blood_sugar',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}