<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'published_at'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }
}
