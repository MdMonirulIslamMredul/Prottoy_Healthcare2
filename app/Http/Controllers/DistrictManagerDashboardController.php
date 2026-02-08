<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Upzila;
use App\Models\Package;
use App\Models\PackagePurchase;
use App\Models\District;
use Barryvdh\DomPDF\Facade\Pdf;

class DistrictManagerDashboardController extends Controller
{
    public function dashboard()
    {
        $districtManager = auth()->user();

        // Get statistics for this district manager's district
        $upazilaSupervisorsCount = User::where('role', 'upazila_supervisor')
            ->where('district_id', $districtManager->district_id)
            ->count();

        $phosCount = User::where('role', 'pho')
            ->where('district_id', $districtManager->district_id)
            ->count();

        $customersCount = User::where('role', 'customer')
            ->where('district_id', $districtManager->district_id)
            ->count();

        // Get PHO IDs in this district
        $phoIds = User::where('role', 'pho')
            ->where('district_id', $districtManager->district_id)
            ->pluck('id');

        // Package statistics
        $totalPackagesSold = PackagePurchase::whereIn('pho_id', $phoIds)->count();
        $totalSalesAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('total_price');
        $totalPaidAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('paid_amount');
        $totalDueAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('due_amount');

        return view('backend.district-manager.dashboard', compact(
            'districtManager',
            'upazilaSupervisorsCount',
            'phosCount',
            'customersCount',
            'totalPackagesSold',
            'totalSalesAmount',
            'totalPaidAmount',
            'totalDueAmount'
        ));
    }

    public function hierarchy()
    {
        $districtManager = auth()->user();

        // Get all upazilas in this district with their supervisors and subordinates
        $upzilas = Upzila::where('district_id', $districtManager->district_id)
            ->with([
                'upazilaSupervisor',
                'phos.customers'
            ])
            ->get()
            ->sortByDesc(function($upzila) {
                return $upzila->upazilaSupervisor ? 1 : 0;
            });

        return view('backend.district-manager.hierarchy', compact('districtManager', 'upzilas'));
    }

    public function allUsers(Request $request)
    {
        $districtManager = auth()->user();

        $upzilas = Upzila::where('district_id', $districtManager->district_id)->orderBy('name')->get();
        $phos = collect();

        $query = User::with(['division', 'district', 'upzila', 'pho'])
            ->where('district_id', $districtManager->district_id);

        if ($request->filled('upzila_id')) {
            $query->where('upzila_id', $request->upzila_id);
            $phos = User::where('role', 'pho')
                ->where('upzila_id', $request->upzila_id)
                ->orderBy('name')
                ->get();
        }

        if ($request->filled('pho_id')) {
            $query->where('pho_id', $request->pho_id);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('backend.district-manager.all-users', compact(
            'users',
            'upzilas',
            'phos'
        ));
    }

    public function filterPhos($upzilaId)
    {
        $phos = User::where('role', 'pho')
            ->where('upzila_id', $upzilaId)
            ->orderBy('name')
            ->get(['id', 'name']);
        return response()->json($phos);
    }

    public function generateUsersReport(Request $request)
    {
        $districtManager = auth()->user();

        $query = User::with(['division', 'district', 'upzila', 'pho'])
            ->where('district_id', $districtManager->district_id);

        if ($request->filled('upzila_id')) {
            $query->where('upzila_id', $request->upzila_id);
        }

        if ($request->filled('pho_id')) {
            $query->where('pho_id', $request->pho_id);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $filters = [
            'upzila' => $request->filled('upzila_id') ? Upzila::find($request->upzila_id)?->name : 'All',
            'pho' => $request->filled('pho_id') ? User::find($request->pho_id)?->name : 'All',
            'role' => $request->filled('role') ? ucfirst(str_replace('_', ' ', $request->role)) : 'All',
        ];

        return view('backend.district-manager.reports.users-pdf', compact('users', 'filters', 'districtManager'));
    }

    public function packageSales(Request $request)
    {
        $districtManager = auth()->user();

        // Get PHO IDs in this district
        $phoQuery = User::where('role', 'pho')
            ->where('district_id', $districtManager->district_id);

        // Apply upazila filter to PHOs
        if ($request->filled('upazila_id')) {
            $phoQuery->where('upzila_id', $request->upazila_id);
        }

        $phoIds = $phoQuery->pluck('id');

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

        // Calculate statistics from filtered query (before pagination)
        $totalPackagesSold = $query->count();
        $totalSalesAmount = $query->sum('total_price');
        $totalPaidAmount = $query->sum('paid_amount');
        $totalDueAmount = $query->sum('due_amount');

        $packagePurchases = $query->latest('purchase_date')->paginate(20);

        // Get PHOs for filter dropdown
        $phos = User::where('role', 'pho')
            ->where('district_id', $districtManager->district_id)
            ->orderBy('name')
            ->get();

        // Get packages for filter dropdown
        $packages = Package::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get districts for filter (based on manager's district)
        $districts = District::where('id', $districtManager->district_id)
            ->orderBy('name')
            ->get();

        // Get upazilas for filter (all upazilas in this district)
        $upzilas = Upzila::where('district_id', $districtManager->district_id)
            ->orderBy('name')
            ->get();

        return view('backend.district-manager.package-sales', compact(
            'districtManager',
            'packagePurchases',
            'phos',
            'packages',
            'districts',
            'upzilas',
            'totalPackagesSold',
            'totalSalesAmount',
            'totalPaidAmount',
            'totalDueAmount'
        ));
    }

    public function generatePackageSalesReport(Request $request)
    {
        $districtManager = auth()->user();

        $phoQuery = User::where('role', 'pho')
            ->where('district_id', $districtManager->district_id);

        if ($request->filled('upazila_id')) {
            $phoQuery->where('upzila_id', $request->upazila_id);
        }

        $phoIds = $phoQuery->pluck('id');

        $query = PackagePurchase::whereIn('pho_id', $phoIds)
            ->with(['package', 'customer', 'pho', 'payments']);

        if ($request->filled('pho_id')) {
            $query->where('pho_id', $request->pho_id);
        }

        if ($request->filled('package_id')) {
            $query->where('package_id', $request->package_id);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Calculate statistics from filtered query
        $totalPackagesSold = $query->count();
        $totalSalesAmount = $query->sum('total_price');
        $totalPaidAmount = $query->sum('paid_amount');
        $totalDueAmount = $query->sum('due_amount');

        $packagePurchases = $query->latest('purchase_date')->get();

        $filters = [];
        if ($request->filled('upazila_id')) {
            $filters['Upazila'] = Upzila::find($request->upazila_id)->name ?? 'All';
        }
        if ($request->filled('pho_id')) {
            $filters['PHO'] = User::find($request->pho_id)->name ?? 'All';
        }
        if ($request->filled('package_id')) {
            $filters['Package'] = Package::find($request->package_id)->name ?? 'All';
        }
        if ($request->filled('payment_status')) {
            $filters['Payment Status'] = ucfirst($request->payment_status);
        }

        $reportTitle = 'District Package Sales Report - ' . $districtManager->district->name;

        return view('backend.pdf.package-sales-report', compact(
            'packagePurchases',
            'totalPackagesSold',
            'totalSalesAmount',
            'totalPaidAmount',
            'totalDueAmount',
            'reportTitle',
            'filters'
        ));
    }
}
