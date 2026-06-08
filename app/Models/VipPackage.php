<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VipPackage extends Model
{
    protected $fillable = ['event_id', 'name', 'description', 'amount', 'capacity', 'benefits'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'benefits' => 'array',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
