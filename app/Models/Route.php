<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Route extends Model
{
    protected $fillable = [
        'zorgpersoneel_id',
        'datum',
        'shift',
        'starttijd',
        'eindtijd',
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_route');
    }

    public function zorgpersoneel()
    {
        return $this->belongsTo(User::class, 'zorgpersoneel_id');
    }
}