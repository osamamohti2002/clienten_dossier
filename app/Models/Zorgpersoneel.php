<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zorgpersoneel extends Model
{
    protected $table = 'zorg_personeel';
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function routes()
    {
        return $this->hasMany(Route::class, 'zorg_personeel_id');
    }
}
