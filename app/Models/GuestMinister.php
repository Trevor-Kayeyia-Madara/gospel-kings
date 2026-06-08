<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestMinister extends Model
{
    protected $fillable = ['event_id', 'name', 'role', 'phone', 'email', 'notes', 'is_public'];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
