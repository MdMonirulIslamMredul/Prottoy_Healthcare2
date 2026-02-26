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
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\WebsiteSettingsController;
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
Route::get('/news-events', [FrontendController::class, 'newsEvents'])->name('frontend.news-events');
Route::get('/news-events/{id}', [FrontendController::class, 'newsEventShow'])->name('frontend.news-event.show');
Route::get('/notices', [FrontendController::class, 'notices'])->name('frontend.notices');
Route::get('/notices/{id}', [FrontendController::class, 'noticeShow'])->name('frontend.notice.show');

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
    Route::get('/generate-package-sales-report', [SuperAdminController::class, 'generatePackageSalesReport'])->name('superadmin.generate-package-sales-report');

    // All Users with Filters
    Route::get('/all-users', [SuperAdminController::class, 'allUsers'])->name('superadmin.all-users');
    Route::get('/generate-users-report', [SuperAdminController::class, 'generateUsersReport'])->name('superadmin.generate-users-report');
    Route::get('/filter-districts/{division}', [SuperAdminController::class, 'filterDistricts'])->name('superadmin.filter-districts');
    Route::get('/filter-upzilas/{district}', [SuperAdminController::class, 'filterUpzilas'])->name('superadmin.filter-upzilas');
    Route::get('/filter-phos/{upzila}', [SuperAdminController::class, 'filterPhos'])->name('superadmin.filter-phos');
    Route::get('/filter-unions/{upzila}', [SuperAdminController::class, 'filterUnions'])->name('superadmin.filter-unions');

    // Divisional Chiefs Management
    Route::resource('divisional-chiefs', DivisionalChiefController::class)->names([
        'index' => 'superadmin.divisional-chiefs.index',
        'create' => 'superadmin.divisional-chiefs.create',
        'store' => 'superadmin.divisional-chiefs.store',
        'edit' => 'superadmin.divisional-chiefs.edit',
        'update' => 'superadmin.divisional-chiefs.update',
        'destroy' => 'superadmin.divisional-chiefs.destroy',
    ]);
    // divisional chief details show route
    Route::get('/divisional-chiefs/{divisionalChief}', [DivisionalChiefController::class, 'show'])->name('superadmin.divisional-chiefs.show');

    // District Managers Management
    Route::resource('district-managers', DistrictManagerController::class)->names([
        'index' => 'superadmin.district-managers.index',
        'create' => 'superadmin.district-managers.create',
        'store' => 'superadmin.district-managers.store',
        'edit' => 'superadmin.district-managers.edit',
        'update' => 'superadmin.district-managers.update',
        'destroy' => 'superadmin.district-managers.destroy',
    ]);
    // district manager details show route
    Route::get('/district-managers/{districtManager}', [DistrictManagerController::class, 'show'])->name('superadmin.district-managers.show');

    // Upazila Supervisors Management
    Route::resource('upazila-supervisors', UpazilaSupervisorController::class)->names([
        'index' => 'superadmin.upazila-supervisors.index',
        'create' => 'superadmin.upazila-supervisors.create',
        'store' => 'superadmin.upazila-supervisors.store',
        'edit' => 'superadmin.upazila-supervisors.edit',
        'update' => 'superadmin.upazila-supervisors.update',
        'destroy' => 'superadmin.upazila-supervisors.destroy',
    ]);
    // upazila supervisor details show route
    Route::get('/upazila-supervisors/{upazilaSupervisor}', [UpazilaSupervisorController::class, 'show'])->name('superadmin.upazila-supervisors.show');

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
    // PHO details show route
    Route::get('/phos/{pho}', [PHOController::class, 'show'])->name('superadmin.phos.show');

    // Customer Management
    Route::resource('customers', CustomerController::class)->names([
        'index' => 'superadmin.customers.index',
        'create' => 'superadmin.customers.create',
        'store' => 'superadmin.customers.store',
        'edit' => 'superadmin.customers.edit',
        'update' => 'superadmin.customers.update',
        'destroy' => 'superadmin.customers.destroy',
    ]);
    // customer details show route
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('superadmin.customers.show');

    // AJAX endpoints for hierarchical user selection
    Route::get('/get-district-managers/{divisionalChief}', [PHOController::class, 'getDistrictManagers'])
        ->name('superadmin.get-district-managers');

    Route::get('/get-upazila-supervisors/{districtManager}', [PHOController::class, 'getUpazilaSupervisors'])
        ->name('superadmin.get-upazila-supervisors');

    Route::get('/get-unions/{upazila}', [CustomerController::class, 'getUnions'])
        ->name('superadmin.get-unions');

    Route::get('/get-phos/{upazilaSupervisor}', [CustomerController::class, 'getPHOs'])
        ->name('superadmin.get-phos');

    // Notice Management
    Route::resource('notices', NoticeController::class)->names([
        'index' => 'superadmin.notices.index',
        'create' => 'superadmin.notices.create',
        'store' => 'superadmin.notices.store',
        'show' => 'superadmin.notices.show',
        'edit' => 'superadmin.notices.edit',
        'update' => 'superadmin.notices.update',
        'destroy' => 'superadmin.notices.destroy',
    ]);
    Route::post('/notices/{notice}/toggle-status', [NoticeController::class, 'toggleStatus'])
        ->name('superadmin.notices.toggle-status');

    // Testimonials Management
    Route::resource('testimonials', TestimonialController::class)->names([
        'index' => 'superadmin.testimonials.index',
        'create' => 'superadmin.testimonials.create',
        'store' => 'superadmin.testimonials.store',
        'show' => 'superadmin.testimonials.show',
        'edit' => 'superadmin.testimonials.edit',
        'update' => 'superadmin.testimonials.update',
        'destroy' => 'superadmin.testimonials.destroy',
    ]);
    Route::post('/testimonials/{testimonial}/toggle-status', [TestimonialController::class, 'toggleStatus'])
        ->name('superadmin.testimonials.toggle-status');

    // Website Settings Management
    // Sliders
    Route::get('/website/sliders', [WebsiteSettingsController::class, 'sliders'])->name('superadmin.website.sliders.index');
    Route::get('/website/sliders/create', [WebsiteSettingsController::class, 'createSlider'])->name('superadmin.website.sliders.create');
    Route::post('/website/sliders', [WebsiteSettingsController::class, 'storeSlider'])->name('superadmin.website.sliders.store');
    Route::get('/website/sliders/{slider}/edit', [WebsiteSettingsController::class, 'editSlider'])->name('superadmin.website.sliders.edit');
    Route::put('/website/sliders/{slider}', [WebsiteSettingsController::class, 'updateSlider'])->name('superadmin.website.sliders.update');
    Route::delete('/website/sliders/{slider}', [WebsiteSettingsController::class, 'destroySlider'])->name('superadmin.website.sliders.destroy');

    // Services
    Route::get('/website/services', [WebsiteSettingsController::class, 'services'])->name('superadmin.website.services.index');
    Route::get('/website/services/create', [WebsiteSettingsController::class, 'createService'])->name('superadmin.website.services.create');
    Route::post('/website/services', [WebsiteSettingsController::class, 'storeService'])->name('superadmin.website.services.store');
    Route::get('/website/services/{service}/edit', [WebsiteSettingsController::class, 'editService'])->name('superadmin.website.services.edit');
    Route::put('/website/services/{service}', [WebsiteSettingsController::class, 'updateService'])->name('superadmin.website.services.update');
    Route::delete('/website/services/{service}', [WebsiteSettingsController::class, 'destroyService'])->name('superadmin.website.services.destroy');

    // About Content
    Route::get('/website/about', [WebsiteSettingsController::class, 'aboutContents'])->name('superadmin.website.about.index');
    Route::get('/website/about/create', [WebsiteSettingsController::class, 'createAboutContent'])->name('superadmin.website.about.create');
    Route::post('/website/about', [WebsiteSettingsController::class, 'storeAboutContent'])->name('superadmin.website.about.store');
    Route::get('/website/about/{aboutContent}/edit', [WebsiteSettingsController::class, 'editAboutContent'])->name('superadmin.website.about.edit');
    Route::put('/website/about/{aboutContent}', [WebsiteSettingsController::class, 'updateAboutContent'])->name('superadmin.website.about.update');
    Route::delete('/website/about/{aboutContent}', [WebsiteSettingsController::class, 'destroyAboutContent'])->name('superadmin.website.about.destroy');

    // Leadership
    Route::get('/website/leadership', [WebsiteSettingsController::class, 'leaderships'])->name('superadmin.website.leadership.index');
    Route::get('/website/leadership/create', [WebsiteSettingsController::class, 'createLeadership'])->name('superadmin.website.leadership.create');
    Route::post('/website/leadership', [WebsiteSettingsController::class, 'storeLeadership'])->name('superadmin.website.leadership.store');
    Route::get('/website/leadership/{leadership}/edit', [WebsiteSettingsController::class, 'editLeadership'])->name('superadmin.website.leadership.edit');
    Route::put('/website/leadership/{leadership}', [WebsiteSettingsController::class, 'updateLeadership'])->name('superadmin.website.leadership.update');
    Route::delete('/website/leadership/{leadership}', [WebsiteSettingsController::class, 'destroyLeadership'])->name('superadmin.website.leadership.destroy');

    // Policies
    Route::get('/website/policies', [WebsiteSettingsController::class, 'policies'])->name('superadmin.website.policies.index');
    Route::get('/website/policies/create', [WebsiteSettingsController::class, 'createPolicy'])->name('superadmin.website.policies.create');
    Route::post('/website/policies', [WebsiteSettingsController::class, 'storePolicy'])->name('superadmin.website.policies.store');
    Route::get('/website/policies/{policy}/edit', [WebsiteSettingsController::class, 'editPolicy'])->name('superadmin.website.policies.edit');
    Route::put('/website/policies/{policy}', [WebsiteSettingsController::class, 'updatePolicy'])->name('superadmin.website.policies.update');
    Route::delete('/website/policies/{policy}', [WebsiteSettingsController::class, 'destroyPolicy'])->name('superadmin.website.policies.destroy');

    // Gallery
    Route::get('/website/gallery', [WebsiteSettingsController::class, 'gallery'])->name('superadmin.website.gallery.index');
    Route::get('/website/gallery/create', [WebsiteSettingsController::class, 'createGallery'])->name('superadmin.website.gallery.create');
    Route::post('/website/gallery', [WebsiteSettingsController::class, 'storeGallery'])->name('superadmin.website.gallery.store');
    Route::get('/website/gallery/{gallery}/edit', [WebsiteSettingsController::class, 'editGallery'])->name('superadmin.website.gallery.edit');
    Route::put('/website/gallery/{gallery}', [WebsiteSettingsController::class, 'updateGallery'])->name('superadmin.website.gallery.update');
    Route::delete('/website/gallery/{gallery}', [WebsiteSettingsController::class, 'destroyGallery'])->name('superadmin.website.gallery.destroy');

    // Organizational Roles
    Route::get('/website/organizational-roles', [WebsiteSettingsController::class, 'organizationalRoles'])->name('superadmin.website.organizational-roles.index');
    Route::get('/website/organizational-roles/create', [WebsiteSettingsController::class, 'createOrganizationalRole'])->name('superadmin.website.organizational-roles.create');
    Route::post('/website/organizational-roles', [WebsiteSettingsController::class, 'storeOrganizationalRole'])->name('superadmin.website.organizational-roles.store');
    Route::get('/website/organizational-roles/{organizationalRole}/edit', [WebsiteSettingsController::class, 'editOrganizationalRole'])->name('superadmin.website.organizational-roles.edit');
    Route::put('/website/organizational-roles/{organizationalRole}', [WebsiteSettingsController::class, 'updateOrganizationalRole'])->name('superadmin.website.organizational-roles.update');
    Route::delete('/website/organizational-roles/{organizationalRole}', [WebsiteSettingsController::class, 'destroyOrganizationalRole'])->name('superadmin.website.organizational-roles.destroy');

    // News & Events
    Route::get('/website/news-events', [WebsiteSettingsController::class, 'newsEvents'])->name('superadmin.website.news-events.index');
    Route::get('/website/news-events/create', [WebsiteSettingsController::class, 'createNewsEvent'])->name('superadmin.website.news-events.create');
    Route::post('/website/news-events', [WebsiteSettingsController::class, 'storeNewsEvent'])->name('superadmin.website.news-events.store');
    Route::get('/website/news-events/{newsEvent}/edit', [WebsiteSettingsController::class, 'editNewsEvent'])->name('superadmin.website.news-events.edit');
    Route::put('/website/news-events/{newsEvent}', [WebsiteSettingsController::class, 'updateNewsEvent'])->name('superadmin.website.news-events.update');
    Route::delete('/website/news-events/{newsEvent}', [WebsiteSettingsController::class, 'destroyNewsEvent'])->name('superadmin.website.news-events.destroy');

    // Notices
    Route::get('/website/notices', [WebsiteSettingsController::class, 'notices'])->name('superadmin.website.notices.index');
    Route::get('/website/notices/create', [WebsiteSettingsController::class, 'createNotice'])->name('superadmin.website.notices.create');
    Route::post('/website/notices', [WebsiteSettingsController::class, 'storeNotice'])->name('superadmin.website.notices.store');
    Route::get('/website/notices/{notice}/edit', [WebsiteSettingsController::class, 'editNotice'])->name('superadmin.website.notices.edit');
    Route::put('/website/notices/{notice}', [WebsiteSettingsController::class, 'updateNotice'])->name('superadmin.website.notices.update');
    Route::delete('/website/notices/{notice}', [WebsiteSettingsController::class, 'destroyNotice'])->name('superadmin.website.notices.destroy');

    // Contact Information
    Route::get('/website/contact-info', [WebsiteSettingsController::class, 'contactInfo'])->name('superadmin.website.contact-info');
    Route::put('/website/contact-info', [WebsiteSettingsController::class, 'updateContactInfo'])->name('superadmin.website.contact-info.update');

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
    Route::get('/get-upzilas/{district}', function ($districtId) {
        $upzilas = \App\Models\Upzila::where('district_id', $districtId)->get(['id', 'name']);
        return response()->json($upzilas);
    })->name('divisionalchief.get-upzilas');

    // Hierarchy View
    Route::get('/hierarchy', [DivisionalChiefDashboardController::class, 'hierarchy'])->name('divisionalchief.hierarchy');

    // Package Sales
    Route::get('/package-sales', [DivisionalChiefDashboardController::class, 'packageSales'])->name('divisionalchief.package-sales');
    Route::get('/generate-package-sales-report', [DivisionalChiefDashboardController::class, 'generatePackageSalesReport'])->name('divisionalchief.generate-package-sales-report');

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
    Route::get('/generate-package-sales-report', [DistrictManagerDashboardController::class, 'generatePackageSalesReport'])->name('districtmanager.generate-package-sales-report');

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
    Route::get('/generate-package-sales-report', [UpazilaSupervisorDashboardController::class, 'generatePackageSalesReport'])->name('upazilasupervisor.generate-package-sales-report');
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

    // Word Management (PHO) - PHO can only create words under unions in their upzila
    Route::resource('words', \App\Http\Controllers\PHO\WordController::class)->names([
        'index' => 'pho.words.index',
        'create' => 'pho.words.create',
        'store' => 'pho.words.store',
        'edit' => 'pho.words.edit',
        'update' => 'pho.words.update',
        'destroy' => 'pho.words.destroy',
    ])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // AJAX: get words by union
    Route::get('/get-words/{union}', [\App\Http\Controllers\PHO\WordController::class, 'getWords'])
        ->name('pho.get-words');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'dashboard'])->name('customer.dashboard');

    // Customer Package Views
    Route::get('/packages', [CustomerPackageController::class, 'index'])->name('customer.packages.index');
    Route::get('/packages/{purchase}', [CustomerPackageController::class, 'show'])->name('customer.packages.show');
});
