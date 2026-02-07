<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\DivisionalChiefController;
use App\Http\Controllers\DistrictManagerController;
use App\Http\Controllers\UpazilaSupervisorController;
use App\Http\Controllers\PHOController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PHOPackagePurchaseController;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\DivisionalChiefDashboardController;
use App\Http\Controllers\DistrictManagerDashboardController;
use App\Http\Controllers\UpazilaSupervisorDashboardController;
use App\Http\Controllers\PHODashboardController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\DivisionalChief\DistrictManagerManagementController as DivChiefDistrictMgrController;
use App\Http\Controllers\DivisionalChief\UpazilaSupervisorManagementController as DivChiefUpazilaSupervisorController;
use App\Http\Controllers\DivisionalChief\PHOManagementController as DivChiefPHOController;
use App\Http\Controllers\DivisionalChief\CustomerManagementController as DivChiefCustomerController;
use App\Http\Controllers\PHO\CustomerManagementController as PHOCustomerController;
use App\Http\Controllers\UpazilaSupervisor\PHOManagementController as UpazilaSupervisorPHOController;
use App\Http\Controllers\UpazilaSupervisor\CustomerManagementController as UpazilaSupervisorCustomerController;
use App\Http\Controllers\DistrictManager\UpazilaSupervisorManagementController as DistrictManagerUpazilaSupervisorController;
use App\Http\Controllers\DistrictManager\PHOManagementController as DistrictManagerPHOController;
use App\Http\Controllers\DistrictManager\CustomerManagementController as DistrictManagerCustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Models\Division;
use App\Models\District;
use App\Models\Upzila;
use App\Models\User;

