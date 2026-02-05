<?php

namespace App\Http\Controllers\DivisionalChief;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerManagementController extends Controller
{
    public function index()
    {
        $divisionalChief = auth()->user();

        $customers = User::where('role', 'customer')
            ->where('division_id', $divisionalChief->division_id)
            ->with(['division', 'district', 'upzila', 'pho'])
            ->latest()
            ->paginate(15);

        return view('backend.divisional-chief.customers.index', compact('customers'));
    }

    public function create()
    {
        $divisionalChief = auth()->user();

        // Get PHOs in this division
        $phos = User::where('role', 'pho')
            ->where('division_id', $divisionalChief->division_id)
            ->with(['upazilaSupervisor', 'district', 'upzila'])
            ->get();

        return view('backend.divisional-chief.customers.create', compact('divisionalChief', 'phos'));
    }

    public function store(Request $request)
    {
        $divisionalChief = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'address' => ['nullable', 'string', 'max:500'],
            'pho_id' => ['required', 'exists:users,id'],
        ]);

        // Verify PHO belongs to this division
        $pho = User::findOrFail($validated['pho_id']);
        if ($pho->division_id !== $divisionalChief->division_id) {
            abort(403, 'You can only create customers under PHOs in your division.');
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

        return redirect()->route('divisionalchief.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function edit(User $customer)
    {
        if ($customer->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $divisionalChief = auth()->user();
        $phos = User::where('role', 'pho')
            ->where('division_id', $divisionalChief->division_id)
            ->with(['upazilaSupervisor', 'district', 'upzila'])
            ->get();

        return view('backend.divisional-chief.customers.edit', compact('customer', 'divisionalChief', 'phos'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $divisionalChief = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($customer->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($customer->id)],
            'address' => ['nullable', 'string', 'max:500'],
            'pho_id' => ['required', 'exists:users,id'],
        ]);

        $pho = User::findOrFail($validated['pho_id']);
        if ($pho->division_id !== $divisionalChief->division_id) {
            abort(403, 'You can only assign customers to PHOs in your division.');
        }

        $customer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'pho_id' => $validated['pho_id'],
            'division_id' => $pho->division_id,
            'district_id' => $pho->district_id,
            'upzila_id' => $pho->upzila_id,
            'upazila_supervisor_id' => $pho->upazila_supervisor_id,
        ]);

        if (!empty($validated['password'])) {
            $customer->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('divisionalchief.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(User $customer)
    {
        if ($customer->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $customer->delete();

        return redirect()->route('divisionalchief.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
