<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePurchase extends Model
{
    protected $fillable = [
        'package_id',
        'customer_id',
        'pho_id',
        'total_price',
        'paid_amount',
        'due_amount',
        'payment_status',
        'purchase_date',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function pho()
    {
        return $this->belongsTo(User::class, 'pho_id');
    }

    public function payments()
    {
        return $this->hasMany(PackagePayment::class);
    }
}
