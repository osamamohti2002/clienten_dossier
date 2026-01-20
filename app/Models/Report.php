<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'report',
    ];

    // Relatie naar cliënt
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relatie naar zorgpersoneel (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}