# Role-Based Sidebar and User Management Implementation

## ✅ Completed

### 1. Separate Sidebars Created
- `sidebar-superadmin.blade.php` - Full access to all management
- `sidebar-divisional-chief.blade.php` - Manage: District Managers, Upazila Supervisors, PHOs, Customers
- `sidebar-district-manager.blade.php` - Manage: Upazila Supervisors, PHOs, Customers
- `sidebar-upazila-supervisor.blade.php` - Manage: PHOs, Customers
- `sidebar-pho.blade.php` - Manage: Customers
- `sidebar-customer.blade.php` - View only (Profile, Records)

### 2. Layout Updated
- `app.blade.php` now dynamically includes sidebar based on user role

### 3. Example Implementation Complete: Divisional Chief → District Managers
**Controller:** `DivisionalChief/DistrictManagerManagementController.php`
- ✅ index() - List district managers in their division
- ✅ create() - Show create form with available districts
- ✅ store() - Create new district manager (validates one per district)
- ✅ edit() - Edit existing district manager
- ✅ update() - Update district manager info
- ✅ destroy() - Delete district manager

**Routes:** Added to `web.php` under divisionalchief middleware
**Views:** 
- ✅ index.blade.php
- ✅ create.blade.php
- ⏳ edit.blade.php (follow same pattern as create)

## 🔄 Implementation Pattern for Remaining Functionality

### Pattern to Follow (Copy & Adapt):

#### For each role managing subordinates:

**1. Controller Structure:**
```php
// Example: DistrictManager/UpazilaSupervisorManagementController.php
public function index() {
    $manager = auth()->user();
    $subordinates = User::where('role', 'upazila_supervisor')
        ->where('district_id', $manager->district_id)
        ->with(['upzila'])
        ->paginate(10);
    return view('...', compact('subordinates'));
}

public function create() {
    $manager = auth()->user();
    // Get available upzilas in this district
    $upzilas = Upzila::where('district_id', $manager->district_id)->get();
    // Get already assigned upzila IDs
    $assignedUpzilas = User::where('role', 'upazila_supervisor')
        ->where('district_id', $manager->district_id)
        ->pluck('upzila_id')->toArray();
    return view('...', compact('upzilas', 'assignedUpzilas'));
}

public function store(Request $request) {
    $manager = auth()->user();
    // Validate
    // Create user with:
    // - role: subordinate role
    // - division_id: from manager
    // - district_id: from manager (or upzila_id, etc.)
    // - created_by: auth()->id()
}
```

**2. Route Structure:**
```php
Route::middleware(['auth', 'ROLE'])->prefix('PREFIX')->group(function () {
    Route::resource('RESOURCE', Controller::class)->names([
        'index' => 'PREFIX.RESOURCE.index',
        // ... other CRUD routes
    ]);
});
```

**3. View Structure:**
- index.blade.php: Table with list + Add button
- create.blade.php: Form with available options (disabled for assigned)
- edit.blade.php: Pre-filled form

## 📋 TODO: Remaining Implementations

### Divisional Chief Can Manage:
1. ✅ District Managers (DONE)
2. ⏳ Upazila Supervisors 
   - Controller: `DivisionalChief/UpazilaSupervisorManagementController`
   - Route: divisionalchief.upazila-supervisors.*
   - Views: backend/divisional-chief/upazila-supervisors/
   
3. ⏳ PHOs
   - Controller: `DivisionalChief/PHOManagementController`
   - Route: divisionalchief.phos.*
   - Views: backend/divisional-chief/phos/
   
4. ⏳ Customers
   - Controller: `DivisionalChief/CustomerManagementController`
   - Route: divisionalchief.customers.*
   - Views: backend/divisional-chief/customers/

### District Manager Can Manage:
1. ⏳ Upazila Supervisors
   - Controller: `DistrictManager/UpazilaSupervisorManagementController`
   - Route: districtmanager.upazila-supervisors.*
   
2. ⏳ PHOs
   - Controller: `DistrictManager/PHOManagementController`
   - Route: districtmanager.phos.*
   
3. ⏳ Customers
   - Controller: `DistrictManager/CustomerManagementController`
   - Route: districtmanager.customers.*

### Upazila Supervisor Can Manage:
1. ⏳ PHOs
   - Controller: `UpazilaSupervisor/PHOManagementController`
   - Route: upazilasupervisor.phos.*
   
2. ⏳ Customers
   - Controller: `UpazilaSupervisor/CustomerManagementController`
   - Route: upazilasupervisor.customers.*

### PHO Can Manage:
1. ⏳ Customers
   - Controller: `PHO/CustomerManagementController`
   - Route: pho.customers.*

## 🔑 Key Points:

1. **Scope Restriction**: Each role can only see/manage users within their geographical scope
   - Divisional Chief: division_id filter
   - District Manager: district_id filter
   - Upazila Supervisor: upzila_id filter
   - PHO: upazila_supervisor_id filter

2. **Validation**: Always check one-per-location rule (except for PHOs and Customers which can be multiple)

3. **Auto-fill Location Data**: When creating subordinates, automatically inherit parent's location data

4. **created_by Tracking**: Always set `created_by` to `auth()->id()`

## 🚀 Quick Start for Next Implementation:

1. Copy `DivisionalChief/DistrictManagerManagementController.php`
2. Rename and adjust for new role-subordinate relationship
3. Update filters (division_id → district_id → upzila_id)
4. Copy view files from divisional-chief/district-managers/
5. Adjust field names and labels
6. Add routes to web.php
7. Test CRUD operations

## 📌 Files Already Created:
Controllers (all empty, ready to implement):
- DivisionalChief/UpazilaSupervisorManagementController.php
- DivisionalChief/PHOManagementController.php
- DivisionalChief/CustomerManagementController.php
- DistrictManager/UpazilaSupervisorManagementController.php
- DistrictManager/PHOManagementController.php
- DistrictManager/CustomerManagementController.php
- UpazilaSupervisor/PHOManagementController.php
- UpazilaSupervisor/CustomerManagementController.php
- PHO/CustomerManagementController.php
