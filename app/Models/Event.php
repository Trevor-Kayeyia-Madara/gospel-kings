<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_category_id',
        'title',
        'slug',
        'edition',
        'theme',
        'summary',
        'description',
        'venue',
        'city',
        'starts_at',
        'ends_at',
        'capacity',
        'is_paid',
        'registration_open',
        'base_price',
        'banner_image',
        'schedule',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_paid' => 'boolean',
            'registration_open' => 'boolean',
            'base_price' => 'decimal:2',
            'schedule' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function vipPackages(): HasMany
    {
        return $this->hasMany(VipPackage::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Registration::class);
    }
}
