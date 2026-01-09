<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'bsn', 'phone', 'address', 'visit_time'];

    // relatie tussen client en 
    // public function routes()
    // {
    //     return $this->belongsToMany(Route::class, 'client_route');
    // }
    public function visits()
    {
        return $this->hasMany(ClientRoute::class);
    }

}
