<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sponsor extends Model
{
    protected $fillable = ['event_id', 'name', 'tier', 'logo_path', 'pledged_amount', 'received_amount', 'is_public'];

    protected function casts(): array
    {
        return [
            'pledged_amount' => 'decimal:2',
            'received_amount' => 'decimal:2',
            'is_public' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
