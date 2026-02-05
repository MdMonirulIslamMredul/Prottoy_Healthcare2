<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PHOController extends Controller
{
    public function index()
    {
        $phos = User::where('role', 'pho')
            ->with(['division', 'district', 'upzila', 'upazilaSupervisor'])
            ->paginate(10);

        return view('backend.superadmin.phos.index', compact('phos'));
    }

    public function create()
    {
        // Get all divisional chiefs for the dropdown
        $divisionalChiefs = User::where('role', 'divisional_chief')->get();

        return view('backend.superadmin.phos.create', compact('divisionalChiefs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upzila_id' => 'required|exists:upzilas,id',
            'upazila_supervisor_id' => 'required|exists:users,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pho',
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'upzila_id' => $request->upzila_id,
            'upazila_supervisor_id' => $request->upazila_supervisor_id,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('superadmin.phos.index')
            ->with('success', 'PHO created successfully');
    }

    public function edit($id)
    {
        $pho = User::where('role', 'pho')->findOrFail($id);
        $divisionalChiefs = User::where('role', 'divisional_chief')->get();

        return view('backend.superadmin.phos.edit', compact('pho', 'divisionalChiefs'));
    }

    public function update(Request $request, $id)
    {
        $pho = User::where('role', 'pho')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upzila_id' => 'required|exists:upzilas,id',
            'upazila_supervisor_id' => 'required|exists:users,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'upzila_id' => $request->upzila_id,
            'upazila_supervisor_id' => $request->upazila_supervisor_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pho->update($data);

        return redirect()->route('superadmin.phos.index')
            ->with('success', 'PHO updated successfully');
    }

    public function destroy($id)
    {
        $pho = User::where('role', 'pho')->findOrFail($id);
        $pho->delete();

        return redirect()->route('superadmin.phos.index')
            ->with('success', 'PHO deleted successfully');
    }

    // AJAX endpoint to get district managers by divisional chief
    public function getDistrictManagers($divisionalChiefId)
    {
        $divisionalChief = User::where('role', 'divisional_chief')->findOrFail($divisionalChiefId);

        $districtManagers = User::where('role', 'district_manager')
            ->where('division_id', $divisionalChief->division_id)
            ->get(['id', 'name', 'district_id']);

        return response()->json(['districtManagers' => $districtManagers]);
    }

    // AJAX endpoint to get upazila supervisors by district manager
    public function getUpazilaSupervisors($districtManagerId)
    {
        $districtManager = User::where('role', 'district_manager')->findOrFail($districtManagerId);

        $upazilaSupervisors = User::where('role', 'upazila_supervisor')
            ->where('division_id', $districtManager->division_id)
            ->where('district_id', $districtManager->district_id)
            ->get(['id', 'name', 'upzila_id', 'division_id', 'district_id']);

        return response()->json(['upazilaSupervisors' => $upazilaSupervisors]);
    }
}
