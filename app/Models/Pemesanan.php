<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';

    protected $fillable = [
        'user_id',
        'jadwal_id',
        'kode_booking',
        'jumlah_tiket',
        'total_harga',
        'status',
    ];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
