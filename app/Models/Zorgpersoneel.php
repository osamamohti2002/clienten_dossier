<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zorgpersoneel extends Model
{
    protected $table = 'zorg_personeel';
    protected $fillable = [
        'user_id',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
    // voor routes 
    public function routes()
    {
        return $this->hasMany(Route::class);
    }
}
