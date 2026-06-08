<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationTicket extends Model
{
    protected $fillable = ['registration_id', 'ticket_number', 'qr_payload', 'issued_at', 'checked_in_at'];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
            'checked_in_at' => 'datetime',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function attendanceLogs(): HasMany
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
