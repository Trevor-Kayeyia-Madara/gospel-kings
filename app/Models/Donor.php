<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donor extends Model
{
    protected $fillable = ['event_id', 'full_name', 'phone', 'email', 'donation_type', 'amount', 'payment_method', 'status', 'notes', 'is_anonymous', 'is_public'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_anonymous' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