// Frontend Public Routes
Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('/about-us', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/organisation-leadership', [FrontendController::class, 'organisation'])->name('frontend.organisation');
Route::get('/policy-legal', [FrontendController::class, 'policy'])->name('frontend.policy');
Route::get('/customer-service-claims', [FrontendController::class, 'customerService'])->name('frontend.customer-service');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('frontend.gallery');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes (All authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Super Admin Routes
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

    // Hierarchy View
    Route::get('/hierarchy', [SuperAdminController::class, 'hierarchy'])->name('superadmin.hierarchy');

    // Package Sales
    Route::get('/package-sales', [SuperAdminController::class, 'packageSales'])->name('superadmin.package-sales');

    // All Users with Filters
    Route::get('/all-users', [SuperAdminController::class, 'allUsers'])->name('superadmin.all-users');
    Route::get('/generate-users-report', [SuperAdminController::class, 'generateUsersReport'])->name('superadmin.generate-users-report');
    Route::get('/filter-districts/{division}', [SuperAdminController::class, 'filterDistricts'])->name('superadmin.filter-districts');
    Route::get('/filter-upzilas/{district}', [SuperAdminController::class, 'filterUpzilas'])->name('superadmin.filter-upzilas');
    Route::get('/filter-phos/{upzila}', [SuperAdminController::class, 'filterPhos'])->name('superadmin.filter-phos');

    // Divisional Chiefs Management
    Route::resource('divisional-chiefs', DivisionalChiefController::class)->names([
        'index' => 'superadmin.divisional-chiefs.index',
        'create' => 'superadmin.divisional-chiefs.create',
        'store' => 'superadmin.divisional-chiefs.store',
        'edit' => 'superadmin.divisional-chiefs.edit',
        'update' => 'superadmin.divisional-chiefs.update',
        'destroy' => 'superadmin.divisional-chiefs.destroy',
    ]);

    // District Managers Management
    Route::resource('district-managers', DistrictManagerController::class)->names([
        'index' => 'superadmin.district-managers.index',
        'create' => 'superadmin.district-managers.create',
        'store' => 'superadmin.district-managers.store',
        'edit' => 'superadmin.district-managers.edit',
        'update' => 'superadmin.district-managers.update',
        'destroy' => 'superadmin.district-managers.destroy',
    ]);

    // Upazila Supervisors Management
    Route::resource('upazila-supervisors', UpazilaSupervisorController::class)->names([
        'index' => 'superadmin.upazila-supervisors.index',
        'create' => 'superadmin.upazila-supervisors.create',
        'store' => 'superadmin.upazila-supervisors.store',
        'edit' => 'superadmin.upazila-supervisors.edit',
        'update' => 'superadmin.upazila-supervisors.update',
        'destroy' => 'superadmin.upazila-supervisors.destroy',
    ]);

    // AJAX endpoint for getting districts by division
    Route::get('/get-districts/{division}', [DistrictManagerController::class, 'getDistricts'])
        ->name('superadmin.get-districts');

    // AJAX endpoint for getting upzilas by district
    Route::get('/get-upzilas/{district}', [UpazilaSupervisorController::class, 'getUpzilas'])
        ->name('superadmin.get-upzilas');

    // PHO Management
    Route::resource('phos', PHOController::class)->names([
        'index' => 'superadmin.phos.index',
        'create' => 'superadmin.phos.create',
        'store' => 'superadmin.phos.store',
        'edit' => 'superadmin.phos.edit',
        'update' => 'superadmin.phos.update',
        'destroy' => 'superadmin.phos.destroy',
    ]);

    // Customer Management
    Route::resource('customers', CustomerController::class)->names([
        'index' => 'superadmin.customers.index',
        'create' => 'superadmin.customers.create',
        'store' => 'superadmin.customers.store',
        'edit' => 'superadmin.customers.edit',
        'update' => 'superadmin.customers.update',
        'destroy' => 'superadmin.customers.destroy',
    ]);

    // AJAX endpoints for hierarchical user selection
    Route::get('/get-district-managers/{divisionalChief}', [PHOController::class, 'getDistrictManagers'])
        ->name('superadmin.get-district-managers');

    Route::get('/get-upazila-supervisors/{districtManager}', [PHOController::class, 'getUpazilaSupervisors'])
        ->name('superadmin.get-upazila-supervisors');

    Route::get('/get-phos/{upazilaSupervisor}', [CustomerController::class, 'getPHOs'])
        ->name('superadmin.get-phos');

    // Package Management
    Route::resource('packages', PackageController::class)->except(['show'])->names([
        'index' => 'packages.index',
        'create' => 'packages.create',
        'store' => 'packages.store',
        'edit' => 'packages.edit',
        'update' => 'packages.update',
        'destroy' => 'packages.destroy',
    ]);
    Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');
});

