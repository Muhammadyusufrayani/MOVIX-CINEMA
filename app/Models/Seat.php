<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'studio_id',
        'row',
        'number',
        'type',
        'is_available',
        'is_maintenance',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'is_maintenance' => 'boolean',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function getSeatNumberAttribute()
    {
        return $this->row . $this->number;
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('is_maintenance', false);
    }

    public function scopeVIP($query)
    {
        return $query->where('type', 'vip');
    }
}