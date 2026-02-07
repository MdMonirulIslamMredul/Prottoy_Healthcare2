<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'created_by',
        'division_id',
        'district_id',
        'upzila_id',
        'upazila_supervisor_id',
        'pho_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the division that the user belongs to.
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the district that the user belongs to.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the upzila that the user belongs to.
     */
    public function upzila()
    {
        return $this->belongsTo(Upzila::class);
    }

    /**
     * Get the upazila supervisor who created this PHO.
     */
    public function upazilaSupervisor()
    {
        return $this->belongsTo(User::class, 'upazila_supervisor_id');
    }

    /**
     * Get the PHOs created by this upazila supervisor.
     */
    public function phos()
    {
        return $this->hasMany(User::class, 'upazila_supervisor_id')->where('role', 'pho');
    }

    /**
     * Get the PHO who created this customer.
     */
    public function pho()
    {
        return $this->belongsTo(User::class, 'pho_id');
    }

    /**
     * Get the customers created by this PHO.
     */
    public function customers()
    {
        return $this->hasMany(User::class, 'pho_id');
    }

    /**
     * Get the package sales (purchases) made by this PHO.
     */
    public function packageSales()
    {
        return $this->hasMany(PackagePurchase::class, 'pho_id');
    }

    /**
     * Get the package purchases made for this customer.
     */
    public function packagePurchases()
    {
        return $this->hasMany(PackagePurchase::class, 'customer_id');
    }
}
