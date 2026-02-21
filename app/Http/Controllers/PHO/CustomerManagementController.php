<?php

namespace App\Http\Controllers\PHO;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerManagementController extends Controller
{
    /**
     * Display a listing of customers managed by this PHO.
     */
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->where('pho_id', auth()->id())
            ->with(['division', 'district', 'upzila', 'pho'])
            ->latest()
            ->paginate(15);

        return view('backend.pho.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        $pho = auth()->user();

        return view('backend.pho.customers.create', compact('pho'));
    }

    /**
     * Store a newly created customer in database.
     */
    public function store(Request $request)
    {
        $pho = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'address' => ['nullable', 'string', 'max:500'],
            'union_id' => ['nullable', 'exists:unions,id'],
        ]);

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
            'union_id' => $validated['union_id'] ?? null,
            'upazila_supervisor_id' => $pho->upazila_supervisor_id,
            'pho_id' => $pho->id,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('pho.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(User $customer)
    {
        // Ensure PHO can only edit their own customers
        if ($customer->pho_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $pho = auth()->user();

        return view('backend.pho.customers.edit', compact('customer', 'pho'));
    }

    /**
     * Update the specified customer in database.
     */
    public function update(Request $request, User $customer)
    {
        // Ensure PHO can only update their own customers
        if ($customer->pho_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($customer->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($customer->id)],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $customer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
        ]);

        // Update password only if provided
        if (!empty($validated['password'])) {
            $customer->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('pho.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from database.
     */
    public function destroy(User $customer)
    {
        // Ensure PHO can only delete their own customers
        if ($customer->pho_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $customer->delete();

        return redirect()->route('pho.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
