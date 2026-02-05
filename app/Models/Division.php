<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'name',
        'bn_name',
        'url',
    ];

    /**
     * Get the districts for the division.
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    /**
     * Get all upzilas through districts.
     */
    public function upzilas()
    {
        return $this->hasManyThrough(Upzila::class, District::class);
    }

    /**
     * Get the divisional chief for this division.
     */
    public function divisionalChief()
    {
        return $this->hasOne(User::class, 'division_id')->where('role', 'divisional_chief');
    }
}
