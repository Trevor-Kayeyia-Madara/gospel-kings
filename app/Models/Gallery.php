<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    protected $fillable = ['event_id', 'title', 'slug', 'description'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function mediaFiles(): HasMany
    {
        return $this->hasMany(MediaFile::class);
    }
}
