<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientZorgMoment;


class Client extends Model

{
    use HasFactory;
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
