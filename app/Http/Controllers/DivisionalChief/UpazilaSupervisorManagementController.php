<?php

namespace App\Http\Controllers\DivisionalChief;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\District;
use App\Models\Upzila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpazilaSupervisorManagementController extends Controller
{
    public function index()
    {
        $divisionalChief = auth()->user();

        $upazilaSupervisors = User::where('role', 'upazila_supervisor')
            ->where('division_id', $divisionalChief->division_id)
            ->with(['division', 'district', 'upzila', 'phos'])
            ->latest()
            ->paginate(15);

        return view('backend.divisional-chief.upazila-supervisors.index', compact('upazilaSupervisors'));
    }

    public function create()
    {
        $divisionalChief = auth()->user();

        // Get districts in this division
        $districts = District::where('division_id', $divisionalChief->division_id)->get();

        return view('backend.divisional-chief.upazila-supervisors.create', compact('divisionalChief', 'districts'));
    }

    public function store(Request $request)
    {
        $divisionalChief = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
            'district_id' => ['required', 'exists:districts,id'],
            'upzila_id' => ['required', 'exists:upzilas,id'],
        ]);

        // Verify district belongs to this division
        $district = District::findOrFail($validated['district_id']);
        if ($district->division_id !== $divisionalChief->division_id) {
            abort(403, 'You can only create supervisors in your division.');
        }

        // Verify upzila belongs to selected district
        $upzila = Upzila::findOrFail($validated['upzila_id']);
        if ($upzila->district_id !== $validated['district_id']) {
            abort(403, 'Selected upzila does not belong to the selected district.');
        }

        // Check if upzila already has a supervisor
        $existingSupervisor = User::where('role', 'upazila_supervisor')
            ->where('upzila_id', $validated['upzila_id'])
            ->first();

        if ($existingSupervisor) {
            return back()->withErrors(['upzila_id' => 'This upzila already has a supervisor.'])->withInput();
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'upazila_supervisor',
            'division_id' => $divisionalChief->division_id,
            'district_id' => $validated['district_id'],
            'upzila_id' => $validated['upzila_id'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('divisionalchief.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor created successfully.');
    }

    public function edit(User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $divisionalChief = auth()->user();
        $districts = District::where('division_id', $divisionalChief->division_id)->get();

        return view('backend.divisional-chief.upazila-supervisors.edit', compact('upazilaSupervisor', 'divisionalChief', 'districts'));
    }

    public function update(Request $request, User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $divisionalChief = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($upazilaSupervisor->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($upazilaSupervisor->id)],
            'district_id' => ['required', 'exists:districts,id'],
            'upzila_id' => ['required', 'exists:upzilas,id'],
        ]);

        $district = District::findOrFail($validated['district_id']);
        if ($district->division_id !== $divisionalChief->division_id) {
            abort(403, 'You can only assign supervisors to districts in your division.');
        }

        $upzila = Upzila::findOrFail($validated['upzila_id']);
        if ($upzila->district_id !== $validated['district_id']) {
            abort(403, 'Selected upzila does not belong to the selected district.');
        }

        if ($validated['upzila_id'] != $upazilaSupervisor->upzila_id) {
            $existingSupervisor = User::where('role', 'upazila_supervisor')
                ->where('upzila_id', $validated['upzila_id'])
                ->first();
            if ($existingSupervisor) {
                return back()->withErrors(['upzila_id' => 'This upzila already has a supervisor.'])->withInput();
            }
        }

        $upazilaSupervisor->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'district_id' => $validated['district_id'],
            'upzila_id' => $validated['upzila_id'],
        ]);

        if (!empty($validated['password'])) {
            $upazilaSupervisor->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('divisionalchief.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor updated successfully.');
    }

    public function destroy(User $upazilaSupervisor)
    {
        if ($upazilaSupervisor->division_id !== auth()->user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $upazilaSupervisor->delete();

        return redirect()->route('divisionalchief.upazila-supervisors.index')
            ->with('success', 'Upazila Supervisor deleted successfully.');
    }
}
