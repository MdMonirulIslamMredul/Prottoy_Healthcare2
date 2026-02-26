<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'union_id',
        'name',
        'bn_name',
    ];

    /**
     * Get the union that owns the word.
     */
    public function union()
    {
        return $this->belongsTo(Union::class, 'union_id');
    }
}
