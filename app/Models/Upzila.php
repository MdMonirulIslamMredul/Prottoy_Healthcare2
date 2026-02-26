<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upzila extends Model
{
    protected $fillable = [
        'district_id',
        'name',
        'bn_name',
        'url',
    ];

    /**
     * Get the district that owns the upzila.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the division through the district.
     */
    public function division()
    {
        return $this->hasOneThrough(
            Division::class,
            District::class,
            'id',
            'id',
            'district_id',
            'division_id'
        );
    }

    /**
     * Get the upazila supervisor for this upazila.
     */
    public function upazilaSupervisor()
    {
        return $this->hasOne(User::class, 'upzila_id')->where('role', 'upazila_supervisor');
    }

    /**
     * Get all PHOs in this upazila.
     */
    public function phos()
    {
        return $this->hasMany(User::class, 'upzila_id')->where('role', 'pho');
    }

    /**
     * Get all unions in this upazila.
     */
    public function unions()
    {
        return $this->hasMany(Union::class, 'upzila_id');
    }
}
