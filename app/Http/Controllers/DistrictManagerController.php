<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DistrictManagerController extends Controller
{
    /**
     * Display a listing of district managers.
     */
    public function index()
    {
        $districtManagers = User::where('role', 'district_manager')
            ->with(['division', 'district'])
            ->latest()
            ->paginate(10);

        return view('backend.superadmin.district-managers.index', compact('districtManagers'));
    }

    /**
     * Show the form for creating a new district manager.
     */
    public function create()
    {
        $divisions = Division::all();
        $assignedDistricts = User::where('role', 'district_manager')
            ->whereNotNull('district_id')
            ->pluck('district_id')
            ->toArray();

        return view('backend.superadmin.district-managers.create', compact('divisions', 'assignedDistricts'));
    }

    /**
     * Get districts by division (AJAX endpoint)
     */
    public function getDistricts($divisionId)
    {
        $districts = District::where('division_id', $divisionId)->get();
        $assignedDistricts = User::where('role', 'district_manager')
            ->whereNotNull('district_id')
            ->pluck('district_id')
            ->toArray();

        return response()->json([
            'districts' => $districts,
            'assignedDistricts' => $assignedDistricts
        ]);
    }

    /**
     * Store a newly created district manager in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
        ]);

        // Check if district already has a manager
        $existingManager = User::where('role', 'district_manager')
            ->where('district_id', $request->district_id)
            ->first();

        if ($existingManager) {
            return back()->withErrors(['district_id' => 'This district already has a District Manager assigned.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'district_manager',
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('superadmin.district-managers.index')
            ->with('success', 'District Manager created successfully.');
    }

    /**
     * Show the form for editing the specified district manager.
     */
    public function edit(User $districtManager)
    {
        if ($districtManager->role !== 'district_manager') {
            abort(404);
        }

        $divisions = Division::all();
        $districts = District::where('division_id', $districtManager->division_id)->get();
        $assignedDistricts = User::where('role', 'district_manager')
            ->whereNotNull('district_id')
            ->where('id', '!=', $districtManager->id)
            ->pluck('district_id')
            ->toArray();

        return view('backend.superadmin.district-managers.edit', compact('districtManager', 'divisions', 'districts', 'assignedDistricts'));
    }

    /**
     * Update the specified district manager in storage.
     */
    public function update(Request $request, User $districtManager)
    {
        if ($districtManager->role !== 'district_manager') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $districtManager->id,
            'password' => 'nullable|string|min:8|confirmed',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
        ]);

        // Check if district already has a manager (excluding current user)
        $existingManager = User::where('role', 'district_manager')
            ->where('district_id', $request->district_id)
            ->where('id', '!=', $districtManager->id)
            ->first();

        if ($existingManager) {
            return back()->withErrors(['district_id' => 'This district already has a District Manager assigned.'])->withInput();
        }

        $districtManager->name = $request->name;
        $districtManager->email = $request->email;
        $districtManager->division_id = $request->division_id;
        $districtManager->district_id = $request->district_id;

        if ($request->filled('password')) {
            $districtManager->password = Hash::make($request->password);
        }

        $districtManager->save();

        return redirect()->route('superadmin.district-managers.index')
            ->with('success', 'District Manager updated successfully.');
    }

    /**
     * Remove the specified district manager from storage.
     */
    public function destroy(User $districtManager)
    {
        if ($districtManager->role !== 'district_manager') {
            abort(404);
        }

        $districtManager->delete();

        return redirect()->route('superadmin.district-managers.index')
            ->with('success', 'District Manager deleted successfully.');
    }

    public function show(User $districtManager)
    {
        if ($districtManager->role !== 'district_manager') {
            abort(404);
        }

        return view('backend.superadmin.district-managers.show', compact('districtManager'));
    }
}