// Divisional Chief Routes
Route::middleware(['auth', 'divisionalchief'])->prefix('divisional-chief')->group(function () {
    Route::get('/dashboard', [DivisionalChiefDashboardController::class, 'dashboard'])->name('divisionalchief.dashboard');

    // District Managers Management
    Route::resource('district-managers', DivChiefDistrictMgrController::class)->names([
        'index' => 'divisionalchief.district-managers.index',
        'create' => 'divisionalchief.district-managers.create',
        'store' => 'divisionalchief.district-managers.store',
        'edit' => 'divisionalchief.district-managers.edit',
        'update' => 'divisionalchief.district-managers.update',
        'destroy' => 'divisionalchief.district-managers.destroy',
    ]);

    // Upazila Supervisors Management
    Route::resource('upazila-supervisors', DivChiefUpazilaSupervisorController::class)->names([
        'index' => 'divisionalchief.upazila-supervisors.index',
        'create' => 'divisionalchief.upazila-supervisors.create',
        'store' => 'divisionalchief.upazila-supervisors.store',
        'edit' => 'divisionalchief.upazila-supervisors.edit',
        'update' => 'divisionalchief.upazila-supervisors.update',
        'destroy' => 'divisionalchief.upazila-supervisors.destroy',
    ]);

    // PHO Management
    Route::resource('phos', DivChiefPHOController::class)->names([
        'index' => 'divisionalchief.phos.index',
        'create' => 'divisionalchief.phos.create',
        'store' => 'divisionalchief.phos.store',
        'edit' => 'divisionalchief.phos.edit',
        'update' => 'divisionalchief.phos.update',
        'destroy' => 'divisionalchief.phos.destroy',
    ]);

    // Customer Management
    Route::resource('customers', DivChiefCustomerController::class)->names([
        'index' => 'divisionalchief.customers.index',
        'create' => 'divisionalchief.customers.create',
        'store' => 'divisionalchief.customers.store',
        'edit' => 'divisionalchief.customers.edit',
        'update' => 'divisionalchief.customers.update',
        'destroy' => 'divisionalchief.customers.destroy',
    ]);

    // AJAX endpoints for cascading dropdowns
    Route::get('/get-upzilas/{district}', function($districtId) {
        $upzilas = \App\Models\Upzila::where('district_id', $districtId)->get(['id', 'name']);
        return response()->json($upzilas);
    })->name('divisionalchief.get-upzilas');

    // Hierarchy View
    Route::get('/hierarchy', [DivisionalChiefDashboardController::class, 'hierarchy'])->name('divisionalchief.hierarchy');

    // Package Sales
    Route::get('/package-sales', [DivisionalChiefDashboardController::class, 'packageSales'])->name('divisionalchief.package-sales');

    // All Users with Filters
    Route::get('/all-users', [DivisionalChiefDashboardController::class, 'allUsers'])->name('divisionalchief.all-users');
    Route::get('/generate-users-report', [DivisionalChiefDashboardController::class, 'generateUsersReport'])->name('divisionalchief.generate-users-report');
    Route::get('/filter-upzilas/{district}', [DivisionalChiefDashboardController::class, 'filterUpzilas'])->name('divisionalchief.filter-upzilas-ajax');
    Route::get('/filter-phos/{upzila}', [DivisionalChiefDashboardController::class, 'filterPhos'])->name('divisionalchief.filter-phos');
});

// District Manager Routes
Route::middleware(['auth', 'districtmanager'])->prefix('district-manager')->group(function () {
    Route::get('/dashboard', [DistrictManagerDashboardController::class, 'dashboard'])->name('districtmanager.dashboard');

    // Upazila Supervisors Management
    Route::resource('upazila-supervisors', DistrictManagerUpazilaSupervisorController::class)->names([
        'index' => 'districtmanager.upazila-supervisors.index',
        'create' => 'districtmanager.upazila-supervisors.create',
        'store' => 'districtmanager.upazila-supervisors.store',
        'edit' => 'districtmanager.upazila-supervisors.edit',
        'update' => 'districtmanager.upazila-supervisors.update',
        'destroy' => 'districtmanager.upazila-supervisors.destroy',
    ]);

    // PHO Management
    Route::resource('phos', DistrictManagerPHOController::class)->names([
        'index' => 'districtmanager.phos.index',
        'create' => 'districtmanager.phos.create',
        'store' => 'districtmanager.phos.store',
        'edit' => 'districtmanager.phos.edit',
        'update' => 'districtmanager.phos.update',
        'destroy' => 'districtmanager.phos.destroy',
    ]);

    // Customer Management
    Route::resource('customers', DistrictManagerCustomerController::class)->names([
        'index' => 'districtmanager.customers.index',
        'create' => 'districtmanager.customers.create',
        'store' => 'districtmanager.customers.store',
        'edit' => 'districtmanager.customers.edit',
        'update' => 'districtmanager.customers.update',
        'destroy' => 'districtmanager.customers.destroy',
    ]);

    // Hierarchy View
    Route::get('/hierarchy', [DistrictManagerDashboardController::class, 'hierarchy'])->name('districtmanager.hierarchy');

    // Package Sales
    Route::get('/package-sales', [DistrictManagerDashboardController::class, 'packageSales'])->name('districtmanager.package-sales');

    // All Users with Filters
    Route::get('/all-users', [DistrictManagerDashboardController::class, 'allUsers'])->name('districtmanager.all-users');
    Route::get('/generate-users-report', [DistrictManagerDashboardController::class, 'generateUsersReport'])->name('districtmanager.generate-users-report');
    Route::get('/filter-phos/{upzila}', [DistrictManagerDashboardController::class, 'filterPhos'])->name('districtmanager.filter-phos');
});

