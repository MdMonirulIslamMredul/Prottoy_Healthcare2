<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        return view('backend.upazila-supervisor.dashboard', compact(
            'upazilaSupervisor',
            'phosCount',
            'customersCount',
            'phos'
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
