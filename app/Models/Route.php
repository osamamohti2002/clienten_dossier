<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Zorgpersoneel;
use App\Models\Client;
use App\Models\ClientRoute;

class Route extends Model
{
    protected $fillable = [
        'zorgpersoneel_id',
        'datum',
        'shift',
        'starttijd',
        'eindtijd',
    ];

    // Route belongs to ONE zorgpersoneel
    public function zorgpersoneel()
    {
        return $this->belongsTo(Zorgpersoneel::class, 'zorgpersoneel_id');
    }

    // Route has MANY clients
    // public function clients()
    // {
    //     return $this->belongsToMany(Client::class, 'client_route');
    // }
    public function visits()
    {
        return $this->hasMany(ClientRoute::class);
    }
}
