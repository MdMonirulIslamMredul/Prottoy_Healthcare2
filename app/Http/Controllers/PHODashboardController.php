<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PHODashboardController extends Controller
{
    public function dashboard()
    {
        $pho = auth()->user();

        // Get statistics for this PHO
        $customersCount = User::where('role', 'customer')
            ->where('pho_id', $pho->id)
            ->count();

        // Get customers list
        $customers = User::where('role', 'customer')
            ->where('pho_id', $pho->id)
            ->latest()
            ->paginate(10);

        return view('backend.pho.dashboard', compact(
            'pho',
            'customersCount',
            'customers'
        ));
    }
}