// Upazila Supervisor Routes
Route::middleware(['auth', 'upazilasupervisor'])->prefix('upazila-supervisor')->group(function () {
    Route::get('/dashboard', [UpazilaSupervisorDashboardController::class, 'dashboard'])->name('upazilasupervisor.dashboard');

    // PHO Management
    Route::resource('phos', UpazilaSupervisorPHOController::class)->names([
        'index' => 'upazilasupervisor.phos.index',
        'create' => 'upazilasupervisor.phos.create',
        'store' => 'upazilasupervisor.phos.store',
        'edit' => 'upazilasupervisor.phos.edit',
        'update' => 'upazilasupervisor.phos.update',
        'destroy' => 'upazilasupervisor.phos.destroy',
    ]);

    // Customer Management
    Route::resource('customers', UpazilaSupervisorCustomerController::class)->names([
        'index' => 'upazilasupervisor.customers.index',
        'create' => 'upazilasupervisor.customers.create',
        'store' => 'upazilasupervisor.customers.store',
        'edit' => 'upazilasupervisor.customers.edit',
        'update' => 'upazilasupervisor.customers.update',
        'destroy' => 'upazilasupervisor.customers.destroy',
    ]);

    // Hierarchy View
    Route::get('/hierarchy', [UpazilaSupervisorDashboardController::class, 'hierarchy'])->name('upazilasupervisor.hierarchy');

    // All Users with Filters
    Route::get('/all-users', [UpazilaSupervisorDashboardController::class, 'allUsers'])->name('upazilasupervisor.all-users');
    Route::get('/generate-users-report', [UpazilaSupervisorDashboardController::class, 'generateUsersReport'])->name('upazilasupervisor.generate-users-report');

    // Package Sales View
    Route::get('/package-sales', [UpazilaSupervisorDashboardController::class, 'packageSales'])->name('upazilasupervisor.package-sales');
});

// PHO Routes
Route::middleware(['auth', 'pho'])->prefix('pho')->group(function () {
    Route::get('/dashboard', [PHODashboardController::class, 'dashboard'])->name('pho.dashboard');

    // Customer Management
    Route::resource('customers', PHOCustomerController::class)->names([
        'index' => 'pho.customers.index',
        'create' => 'pho.customers.create',
        'store' => 'pho.customers.store',
        'edit' => 'pho.customers.edit',
        'update' => 'pho.customers.update',
        'destroy' => 'pho.customers.destroy',
    ]);

    // Package Purchase Management
    Route::get('/packages', [PHOPackagePurchaseController::class, 'index'])->name('pho.packages.index');
    Route::get('/packages/create', [PHOPackagePurchaseController::class, 'create'])->name('pho.packages.create');
    Route::post('/packages', [PHOPackagePurchaseController::class, 'store'])->name('pho.packages.store');
    Route::get('/packages/{purchase}', [PHOPackagePurchaseController::class, 'show'])->name('pho.packages.show');
    Route::get('/packages/{purchase}/add-payment', [PHOPackagePurchaseController::class, 'addPayment'])->name('pho.packages.add-payment');
    Route::post('/packages/{purchase}/payment', [PHOPackagePurchaseController::class, 'storePayment'])->name('pho.packages.store-payment');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'dashboard'])->name('customer.dashboard');

    // Customer Package Views
    Route::get('/packages', [CustomerPackageController::class, 'index'])->name('customer.packages.index');
    Route::get('/packages/{purchase}', [CustomerPackageController::class, 'show'])->name('customer.packages.show');
});
