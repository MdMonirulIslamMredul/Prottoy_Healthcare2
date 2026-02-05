<?php

namespace App\Http\Controllers\DivisionalChief;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DistrictManagerManagementController extends Controller
{
    public function index()
    {
        $divisionalChief = auth()->user();

        $districtManagers = User::where('role', 'district_manager')
            ->where('division_id', $divisionalChief->division_id)
            ->with(['district'])
            ->paginate(10);

        return view('backend.divisional-chief.district-managers.index', compact('districtManagers'));
    }

    public function create()
    {
        $divisionalChief = auth()->user();

        // Get districts in this division
        $districts = District::where('division_id', $divisionalChief->division_id)->get();

        // Get already assigned district IDs
        $assignedDistricts = User::where('role', 'district_manager')
            ->where('division_id', $divisionalChief->division_id)
            ->pluck('district_id')
            ->toArray();

        return view('backend.divisional-chief.district-managers.create', compact('districts', 'assignedDistricts'));
    }

    public function store(Request $request)
    {
        $divisionalChief = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'district_id' => 'required|exists:districts,id',
        ]);

        // Check if district already has a manager
        $exists = User::where('role', 'district_manager')
            ->where('district_id', $request->district_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['district_id' => 'This district already has a manager.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'district_manager',
            'division_id' => $divisionalChief->division_id,
            'district_id' => $request->district_id,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('divisionalchief.district-managers.index')
            ->with('success', 'District Manager created successfully');
    }

    public function edit($id)
    {
        $divisionalChief = auth()->user();

        $districtManager = User::where('role', 'district_manager')
            ->where('division_id', $divisionalChief->division_id)
            ->findOrFail($id);

        $districts = District::where('division_id', $divisionalChief->division_id)->get();

        $assignedDistricts = User::where('role', 'district_manager')
            ->where('division_id', $divisionalChief->division_id)
            ->where('id', '!=', $id)
            ->pluck('district_id')
            ->toArray();

        return view('backend.divisional-chief.district-managers.edit', compact('districtManager', 'districts', 'assignedDistricts'));
    }

    public function update(Request $request, $id)
    {
        $divisionalChief = auth()->user();

        $districtManager = User::where('role', 'district_manager')
            ->where('division_id', $divisionalChief->division_id)
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'district_id' => 'required|exists:districts,id',
        ]);

        // Check if district already has another manager
        $exists = User::where('role', 'district_manager')
            ->where('district_id', $request->district_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['district_id' => 'This district already has a manager.'])->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'district_id' => $request->district_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $districtManager->update($data);

        return redirect()->route('divisionalchief.district-managers.index')
            ->with('success', 'District Manager updated successfully');
    }

    public function destroy($id)
    {
        $divisionalChief = auth()->user();

        $districtManager = User::where('role', 'district_manager')
            ->where('division_id', $divisionalChief->division_id)
            ->findOrFail($id);

        $districtManager->delete();

        return redirect()->route('divisionalchief.district-managers.index')
            ->with('success', 'District Manager deleted successfully');
    }
}
