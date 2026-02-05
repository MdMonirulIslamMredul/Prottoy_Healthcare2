<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'division_id',
        'name',
        'bn_name',
        'lat',
        'lon',
        'url',
    ];

    /**
     * Get the division that owns the district.
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the upzilas for the district.
     */
    public function upzilas()
    {
        return $this->hasMany(Upzila::class);
    }

    /**
     * Get the district manager for this district.
     */
    public function districtManager()
    {
        return $this->hasOne(User::class, 'district_id')->where('role', 'district_manager');
    }
}
