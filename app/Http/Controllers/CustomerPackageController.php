<?php

namespace App\Http\Controllers;

use App\Models\PackagePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPackageController extends Controller
{
    /**
     * Display customer's purchased packages
     */
    public function index()
    {
        $purchases = PackagePurchase::where('customer_id', Auth::id())
            ->with(['package', 'pho', 'payments'])
            ->latest()
            ->paginate(15);

        return view('backend.customer.packages.index', compact('purchases'));
    }

    /**
     * Show details of a purchased package
     */
    public function show(PackagePurchase $purchase)
    {
        // Verify this purchase belongs to the authenticated customer
        if ($purchase->customer_id != Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $purchase->load(['package', 'pho', 'payments.receivedBy']);
        return view('backend.customer.packages.show', compact('purchase'));
    }
}
