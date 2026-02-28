<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Union;
use App\Models\Division;
use App\Models\District;
use App\Models\Upzila;
use App\Models\Word;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')
            ->with(['division', 'district', 'upzila', 'union', 'pho', 'word'])
            ->withCount('packagePurchases')
            ->withSum('packagePurchases', 'total_price')
            ->withSum('packagePurchases', 'paid_amount')
            ->withSum('packagePurchases', 'due_amount');

        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }
        if ($request->filled('upzila_id')) {
            $query->where('upzila_id', $request->upzila_id);
        }
        if ($request->filled('union_id')) {
            $query->where('union_id', $request->union_id);
        }
        if ($request->filled('word_id')) {
            $query->where('word_id', $request->word_id);
        }

        $customers = $query->paginate(10)->appends($request->all());

        // Prep filter select lists (dependent lists filled when parent filter present)
        $divisions = Division::orderBy('name')->get(['id', 'name']);
        $districts = $request->filled('division_id') ? District::where('division_id', $request->division_id)->orderBy('name')->get(['id', 'name']) : collect();
        $upzilas = $request->filled('district_id') ? Upzila::where('district_id', $request->district_id)->orderBy('name')->get(['id', 'name']) : collect();
        $unions = $request->filled('upzila_id') ? Union::where('upzila_id', $request->upzila_id)->orderBy('name')->get(['id', 'name']) : collect();
        $words = $request->filled('union_id') ? Word::where('union_id', $request->union_id)->orderBy('name')->get(['id', 'name']) : collect();

        return view('backend.superadmin.customers.index', compact('customers', 'divisions', 'districts', 'upzilas', 'unions', 'words'));
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
            'union_id' => 'nullable|exists:unions,id',
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
            'union_id' => $request->union_id,
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
            'union_id' => 'nullable|exists:unions,id',
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
            'union_id' => $request->union_id,
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

    public function show($id)
    {
        $customer = User::where('role', 'customer')
            ->with(['division', 'district', 'upzila', 'union', 'pho'])
            ->withCount('packagePurchases')
            ->withSum('packagePurchases', 'total_price')
            ->withSum('packagePurchases', 'paid_amount')
            ->withSum('packagePurchases', 'due_amount')
            ->findOrFail($id);

        return view('backend.superadmin.customers.show', compact('customer'));
    }

    public function destroy($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $customer->delete();

        return redirect()->route('superadmin.customers.index')
            ->with('success', 'Customer deleted successfully');
    }

    // AJAX endpoint to get unions by upazila
    public function getUnions($upazilaId)
    {
        $unions = Union::where('upzila_id', $upazilaId)
            ->orderBy('name')
            ->get(['id', 'name', 'bn_name']);

        return response()->json(['unions' => $unions]);
    }

    // AJAX endpoint to get words by union
    public function getWords($unionId)
    {
        $words = \App\Models\Word::where('union_id', $unionId)
            ->orderBy('name')
            ->get(['id', 'name', 'bn_name']);

        return response()->json(['words' => $words]);
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
