<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationalRole extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'icon',
        'level',
        'color_start',
        'color_end',
        'responsibilities',
        'stats',
        'order',
        'is_active',
    ];

    protected $casts = [
        'responsibilities' => 'array',
        'stats' => 'array',
        'is_active' => 'boolean',
        'level' => 'integer',
        'order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('level');
    }
}
