<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Volunteer extends Model
{
    protected $fillable = ['event_id', 'full_name', 'phone', 'email', 'role', 'shift', 'skills', 'notes', 'is_confirmed'];

    protected function casts(): array
    {
        return [
            'is_confirmed' => 'boolean',
            'skills' => 'array',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
