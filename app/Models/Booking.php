<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'schedule_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_seats',
        'total_price',
        'status',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }

    public function seats()
    {
        return $this->bookingSeats();
    }

    public function getSeatNumbersStringAttribute(): string
    {
        return $this->bookingSeats()->pluck('seat_number')->implode(', ');
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}
