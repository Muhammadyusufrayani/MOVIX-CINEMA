<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'film_id',
        'studio_name',
        'date',
        'time',
        'price',
        'total_seats',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'integer',
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }

    public function seats()
    {
        return $this->bookingSeats();
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->date ? Carbon::parse($this->date)->translatedFormat('d F Y') : '';
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getBookedSeatsAttribute(): array
    {
        return $this->bookingSeats()->pluck('seat_number')->toArray();
    }
}
