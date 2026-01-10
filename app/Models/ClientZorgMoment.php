<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientZorgMoment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'moment',
        'duration_minutes',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}