<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->with(['division', 'district', 'upzila', 'pho'])
            ->paginate(10);

        return view('backend.superadmin.customers.index', compact('customers'));
    }

    public function create()
    {
        // Get all divisional chiefs for the dropdown
        $divisionalChiefs = User::where('role', 'divisional_chief')->get();

        return view('backend.superadmin.customers.create', compact('divisionalChiefs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => 'required|string|max:20|unique:users,phone',
            'address' => 'nullable|string|max:500',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upzila_id' => 'required|exists:upzilas,id',
            'pho_id' => 'required|exists:users,id',
        ]);

        // Get PHO to inherit upazila_supervisor_id
        $pho = User::findOrFail($request->pho_id);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'customer',
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'upzila_id' => $request->upzila_id,
            'upazila_supervisor_id' => $pho->upazila_supervisor_id,
            'pho_id' => $request->pho_id,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('superadmin.customers.index')
            ->with('success', 'Customer created successfully');
    }

    public function edit($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $divisionalChiefs = User::where('role', 'divisional_chief')->get();

        return view('backend.superadmin.customers.edit', compact('customer', 'divisionalChiefs'));
    }

    public function update(Request $request, $id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'phone' => 'required|string|max:20|unique:users,phone,' . $id,
            'address' => 'nullable|string|max:500',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upzila_id' => 'required|exists:upzilas,id',
            'pho_id' => 'required|exists:users,id',
        ]);

        // Get PHO to inherit upazila_supervisor_id
        $pho = User::findOrFail($request->pho_id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'upzila_id' => $request->upzila_id,
            'upazila_supervisor_id' => $pho->upazila_supervisor_id,
            'pho_id' => $request->pho_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return redirect()->route('superadmin.customers.index')
            ->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $customer->delete();

        return redirect()->route('superadmin.customers.index')
            ->with('success', 'Customer deleted successfully');
    }

    // AJAX endpoint to get PHOs by upazila supervisor
    public function getPHOs($upazilaSupervisorId)
    {
        $phos = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisorId)
            ->get(['id', 'name']);

        return response()->json(['phos' => $phos]);
    }
}
