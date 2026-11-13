<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $table = 'jadwals';

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class, 'film_id');
    }
}
