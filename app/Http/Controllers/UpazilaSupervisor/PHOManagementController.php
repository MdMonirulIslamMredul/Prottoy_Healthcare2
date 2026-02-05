<?php

namespace App\Http\Controllers\UpazilaSupervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PHOManagementController extends Controller
{
    /**
     * Display a listing of PHOs managed by this Upazila Supervisor.
     */
    public function index()
    {
        $upazilaSupervisor = auth()->user();

        $phos = User::where('role', 'pho')
            ->where('upazila_supervisor_id', $upazilaSupervisor->id)
            ->with(['division', 'district', 'upzila', 'customers'])
            ->latest()
            ->paginate(15);

        return view('backend.upazila-supervisor.phos.index', compact('phos'));
    }

    /**
     * Show the form for creating a new PHO.
     */
    public function create()
    {
        $upazilaSupervisor = auth()->user();

        return view('backend.upazila-supervisor.phos.create', compact('upazilaSupervisor'));
    }

    /**
     * Store a newly created PHO in database.
     */
    public function store(Request $request)
    {
        $upazilaSupervisor = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'pho',
            'division_id' => $upazilaSupervisor->division_id,
            'district_id' => $upazilaSupervisor->district_id,
            'upzila_id' => $upazilaSupervisor->upzila_id,
            'upazila_supervisor_id' => $upazilaSupervisor->id,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('upazilasupervisor.phos.index')
            ->with('success', 'PHO created successfully.');
    }

    /**
     * Show the form for editing the specified PHO.
     */
    public function edit(User $pho)
    {
        // Ensure Upazila Supervisor can only edit their own PHOs
        if ($pho->upazila_supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $upazilaSupervisor = auth()->user();

        return view('backend.upazila-supervisor.phos.edit', compact('pho', 'upazilaSupervisor'));
    }

    /**
     * Update the specified PHO in database.
     */
    public function update(Request $request, User $pho)
    {
        // Ensure Upazila Supervisor can only update their own PHOs
        if ($pho->upazila_supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($pho->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($pho->id)],
        ]);

        $pho->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        // Update password only if provided
        if (!empty($validated['password'])) {
            $pho->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('upazilasupervisor.phos.index')
            ->with('success', 'PHO updated successfully.');
    }

    /**
     * Remove the specified PHO from database.
     */
    public function destroy(User $pho)
    {
        // Ensure Upazila Supervisor can only delete their own PHOs
        if ($pho->upazila_supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $pho->delete();

        return redirect()->route('upazilasupervisor.phos.index')
            ->with('success', 'PHO deleted successfully.');
    }
}
