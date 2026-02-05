<?php

namespace App\Http\Controllers\DivisionalChief;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PHOManagementController extends Controller
{
    public function index()
    {
        $divisionalChief = auth()->user();

        $phos = User::where('role', 'pho')
            ->where('division_id', $divisionalChief->division_id)
            ->with(['division', 'district', 'upzila', 'upazilaSupervisor', 'customers'])
            ->latest()
            ->paginate(15);

        return view('backend.divisional-chief.phos.index', compact('phos'));
    }

    public function create()
    {
        $divisionalChief = auth()->user();

        // Get upazila supervisors in this division
        $upazilaSupervisors = User::where('role', 'upazila_supervisor')
            ->where('division_id', $divisionalChief->division_id)
            ->with(['district', 'upzila'])
            ->get();

        return view('backend.divisional-chief.phos.create', compact('divisionalChief', 'upazilaSupervisors'));
    }

    public function store(Request $request)
    {
        $divisionalChief = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
            'upazila_supervisor_id' => ['required', 'exists:users,id'],
        ]);

        // Verify supervisor belongs to this division
        $supervisor = User::findOrFail($validated['upazila_supervisor_id']);
        if ($supervisor->division_id !== $divisionalChief->division_id) {
            abort(403, 'You can only create PHOs under supervisors in your division.');
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

        return redirect()->route('divisionalchief.phos.index')
            ->with('success', 'PHO created successfully.');
    }

    public function edit(User $pho)
    {
        if ($pho->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $divisionalChief = auth()->user();
        $upazilaSupervisors = User::where('role', 'upazila_supervisor')
            ->where('division_id', $divisionalChief->division_id)
            ->with(['district', 'upzila'])
            ->get();

        return view('backend.divisional-chief.phos.edit', compact('pho', 'divisionalChief', 'upazilaSupervisors'));
    }

    public function update(Request $request, User $pho)
    {
        if ($pho->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $divisionalChief = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($pho->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($pho->id)],
            'upazila_supervisor_id' => ['required', 'exists:users,id'],
        ]);

        $supervisor = User::findOrFail($validated['upazila_supervisor_id']);
        if ($supervisor->division_id !== $divisionalChief->division_id) {
            abort(403, 'You can only assign PHOs to supervisors in your division.');
        }

        $pho->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'upazila_supervisor_id' => $validated['upazila_supervisor_id'],
            'division_id' => $supervisor->division_id,
            'district_id' => $supervisor->district_id,
            'upzila_id' => $supervisor->upzila_id,
        ]);

        if (!empty($validated['password'])) {
            $pho->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('divisionalchief.phos.index')
            ->with('success', 'PHO updated successfully.');
    }

    public function destroy(User $pho)
    {
        if ($pho->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $pho->delete();

        return redirect()->route('divisionalchief.phos.index')
            ->with('success', 'PHO deleted successfully.');
    }
}
