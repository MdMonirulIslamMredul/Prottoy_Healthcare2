<?php

namespace App\Http\Controllers\DistrictManager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PHOManagementController extends Controller
{
    public function index()
    {
        $districtManager = auth()->user();

        $phos = User::where('role', 'pho')
            ->where('district_id', $districtManager->district_id)
            ->with(['division', 'district', 'upzila', 'upazilaSupervisor', 'customers'])
            ->withCount('packageSales')
            ->withSum('packageSales', 'total_price')
            ->withSum('packageSales', 'paid_amount')
            ->withSum('packageSales', 'due_amount')
            ->latest()
            ->paginate(15);

        return view('backend.district-manager.phos.index', compact('phos'));
    }

    public function create()
    {
        $districtManager = auth()->user();

        // Get upazila supervisors in this district
        $upazilaSupervisors = User::where('role', 'upazila_supervisor')
            ->where('district_id', $districtManager->district_id)
            ->with('upzila')
            ->get();

        return view('backend.district-manager.phos.create', compact('districtManager', 'upazilaSupervisors'));
    }

    public function store(Request $request)
    {
        $districtManager = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
            'upazila_supervisor_id' => ['required', 'exists:users,id'],
        ]);

        // Verify supervisor belongs to this district
        $supervisor = User::findOrFail($validated['upazila_supervisor_id']);
        if ($supervisor->district_id !== $districtManager->district_id) {
            abort(403, 'You can only create PHOs under supervisors in your district.');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'pho',
            'division_id' => $supervisor->division_id,
            'district_id' => $supervisor->district_id,
            'upzila_id' => $supervisor->upzila_id,
            'upazila_supervisor_id' => $validated['upazila_supervisor_id'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('districtmanager.phos.index')
            ->with('success', 'PHO created successfully.');
    }

    public function edit(User $pho)
    {
        if ($pho->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $districtManager = auth()->user();
        $upazilaSupervisors = User::where('role', 'upazila_supervisor')
            ->where('district_id', $districtManager->district_id)
            ->with('upzila')
            ->get();

        return view('backend.district-manager.phos.edit', compact('pho', 'districtManager', 'upazilaSupervisors'));
    }

    public function update(Request $request, User $pho)
    {
        if ($pho->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $districtManager = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($pho->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($pho->id)],
            'upazila_supervisor_id' => ['required', 'exists:users,id'],
        ]);

        $supervisor = User::findOrFail($validated['upazila_supervisor_id']);
        if ($supervisor->district_id !== $districtManager->district_id) {
            abort(403, 'You can only assign PHOs to supervisors in your district.');
        }

        $pho->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'upazila_supervisor_id' => $validated['upazila_supervisor_id'],
            'division_id' => $supervisor->division_id,
            'upzila_id' => $supervisor->upzila_id,
        ]);

        if (!empty($validated['password'])) {
            $pho->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('districtmanager.phos.index')
            ->with('success', 'PHO updated successfully.');
    }

    public function destroy(User $pho)
    {
        if ($pho->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $pho->delete();

        return redirect()->route('districtmanager.phos.index')
            ->with('success', 'PHO deleted successfully.');
    }
}
