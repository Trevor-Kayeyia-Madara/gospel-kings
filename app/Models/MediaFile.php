<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaFile extends Model
{
    protected $fillable = ['gallery_id', 'title', 'type', 'path', 'thumbnail_path'];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }
}
