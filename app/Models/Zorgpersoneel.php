<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Route;

class Zorgpersoneel extends Model
{
    protected $table = 'zorg_personeel';

    protected $fillable = [
        'user_id',
    ];

    /**
     * Zorgpersoneel belongs to ONE user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Zorgpersoneel has MANY routes
     */
    public function routes()
    {
        return $this->hasMany(Route::class, 'zorgpersoneel_id');
    }
}
