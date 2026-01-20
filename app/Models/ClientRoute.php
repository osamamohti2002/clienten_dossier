<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientRoute extends Model
{
    protected $table = 'client_route';

    protected $fillable = [
        'route_id',
        'client_id',
        'zorgpersoneel_id',
        'client_zorg_moment_id',
        'sequence',
        'start_time',
        'end_time',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function zorgpersoneel()
    {
        return $this->belongsTo(User::class, 'zorgpersoneel_id');
    }

    public function zorgMoment()
    {
        return $this->belongsTo(ClientZorgMoment::class, 'client_zorg_moment_id');
    }
}
