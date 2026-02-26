<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Upzila;
use App\Models\Union;
use App\Models\Package;
use App\Models\PackagePurchase;
use Barryvdh\DomPDF\Facade\Pdf;

class SuperAdminController extends Controller
{
    /**
     * Show super admin dashboard
     */
    public function dashboard()
    {
        $divisionalChiefsCount = User::where('role', 'divisional_chief')->count();
        $districtManagersCount = User::where('role', 'district_manager')->count();
        $upazilaSupervisorsCount = User::where('role', 'upazila_supervisor')->count();
        $phosCount = User::where('role', 'pho')->count();
        $customersCount = User::where('role', 'customer')->count();
        $totalUsers = User::count();
        $recentUsers = User::latest()->take(10)->get();

        // Package statistics for all PHOs
        $phoIds = User::where('role', 'pho')->pluck('id');
        $totalPackagesSold = PackagePurchase::whereIn('pho_id', $phoIds)->count();
        $totalSalesAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('total_price');
        $totalPaidAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('paid_amount');
        $totalDueAmount = PackagePurchase::whereIn('pho_id', $phoIds)->sum('due_amount');

        return view('backend.superadmin.dashboard', compact(
            'divisionalChiefsCount',
            'districtManagersCount',
            'upazilaSupervisorsCount',
            'phosCount',
            'customersCount',
            'totalUsers',
            'recentUsers',
            'totalPackagesSold',
            'totalSalesAmount',
            'totalPaidAmount',
            'totalDueAmount'
        ));
    }

    public function hierarchy(Request $request)
    {
        $allDivisions = Division::orderBy('name')->get();
        $selectedDivisionId = $request->get('division_id');

        $divisions = collect();

        if ($selectedDivisionId) {
            // Get only the selected division with its nested relationships
            $division = Division::where('id', $selectedDivisionId)
                ->with([
                    'divisionalChief',
                    'districts.districtManager',
                    'districts.upzilas.upazilaSupervisor',
                    'districts.upzilas.phos.customers'
                ])
                ->first();

            if ($division) {
                // Sort districts - those with managers first
                $sortedDistricts = $division->districts->sortByDesc(function ($district) {
                    return $district->districtManager ? 1 : 0;
                });
                $division->setRelation('districts', $sortedDistricts);

                $divisions = collect([$division]);
            }
        }

        return view('backend.superadmin.hierarchy', compact('divisions', 'allDivisions', 'selectedDivisionId'));
    }

    public function allUsers(Request $request)
    {
        $divisions = Division::orderBy('name')->get();
        $districts = collect();
        $upzilas = collect();
        $phos = collect();

        $query = User::with(['division', 'district', 'upzila', 'pho']);

        // Apply filters
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
            $districts = District::where('division_id', $request->division_id)->orderBy('name')->get();
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
            $upzilas = Upzila::where('district_id', $request->district_id)->orderBy('name')->get();
        }

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

        return view('backend.superadmin.all-users', compact(
            'users',
            'divisions',
            'districts',
            'upzilas',
            'phos'
        ));
    }

    public function filterDistricts($divisionId)
    {
        $districts = District::where('division_id', $divisionId)->orderBy('name')->get(['id', 'name']);
        return response()->json($districts);
    }

    public function filterUpzilas($districtId)
    {
        $upzilas = Upzila::where('district_id', $districtId)->orderBy('name')->get(['id', 'name']);
        return response()->json($upzilas);
    }

    public function filterPhos($upzilaId)
    {
        $phos = User::where('role', 'pho')
            ->where('upzila_id', $upzilaId)
            ->orderBy('name')
            ->get(['id', 'name']);
        return response()->json($phos);
    }

    public function filterUnions($upzilaId)
    {
        $unions = Union::where('upzila_id', $upzilaId)->orderBy('name')->get(['id', 'name']);
        return response()->json($unions);
    }

    public function generateUsersReport(Request $request)
    {
        $query = User::with(['division', 'district', 'upzila', 'pho']);

        // Apply same filters as allUsers method
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

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

        // Get filter labels
        $filters = [
            'division' => $request->filled('division_id') ? Division::find($request->division_id)?->name : 'All',
            'district' => $request->filled('district_id') ? District::find($request->district_id)?->name : 'All',
            'upzila' => $request->filled('upzila_id') ? Upzila::find($request->upzila_id)?->name : 'All',
            'pho' => $request->filled('pho_id') ? User::find($request->pho_id)?->name : 'All',
            'role' => $request->filled('role') ? ucfirst(str_replace('_', ' ', $request->role)) : 'All',
        ];

        // Return HTML view that can be printed as PDF
        return view('backend.superadmin.reports.users-pdf', compact('users', 'filters'));
    }

    public function packageSales(Request $request)
    {
        // Get all PHO IDs
        $phoQuery = User::where('role', 'pho');

        // Apply division filter to PHOs
        if ($request->filled('division_id')) {
            $phoQuery->where('division_id', $request->division_id);
        }

        // Apply district filter to PHOs
        if ($request->filled('district_id')) {
            $phoQuery->where('district_id', $request->district_id);
        }

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

        // Get all PHOs for filter dropdown
        $phos = User::where('role', 'pho')
            ->orderBy('name')
            ->get();

        // Get packages for filter dropdown
        $packages = Package::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get all divisions for filter
        $divisions = Division::orderBy('name')->get();

        // Get all districts for filter
        $districts = District::orderBy('name')->get();

        // Get all upazilas for filter
        $upzilas = Upzila::orderBy('name')->get();

        return view('backend.superadmin.package-sales', compact(
            'packagePurchases',
            'phos',
            'packages',
            'divisions',
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
        // Get all PHO IDs
        $phoQuery = User::where('role', 'pho');

        // Apply division filter to PHOs
        if ($request->filled('division_id')) {
            $phoQuery->where('division_id', $request->division_id);
        }

        // Apply district filter to PHOs
        if ($request->filled('district_id')) {
            $phoQuery->where('district_id', $request->district_id);
        }

        // Apply upazila filter to PHOs
        if ($request->filled('upazila_id')) {
            $phoQuery->where('upzila_id', $request->upazila_id);
        }

        $phoIds = $phoQuery->pluck('id');

        // Get package purchases with filters
        $query = PackagePurchase::whereIn('pho_id', $phoIds)
            ->with(['package', 'customer', 'pho', 'payments']);

        // Apply other filters
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

        // Get filter labels
        $filters = [];
        if ($request->filled('division_id')) {
            $filters['Division'] = Division::find($request->division_id)->name ?? 'All';
        }
        if ($request->filled('district_id')) {
            $filters['District'] = District::find($request->district_id)->name ?? 'All';
        }
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

        $reportTitle = 'System-wide Package Sales Report';

        // Return HTML view that can be printed as PDF
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
