<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsEvent extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'published_at',
        'order',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('published_at', 'desc');
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->active()->orderBy('published_at', 'desc')->limit($limit);
    }
}
