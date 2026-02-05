<?php

namespace App\Http\Controllers\DistrictManager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Upzila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpazilaSupervisorManagementController extends Controller
{
    public function index()
    {
        $districtManager = auth()->user();

        $upazilaSupervisors = User::where('role', 'upazila_supervisor')
            ->where('district_id', $districtManager->district_id)
            ->with(['division', 'district', 'upzila', 'phos'])
            ->latest()
            ->paginate(15);

        return view('backend.district-manager.upazila-supervisors.index', compact('upazilaSupervisors'));
    }

    public function create()
    {
        $districtManager = auth()->user();

        // Get available upzilas in this district
        $upzilas = Upzila::where('district_id', $districtManager->district_id)->get();

        // Get upzilas that already have supervisors
        $assignedUpzilas = User::where('role', 'upazila_supervisor')
            ->where('district_id', $districtManager->district_id)
            ->pluck('upzila_id')
            ->toArray();

        return view('backend.district-manager.upazila-supervisors.create', compact('districtManager', 'upzilas', 'assignedUpzilas'));
    }

    public function store(Request $request)
    {
        $districtManager = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
            'upzila_id' => ['required', 'exists:upzilas,id'],
        ]);

        // Verify upzila belongs to this district
        $upzila = Upzila::findOrFail($validated['upzila_id']);
        if ($upzila->district_id !== $districtManager->district_id) {
            abort(403, 'You can only create supervisors in your district.');
        }

        // Check if upzila already has a supervisor
        $existingSupervisor = User::where('role', 'upazila_supervisor')
            ->where('upzila_id', $validated['upzila_id'])
            ->first();

        if ($existingSupervisor) {
            return back()->withErrors(['upzila_id' => 'This upazila already has a supervisor.'])->withInput();
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'upazila_supervisor',
            'division_id' => $districtManager->division_id,
            'district_id' => $districtManager->district_id,
            'upzila_id' => $validated['upzila_id'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('districtmanager.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor created successfully.');
    }

    public function edit(User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $districtManager = auth()->user();
        $upzilas = Upzila::where('district_id', $districtManager->district_id)->get();
        $assignedUpzilas = User::where('role', 'upazila_supervisor')
            ->where('district_id', $districtManager->district_id)
            ->where('id', '!=', $upazilaSupervisor->id)
            ->pluck('upzila_id')
            ->toArray();

        return view('backend.district-manager.upazila-supervisors.edit', compact('upazilaSupervisor', 'districtManager', 'upzilas', 'assignedUpzilas'));
    }

    public function update(Request $request, User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $districtManager = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($upazilaSupervisor->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($upazilaSupervisor->id)],
            'upzila_id' => ['required', 'exists:upzilas,id'],
        ]);

        $upzila = Upzila::findOrFail($validated['upzila_id']);
        if ($upzila->district_id !== $districtManager->district_id) {
            abort(403, 'You can only assign supervisors to upzilas in your district.');
        }

        if ($validated['upzila_id'] != $upazilaSupervisor->upzila_id) {
            $existingSupervisor = User::where('role', 'upazila_supervisor')
                ->where('upzila_id', $validated['upzila_id'])
                ->first();
            if ($existingSupervisor) {
                return back()->withErrors(['upzila_id' => 'This upazila already has a supervisor.'])->withInput();
            }
        }

        $upazilaSupervisor->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'upzila_id' => $validated['upzila_id'],
        ]);

        if (!empty($validated['password'])) {
            $upazilaSupervisor->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('districtmanager.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor updated successfully.');
    }

    public function destroy(User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $upazilaSupervisor->delete();

        return redirect()->route('districtmanager.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor deleted successfully.');
    }
}
