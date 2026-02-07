<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\PackagePurchase;

class UpazilaSupervisorDashboardController extends Controller
{
    public function dashboard()
    {
        $upazilaSupervisor = auth()->user();

        // Get statistics - only PHOs created by this supervisor
        $phosCount = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->count();

        // Get statistics - only Customers in this supervisor's area
        $customersCount = User::where('role', 'customer')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->count();

        // Get PHOs list
        $phos = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->with(['customers'])
            ->get();

        // Get package purchase statistics for PHOs under this supervisor
        $phoIds = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->pluck('id');

        $totalPackagesSold = PackagePurchase::whereIn('pho_id', $phoIds)->count();
        $totalSalesAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('total_price');
        $totalPaidAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('paid_amount');
        $totalDueAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('due_amount');

        // Get recent package purchases
        $recentPackagePurchases = PackagePurchase::whereIn('pho_id', $phoIds)
            ->with(['package', 'customer', 'pho'])
            ->latest()
            ->take(10)
            ->get();

        return view('backend.upazila-supervisor.dashboard', compact(
            'upazilaSupervisor',
            'phosCount',
            'customersCount',
            'phos',
            'totalPackagesSold',
            'totalSalesAmount',
            'totalPaidAmount',
            'totalDueAmount',
            'recentPackagePurchases'
        ));
    }

    public function hierarchy()
    {
        $upazilaSupervisor = auth()->user();

        // Get all PHOs under this supervisor with their customers
        $phos = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->with('customers')
            ->get();

        return view('backend.upazila-supervisor.hierarchy', compact('upazilaSupervisor', 'phos'));
    }

    public function packageSales(Request $request)
    {
        $upazilaSupervisor = auth()->user();

        // Get PHO IDs under this supervisor
        $phoIds = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->pluck('id');

        // Get package purchases with filters
        $query = PackagePurchase::whereIn('pho_id', $phoIds)
            ->with(['package', 'customer', 'pho', 'payments']);

        // Apply filters
        if ($request->filled('pho_id')) {
            $query->where('pho_id', $request->pho_id);
        }

        if ($request->filled('package_id')) {
            $query->where('package_id', $request->package_id);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $packagePurchases = $query->latest('purchase_date')->paginate(20);

        // Get PHOs for filter dropdown
        $phos = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->orderBy('name')
            ->get();

        // Get packages for filter dropdown
        $packages = Package::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Calculate statistics
        $totalPackagesSold = PackagePurchase::whereIn('pho_id', $phoIds)->count();
        $totalSalesAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('total_price');
        $totalPaidAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('paid_amount');
        $totalDueAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('due_amount');

        return view('backend.upazila-supervisor.package-sales', compact(
            'upazilaSupervisor',
            'packagePurchases',
            'phos',
            'packages',
            'totalPackagesSold',
            'totalSalesAmount',
            'totalPaidAmount',
            'totalDueAmount'
        ));
    }

    public function allUsers(Request $request)
    {
        $upazilaSupervisor = auth()->user();

        $phos = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->orderBy('name')
            ->get();

        $query = User::with(['division', 'district', 'upzila', 'pho'])
            ->where('upazila_supervisor_id', $upazilaSupervisor->id);

        if ($request->filled('pho_id')) {
            $query->where('pho_id', $request->pho_id);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('backend.upazila-supervisor.all-users', compact(
            'users',
            'phos'
        ));
    }

    public function generateUsersReport(Request $request)
    {
        $upazilaSupervisor = auth()->user();

        $query = User::with(['division', 'district', 'upzila', 'pho'])
            ->where('upazila_supervisor_id', $upazilaSupervisor->id);

        if ($request->filled('pho_id')) {
            $query->where('pho_id', $request->pho_id);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $filters = [
            'pho' => $request->filled('pho_id') ? User::find($request->pho_id)?->name : 'All',
            'role' => $request->filled('role') ? ucfirst(str_replace('_', ' ', $request->role)) : 'All',
        ];

        return view('backend.upazila-supervisor.reports.users-pdf', compact('users', 'filters', 'upazilaSupervisor'));
    }
}
