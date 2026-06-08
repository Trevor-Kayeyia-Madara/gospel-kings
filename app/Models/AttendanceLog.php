<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceLog extends Model
{
    protected $fillable = ['event_id', 'registration_ticket_id', 'checked_in_by', 'checked_in_at', 'entry_point'];

    protected function casts(): array
    {
        return ['checked_in_at' => 'datetime'];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(RegistrationTicket::class, 'registration_ticket_id');
    }
}
