<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $fillable = [
        'upazilla_id',
        'name',
        'bn_name',
        'url',
    ];

    /**
     * Get the upazila that owns the union.
     */
    public function upazila()
    {
        return $this->belongsTo(Upzila::class, 'upazilla_id');
    }

    /**
     * Get all users (PHOs/customers) in this union.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'union_id');
    }
}
