<?php

namespace App\Http\Controllers\UpazilaSupervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerManagementController extends Controller
{
    /**
     * Display a listing of customers in this Upazila Supervisor's area.
     */
    public function index()
    {
        $upazilaSupervisor = auth()->user();

        $customers = User::where('role', 'customer')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->with(['division', 'district', 'upzila', 'pho'])
            ->withCount('packagePurchases')
            ->withSum('packagePurchases', 'total_price')
            ->withSum('packagePurchases', 'paid_amount')
            ->withSum('packagePurchases', 'due_amount')
            ->latest()
            ->paginate(15);

        return view('backend.upazila-supervisor.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        $upazilaSupervisor = auth()->user();

        // Get PHOs under this Upazila Supervisor
        $phos = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->get();

        return view('backend.upazila-supervisor.customers.create', compact('upazilaSupervisor', 'phos'));
    }

    /**
     * Store a newly created customer in database.
     */
    public function store(Request $request)
    {
        $upazilaSupervisor = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'address' => ['nullable', 'string', 'max:500'],
            'pho_id' => ['required', 'exists:users,id'],
        ]);

        // Verify the selected PHO belongs to this Upazila Supervisor
        $pho = User::findOrFail($validated['pho_id']);
        if ($pho->upazila_supervisor_id !== $upazilaSupervisor->id) {
            abort(403, 'You can only create customers under your own PHOs.');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'role' => 'customer',
            'division_id' => $upazilaSupervisor->division_id,
            'district_id' => $upazilaSupervisor->district_id,
            'upzila_id' => $upazilaSupervisor->upzila_id,
            'upazila_supervisor_id' => $upazilaSupervisor->id,
            'pho_id' => $validated['pho_id'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('upazilasupervisor.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(User $customer)
    {
        // Ensure Upazila Supervisor can only edit customers in their area
        if ($customer->upazila_supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $upazilaSupervisor = auth()->user();

        // Get PHOs under this Upazila Supervisor
        $phos = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->get();

        return view('backend.upazila-supervisor.customers.edit', compact('customer', 'upazilaSupervisor', 'phos'));
    }

    /**
     * Update the specified customer in database.
     */
    public function update(Request $request, User $customer)
    {
        // Ensure Upazila Supervisor can only update customers in their area
        if ($customer->upazila_supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $upazilaSupervisor = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($customer->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($customer->id)],
            'address' => ['nullable', 'string', 'max:500'],
            'pho_id' => ['required', 'exists:users,id'],
        ]);

        // Verify the selected PHO belongs to this Upazila Supervisor
        $pho = User::findOrFail($validated['pho_id']);
        if ($pho->upazila_supervisor_id !== $upazilaSupervisor->id) {
            abort(403, 'You can only assign customers to your own PHOs.');
        }

        $customer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'pho_id' => $validated['pho_id'],
        ]);

        // Update password only if provided
        if (!empty($validated['password'])) {
            $customer->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('upazilasupervisor.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from database.
     */
    public function destroy(User $customer)
    {
        // Ensure Upazila Supervisor can only delete customers in their area
        if ($customer->upazila_supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $customer->delete();

        return redirect()->route('upazilasupervisor.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
