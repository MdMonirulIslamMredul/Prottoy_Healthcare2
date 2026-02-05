<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\Upzila;

class DivisionalChiefDashboardController extends Controller
{
    public function dashboard()
    {
        $divisionalChief = auth()->user();

        // Get statistics for this divisional chief's division
        $districtManagersCount = User::where('role', 'district_manager')
            ->where('division_id', $divisionalChief->division_id)
            ->count();

        $upazilaSupervisorsCount = User::where('role', 'upazila_supervisor')
            ->where('division_id', $divisionalChief->division_id)
            ->count();

        $phosCount = User::where('role', 'pho')
            ->where('division_id', $divisionalChief->division_id)
            ->count();

        $customersCount = User::where('role', 'customer')
            ->where('division_id', $divisionalChief->division_id)
            ->count();

        return view('backend.divisional-chief.dashboard', compact(
            'divisionalChief',
            'districtManagersCount',
            'upazilaSupervisorsCount',
            'phosCount',
            'customersCount'
        ));
    }

    public function hierarchy()
    {
        $divisionalChief = auth()->user();

        // Get all districts in this division with their managers
        $districts = District::where('division_id', $divisionalChief->division_id)
            ->with([
                'districtManager',
                'upzilas.upazilaSupervisor',
                'upzilas.phos.customers'
            ])
            ->get()
            ->sortByDesc(function($district) {
                return $district->districtManager ? 1 : 0;
            });

        return view('backend.divisional-chief.hierarchy', compact('divisionalChief', 'districts'));
    }

    public function allUsers(Request $request)
    {
        $divisionalChief = auth()->user();

        $districts = District::where('division_id', $divisionalChief->division_id)->orderBy('name')->get();
        $upzilas = collect();
        $phos = collect();

        $query = User::with(['division', 'district', 'upzila', 'pho'])
            ->where('division_id', $divisionalChief->division_id);

        // Apply filters
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

        return view('backend.divisional-chief.all-users', compact(
            'users',
            'districts',
            'upzilas',
            'phos'
        ));
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

    public function generateUsersReport(Request $request)
    {
        $divisionalChief = auth()->user();

        $query = User::with(['division', 'district', 'upzila', 'pho'])
            ->where('division_id', $divisionalChief->division_id);

        // Apply same filters
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
            'district' => $request->filled('district_id') ? District::find($request->district_id)?->name : 'All',
            'upzila' => $request->filled('upzila_id') ? Upzila::find($request->upzila_id)?->name : 'All',
            'pho' => $request->filled('pho_id') ? User::find($request->pho_id)?->name : 'All',
            'role' => $request->filled('role') ? ucfirst(str_replace('_', ' ', $request->role)) : 'All',
        ];

        return view('backend.divisional-chief.reports.users-pdf', compact('users', 'filters', 'divisionalChief'));
    }
}
