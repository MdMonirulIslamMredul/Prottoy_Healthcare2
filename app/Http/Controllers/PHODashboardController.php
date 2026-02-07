<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PackagePurchase;

class PHODashboardController extends Controller
{
    public function dashboard()
    {
        $pho = auth()->user();

        // Get statistics for this PHO
        $customersCount = User::where('role', 'customer')
            ->where('pho_id', $pho->id)
            ->count();

        // Get package sales statistics
        $packagesSoldCount = PackagePurchase::where('pho_id', $pho->id)->count();
        $totalSalesAmount = PackagePurchase::where('pho_id', $pho->id)->sum('total_price');
        $totalPaidAmount = PackagePurchase::where('pho_id', $pho->id)->sum('paid_amount');
        $totalDueAmount = PackagePurchase::where('pho_id', $pho->id)->sum('due_amount');

        // Get recent package sales
        $recentPackageSales = PackagePurchase::where('pho_id', $pho->id)
            ->with(['package', 'customer'])
            ->latest()
            ->take(5)
            ->get();

        // Get customers list
        $customers = User::where('role', 'customer')
            ->where('pho_id', $pho->id)
            ->latest()
            ->paginate(10);

        return view('backend.pho.dashboard', compact(
            'pho',
            'customersCount',
            'packagesSoldCount',
            'totalSalesAmount',
            'totalPaidAmount',
            'totalDueAmount',
            'recentPackageSales',
            'customers'
        ));
    }
}
