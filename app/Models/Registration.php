<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'vip_package_id',
        'registration_number',
        'full_name',
        'phone',
        'email',
        'church',
        'county_city',
        'gender',
        'registration_type',
        'status',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function vipPackage(): BelongsTo
    {
        return $this->belongsTo(VipPackage::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(RegistrationTicket::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
