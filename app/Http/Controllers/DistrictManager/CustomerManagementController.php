<?php

namespace App\Http\Controllers\DistrictManager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerManagementController extends Controller
{
    public function index()
    {
        $districtManager = auth()->user();

        $customers = User::where('role', 'customer')
            ->where('district_id', $districtManager->district_id)
            ->with(['division', 'district', 'upzila', 'pho'])
            ->withCount('packagePurchases')
            ->withSum('packagePurchases', 'total_price')
            ->withSum('packagePurchases', 'paid_amount')
            ->withSum('packagePurchases', 'due_amount')
            ->latest()
            ->paginate(15);

        return view('backend.district-manager.customers.index', compact('customers'));
    }

    public function create()
    {
        $districtManager = auth()->user();

        // Get PHOs in this district
        $phos = User::where('role', 'pho')
            ->where('district_id', $districtManager->district_id)
            ->with(['upazilaSupervisor', 'upzila'])
            ->get();

        return view('backend.district-manager.customers.create', compact('districtManager', 'phos'));
    }

    public function store(Request $request)
    {
        $districtManager = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'address' => ['nullable', 'string', 'max:500'],
            'pho_id' => ['required', 'exists:users,id'],
        ]);

        // Verify PHO belongs to this district
        $pho = User::findOrFail($validated['pho_id']);
        if ($pho->district_id !== $districtManager->district_id) {
            abort(403, 'You can only create customers under PHOs in your district.');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'role' => 'customer',
            'division_id' => $pho->division_id,
            'district_id' => $pho->district_id,
            'upzila_id' => $pho->upzila_id,
            'upazila_supervisor_id' => $pho->upazila_supervisor_id,
            'pho_id' => $validated['pho_id'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('districtmanager.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function edit(User $customer)
    {
        if ($customer->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $districtManager = auth()->user();
        $phos = User::where('role', 'pho')
            ->where('district_id', $districtManager->district_id)
            ->with(['upazilaSupervisor', 'upzila'])
            ->get();

        return view('backend.district-manager.customers.edit', compact('customer', 'districtManager', 'phos'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $districtManager = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($customer->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($customer->id)],
            'address' => ['nullable', 'string', 'max:500'],
            'pho_id' => ['required', 'exists:users,id'],
        ]);

        $pho = User::findOrFail($validated['pho_id']);
        if ($pho->district_id !== $districtManager->district_id) {
            abort(403, 'You can only assign customers to PHOs in your district.');
        }

        $customer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'pho_id' => $validated['pho_id'],
            'division_id' => $pho->division_id,
            'upzila_id' => $pho->upzila_id,
            'upazila_supervisor_id' => $pho->upazila_supervisor_id,
        ]);

        if (!empty($validated['password'])) {
            $customer->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('districtmanager.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(User $customer)
    {
        if ($customer->district_id !== auth()->user()->district_id) {
            abort(403, 'Unauthorized action.');
        }

        $customer->delete();

        return redirect()->route('districtmanager.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
