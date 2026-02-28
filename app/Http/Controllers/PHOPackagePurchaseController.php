<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackagePurchase;
use App\Models\PackagePayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PHOPackagePurchaseController extends Controller
{
    /**
     * Display a listing of packages for purchase
     */
    public function index(Request $request)
    {
        $packages = Package::where('is_active', true)->get();

        $query = PackagePurchase::where('pho_id', Auth::id())
            ->with(['package', 'customer', 'payments']);

        if ($request->filled('customer_id')) {
            $customerId = $request->query('customer_id');
            // ensure the customer belongs to this PHO before applying filter
            if (User::where('id', $customerId)->where('pho_id', Auth::id())->exists()) {
                $query->where('customer_id', $customerId);
            }
        }

        $purchases = $query->latest()->paginate(15);

        return view('backend.pho.packages.index', compact('packages', 'purchases'));
    }

    /**
     * Display purchase history for a specific customer (PHO-only access).
     */
    public function customerPurchases(User $customer, Request $request)
    {
        // Ensure this customer belongs to the authenticated PHO
        if ($customer->pho_id != Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $purchases = PackagePurchase::where('customer_id', $customer->id)
            ->with(['package', 'pho', 'payments'])
            ->latest()
            ->paginate(15);

        $totalSpent = PackagePurchase::where('customer_id', $customer->id)->sum('total_price');
        $totalPaid = PackagePurchase::where('customer_id', $customer->id)->sum('paid_amount');
        $totalDue = PackagePurchase::where('customer_id', $customer->id)->sum('due_amount');

        $totalPurchases = PackagePurchase::where('customer_id', $customer->id)->count();

        $statusCounts = PackagePurchase::where('customer_id', $customer->id)
            ->selectRaw('payment_status, count(*) as cnt')
            ->groupBy('payment_status')
            ->pluck('cnt', 'payment_status')
            ->toArray();

        return view('backend.pho.customers.purchase-history', compact('customer', 'purchases', 'totalSpent', 'totalPaid', 'totalDue', 'totalPurchases', 'statusCounts'));
    }

    /**
     * Show the form for purchasing a package
     */
    public function create()
    {
        $packages = Package::where('is_active', true)->get();
        // Get customers under this PHO
        $customers = User::where('pho_id', Auth::id())
            ->where('role', 'customer')
            ->get();

        return view('backend.pho.packages.create', compact('packages', 'customers'));
    }

    /**
     * Store a newly purchased package
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_id' => 'required|exists:users,id',
            'purchase_date' => 'required|date',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Verify customer belongs to this PHO
        $customer = User::findOrFail($validated['customer_id']);
        if ($customer->pho_id != Auth::id()) {
            return back()->with('error', 'You can only purchase packages for your customers.');
        }

        $package = Package::findOrFail($validated['package_id']);

        // Validate paid amount
        if ($validated['paid_amount'] > $package->price) {
            return back()->with('error', 'Paid amount cannot exceed package price.');
        }

        DB::beginTransaction();
        try {
            // Create package purchase
            $dueAmount = $package->price - $validated['paid_amount'];
            $paymentStatus = $validated['paid_amount'] == 0 ? 'pending' : ($dueAmount == 0 ? 'paid' : 'partial');

            $purchase = PackagePurchase::create([
                'package_id' => $validated['package_id'],
                'customer_id' => $validated['customer_id'],
                'pho_id' => Auth::id(),
                'total_price' => $package->price,
                'paid_amount' => $validated['paid_amount'],
                'due_amount' => $dueAmount,
                'payment_status' => $paymentStatus,
                'purchase_date' => $validated['purchase_date'],
                'notes' => $validated['notes'],
            ]);

            // Create initial payment record if amount > 0
            if ($validated['paid_amount'] > 0) {
                PackagePayment::create([
                    'package_purchase_id' => $purchase->id,
                    'amount' => $validated['paid_amount'],
                    'payment_date' => $validated['purchase_date'],
                    'payment_method' => $request->payment_method,
                    'received_by' => Auth::id(),
                    'notes' => 'Initial payment',
                ]);
            }

            DB::commit();
            return redirect()->route('pho.packages.index')
                ->with('success', 'Package purchased successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error purchasing package: ' . $e->getMessage());
        }
    }

    /**
     * Show details of a purchase
     */
    public function show(PackagePurchase $purchase)
    {
        // Verify this purchase belongs to the authenticated PHO
        if ($purchase->pho_id != Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $purchase->load(['package', 'customer', 'payments.receivedBy']);
        return view('backend.pho.packages.show', compact('purchase'));
    }

    /**
     * Show form to add payment
     */
    public function addPayment(PackagePurchase $purchase)
    {
        // Verify this purchase belongs to the authenticated PHO
        if ($purchase->pho_id != Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($purchase->payment_status == 'paid') {
            return back()->with('error', 'This package is already fully paid.');
        }

        return view('backend.pho.packages.add-payment', compact('purchase'));
    }

    /**
     * Store payment for a purchase
     */
    public function storePayment(Request $request, PackagePurchase $purchase)
    {
        // Verify this purchase belongs to the authenticated PHO
        if ($purchase->pho_id != Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Validate payment amount
        if ($validated['amount'] > $purchase->due_amount) {
            return back()->with('error', 'Payment amount cannot exceed due amount.');
        }

        DB::beginTransaction();
        try {
            // Create payment record
            PackagePayment::create([
                'package_purchase_id' => $purchase->id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $request->payment_method,
                'received_by' => Auth::id(),
                'notes' => $validated['notes'],
            ]);

            // Update purchase record
            $newPaidAmount = $purchase->paid_amount + $validated['amount'];
            $newDueAmount = $purchase->total_price - $newPaidAmount;
            $newStatus = $newDueAmount == 0 ? 'paid' : 'partial';

            $purchase->update([
                'paid_amount' => $newPaidAmount,
                'due_amount' => $newDueAmount,
                'payment_status' => $newStatus,
            ]);

            DB::commit();
            return redirect()->route('pho.packages.show', $purchase)
                ->with('success', 'Payment added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error adding payment: ' . $e->getMessage());
        }
    }
}
