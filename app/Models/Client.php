<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClientZorgMoment;

class Client extends Model
{
    protected $fillable = ['name', 'bsn', 'phone', 'address', 'gender'];

    public function visits()
    {
        return $this->hasMany(ClientRoute::class);
    }

    public function zorgMomenten()
    {
        return $this->hasMany(ClientZorgMoment::class);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

}
