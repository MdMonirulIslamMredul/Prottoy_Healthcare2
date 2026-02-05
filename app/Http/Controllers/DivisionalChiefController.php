<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DivisionalChiefController extends Controller
{
    /**
     * Display a listing of divisional chiefs.
     */
    public function index()
    {
        $divisionalChiefs = User::where('role', 'divisional_chief')
            ->with('division')
            ->latest()
            ->paginate(10);

        return view('backend.superadmin.divisional-chiefs.index', compact('divisionalChiefs'));
    }

    /**
     * Show the form for creating a new divisional chief.
     */
    public function create()
    {
        $divisions = Division::all();
        $assignedDivisions = User::where('role', 'divisional_chief')
            ->whereNotNull('division_id')
            ->pluck('division_id')
            ->toArray();

        return view('backend.superadmin.divisional-chiefs.create', compact('divisions', 'assignedDivisions'));
    }

    /**
     * Store a newly created divisional chief in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'division_id' => 'required|exists:divisions,id',
        ]);

        // Check if division already has a chief
        $existingChief = User::where('role', 'divisional_chief')
            ->where('division_id', $request->division_id)
            ->first();

        if ($existingChief) {
            return back()->withErrors(['division_id' => 'This division already has a Divisional Chief assigned.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'divisional_chief',
            'division_id' => $request->division_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('superadmin.divisional-chiefs.index')
            ->with('success', 'Divisional Chief created successfully.');
    }

    /**
     * Show the form for editing the specified divisional chief.
     */
    public function edit(User $divisionalChief)
    {
        if ($divisionalChief->role !== 'divisional_chief') {
            abort(404);
        }

        $divisions = Division::all();
        $assignedDivisions = User::where('role', 'divisional_chief')
            ->whereNotNull('division_id')
            ->where('id', '!=', $divisionalChief->id)
            ->pluck('division_id')
            ->toArray();

        return view('backend.superadmin.divisional-chiefs.edit', compact('divisionalChief', 'divisions', 'assignedDivisions'));
    }

    /**
     * Update the specified divisional chief in storage.
     */
    public function update(Request $request, User $divisionalChief)
    {
        if ($divisionalChief->role !== 'divisional_chief') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $divisionalChief->id,
            'password' => 'nullable|string|min:8|confirmed',
            'division_id' => 'required|exists:divisions,id',
        ]);

        // Check if division already has a chief (excluding current user)
        $existingChief = User::where('role', 'divisional_chief')
            ->where('division_id', $request->division_id)
            ->where('id', '!=', $divisionalChief->id)
            ->first();

        if ($existingChief) {
            return back()->withErrors(['division_id' => 'This division already has a Divisional Chief assigned.'])->withInput();
        }

        $divisionalChief->name = $request->name;
        $divisionalChief->email = $request->email;
        $divisionalChief->division_id = $request->division_id;

        if ($request->filled('password')) {
            $divisionalChief->password = Hash::make($request->password);
        }

        $divisionalChief->save();

        return redirect()->route('superadmin.divisional-chiefs.index')
            ->with('success', 'Divisional Chief updated successfully.');
    }

    /**
     * Remove the specified divisional chief from storage.
     */
    public function destroy(User $divisionalChief)
    {
        if ($divisionalChief->role !== 'divisional_chief') {
            abort(404);
        }

        $divisionalChief->delete();

        return redirect()->route('superadmin.divisional-chiefs.index')
            ->with('success', 'Divisional Chief deleted successfully.');
    }
}
