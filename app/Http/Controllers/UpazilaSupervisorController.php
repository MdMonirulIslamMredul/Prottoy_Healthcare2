<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Upzila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpazilaSupervisorController extends Controller
{
    /**
     * Display a listing of upazila supervisors.
     */
    public function index()
    {
        $upazilaSupervisors = User::where('role', 'upazila_supervisor')
            ->with(['division', 'district', 'upzila'])
            ->latest()
            ->paginate(10);

        return view('backend.superadmin.upazila-supervisors.index', compact('upazilaSupervisors'));
    }

    /**
     * Show the form for creating a new upazila supervisor.
     */
    public function create()
    {
        $divisions = Division::all();
        $assignedUpzilas = User::where('role', 'upazila_supervisor')
            ->whereNotNull('upzila_id')
            ->pluck('upzila_id')
            ->toArray();

        return view('backend.superadmin.upazila-supervisors.create', compact('divisions', 'assignedUpzilas'));
    }

    /**
     * Get upzilas by district (AJAX endpoint)
     */
    public function getUpzilas($districtId)
    {
        $upzilas = Upzila::where('district_id', $districtId)->get();
        $assignedUpzilas = User::where('role', 'upazila_supervisor')
            ->whereNotNull('upzila_id')
            ->pluck('upzila_id')
            ->toArray();

        return response()->json([
            'upzilas' => $upzilas,
            'assignedUpzilas' => $assignedUpzilas
        ]);
    }

    /**
     * Store a newly created upazila supervisor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upzila_id' => 'required|exists:upzilas,id',
        ]);

        // Check if upazila already has a supervisor
        $existingSupervisor = User::where('role', 'upazila_supervisor')
            ->where('upzila_id', $request->upzila_id)
            ->first();

        if ($existingSupervisor) {
            return back()->withErrors(['upzila_id' => 'This upazila already has a Supervisor assigned.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'upazila_supervisor',
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'upzila_id' => $request->upzila_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('superadmin.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor created successfully.');
    }

    /**
     * Show the form for editing the specified upazila supervisor.
     */
    public function edit(User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->role !== 'upazila_supervisor') {
            abort(404);
        }

        $divisions = Division::all();
        $districts = District::where('division_id', $upazilaSupervisor->division_id)->get();
        $upzilas = Upzila::where('district_id', $upazilaSupervisor->district_id)->get();
        $assignedUpzilas = User::where('role', 'upazila_supervisor')
            ->whereNotNull('upzila_id')
            ->where('id', '!=', $upazilaSupervisor->id)
            ->pluck('upzila_id')
            ->toArray();

        return view('backend.superadmin.upazila-supervisors.edit', compact('upazilaSupervisor', 'divisions', 'districts', 'upzilas', 'assignedUpzilas'));
    }

    /**
     * Update the specified upazila supervisor in storage.
     */
    public function update(Request $request, User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->role !== 'upazila_supervisor') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $upazilaSupervisor->id,
            'password' => 'nullable|string|min:8|confirmed',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upzila_id' => 'required|exists:upzilas,id',
        ]);

        // Check if upazila already has a supervisor (excluding current user)
        $existingSupervisor = User::where('role', 'upazila_supervisor')
            ->where('upzila_id', $request->upzila_id)
            ->where('id', '!=', $upazilaSupervisor->id)
            ->first();

        if ($existingSupervisor) {
            return back()->withErrors(['upzila_id' => 'This upazila already has a Supervisor assigned.'])->withInput();
        }

        $upazilaSupervisor->name = $request->name;
        $upazilaSupervisor->email = $request->email;
        $upazilaSupervisor->division_id = $request->division_id;
        $upazilaSupervisor->district_id = $request->district_id;
        $upazilaSupervisor->upzila_id = $request->upzila_id;

        if ($request->filled('password')) {
            $upazilaSupervisor->password = Hash::make($request->password);
        }

        $upazilaSupervisor->save();

        return redirect()->route('superadmin.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor updated successfully.');
    }

    /**
     * Remove the specified upazila supervisor from storage.
     */
    public function destroy(User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->role !== 'upazila_supervisor') {
            abort(404);
        }

        $upazilaSupervisor->delete();

        return redirect()->route('superadmin.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor deleted successfully.');
    }
    public function show(User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->role !== 'upazila_supervisor') {
            abort(404);
        }

        return view('backend.superadmin.upazila-supervisors.show', compact('upazilaSupervisor'));
    }
}
