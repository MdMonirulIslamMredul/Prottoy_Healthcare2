<?php

namespace App\Http\Controllers;

use App\Models\PackagePurchase;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function dashboard()
    {
        $customer = auth()->user();

        // Get package statistics
        $totalPackages = PackagePurchase::where('customer_id', $customer->id)->count();
        $totalSpent = PackagePurchase::where('customer_id', $customer->id)->sum('total_price');
        $totalPaid = PackagePurchase::where('customer_id', $customer->id)->sum('paid_amount');
        $totalDue = PackagePurchase::where('customer_id', $customer->id)->sum('due_amount');

        // Get recent packages
        $recentPackages = PackagePurchase::where('customer_id', $customer->id)
            ->with(['package', 'pho'])
            ->latest()
            ->take(5)
            ->get();

        return view('backend.customer.dashboard', compact(
            'customer',
            'totalPackages',
            'totalSpent',
            'totalPaid',
            'totalDue',
            'recentPackages'
        ));
    }
}
