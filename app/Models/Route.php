<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    //
    protected $fillable = ['zorgpersoneel_id'];

    public function zorgpersoneel()
    {
        return $this->belongsTo(Zorgpersoneel::class);
    }
}