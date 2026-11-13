<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    protected $fillable = [
        'booking_id',
        'schedule_id',
        'seat_number',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
