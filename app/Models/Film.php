<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'genre',
        'duration',
        'rating',
        'age_rating',
        'director',
        'cast',
        'synopsis',
        'poster_url',
        'banner_url',
        'trailer_url',
        'status',
        'release_date',
    ];

    protected $casts = [
        'rating' => 'float',
        'duration' => 'integer',
        'release_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($film) {
            if (empty($film->slug)) {
                $film->slug = Str::slug($film->title);
            }
        });
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function scopeNowShowing($query)
    {
        return $query->where('status', 'now_showing');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    public function scopeSearch($query, ?string $term)
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('genre', 'like', "%{$term}%")
              ->orWhere('director', 'like', "%{$term}%")
              ->orWhere('cast', 'like', "%{$term}%");
        });
    }

    public function getFormattedDurationAttribute(): string
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        return ($hours > 0 ? "{$hours}j " : "") . "{$minutes}m ({$this->duration} Menit)";
    }
}
