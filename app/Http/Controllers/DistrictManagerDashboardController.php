<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Upzila;

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

        return view('backend.district-manager.dashboard', compact(
            'districtManager',
            'upazilaSupervisorsCount',
            'phosCount',
            'customersCount'
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
}
