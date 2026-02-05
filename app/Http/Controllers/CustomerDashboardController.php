<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function dashboard()
    {
        $customer = auth()->user();

        return view('backend.customer.dashboard', compact('customer'));
    }
}
