# Prottoy Healthcare System - Project Summary

## Project Overview
A comprehensive hierarchical healthcare management system built with Laravel 12.49.0 and PHP 8.3.26, designed to manage users across multiple organizational levels with geographical scope-based access control.

---

## Core Architecture

### User Hierarchy Structure
```
Super Admin (System Level)
    ↓
Divisional Chief (Division Level)
    ↓
District Manager (District Level)
    ↓
Upazila Supervisor (Upazila Level)
    ↓
PHO (Primary Health Officer)
    ↓
Customer (End User)
```

### Geographical Hierarchy
```
Division
    ↓
District
    ↓
Upazila (Sub-district)
```

---

## Database Tables

### Core Tables

#### 1. `users` Table
Main user table with role-based authentication and geographical relationships.

**Key Fields:**
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `phone` - Unique phone number (nullable in DB, required for customers)
- `password` - Hashed password
- `role` - Enum: super_admin, divisional_chief, district_manager, upazila_supervisor, pho, customer
- `division_id` - Foreign key to divisions table
- `district_id` - Foreign key to districts table
- `upzila_id` - Foreign key to upzilas table
- `upazila_supervisor_id` - Foreign key to users (for PHOs and Customers)
- `pho_id` - Foreign key to users (for Customers)
- `created_by` - Tracks which user created this record
- `created_at`, `updated_at` - Timestamps

**Constraints:**
- Email must be unique
- Phone must be unique
- One Divisional Chief per Division
- One District Manager per District
- One Upazila Supervisor per Upazila
- Multiple PHOs per Upazila allowed
- Multiple Customers per PHO allowed

#### 2. `divisions` Table
Top-level geographical division.

**Key Fields:**
- `id` - Primary key
- `name` - Division name
- `bn_name` - Bengali name
- `url` - Reference URL

#### 3. `districts` Table
Second-level geographical division.

**Key Fields:**
- `id` - Primary key
- `division_id` - Foreign key to divisions
- `name` - District name
- `bn_name` - Bengali name
- `lat`, `lon` - Geographical coordinates
- `url` - Reference URL

#### 4. `upzilas` Table
Third-level geographical division.

**Key Fields:**
- `id` - Primary key
- `district_id` - Foreign key to districts
- `name` - Upazila name
- `bn_name` - Bengali name
- `url` - Reference URL

---

## Models and Relationships

### User Model (`app/Models/User.php`)

**Key Relationships:**
```php
// Geographical relationships
division() - belongsTo(Division)
district() - belongsTo(District)
upzila() - belongsTo(Upzila)

// Hierarchical relationships
upazilaSupervisor() - belongsTo(User) - For PHOs
pho() - belongsTo(User) - For Customers
creator() - belongsTo(User) - Who created this user

// Downward relationships
phos() - hasMany(User) - PHOs under Upazila Supervisor (filtered by role='pho')
customers() - hasMany(User) - Customers under PHO (filtered by role='customer')
```

**Critical Fix Applied:**
- `phos()` relationship was initially counting all users with `upazila_supervisor_id`
- Fixed to filter by `role='pho'` to prevent customers from being counted as PHOs

### Division Model

**Relationships:**
```php
districts() - hasMany(District)
upzilas() - hasManyThrough(Upzila, District)
divisionalChief() - hasOne(User)->where('role', 'divisional_chief')
```

### District Model

**Relationships:**
```php
division() - belongsTo(Division)
upzilas() - hasMany(Upzila)
districtManager() - hasOne(User)->where('role', 'district_manager')
```

### Upzila Model

**Relationships:**
```php
district() - belongsTo(District)
division() - hasOneThrough(Division, District)
upazilaSupervisor() - hasOne(User)->where('role', 'upazila_supervisor')
phos() - hasMany(User)->where('role', 'pho')
```

---

## User Roles and Permissions

### 1. Super Admin
**Access Level:** System-wide

**Capabilities:**
- Manage all users across all divisions
- Create/Edit/Delete Divisional Chiefs
- Create/Edit/Delete District Managers
- Create/Edit/Delete Upazila Supervisors
- Create/Edit/Delete PHOs
- Create/Edit/Delete Customers
- View complete system hierarchy
- Filter and view all users with advanced filters
- Generate PDF reports for filtered users

**Routes Prefix:** `/superadmin`

### 2. Divisional Chief
**Access Level:** Division-wide

**Capabilities:**
- Manage District Managers in their division
- Manage Upazila Supervisors in their division
- Manage PHOs in their division
- Manage Customers in their division
- View division-level hierarchy
- Filter and view users within division (District → Upazila → PHO filters)
- Generate PDF reports for filtered users

**Routes Prefix:** `/divisional-chief`

### 3. District Manager
**Access Level:** District-wide

**Capabilities:**
- Manage Upazila Supervisors in their district
- Manage PHOs in their district
- Manage Customers in their district
- View district-level hierarchy
- Filter and view users within district (Upazila → PHO filters)
- Generate PDF reports for filtered users

**Routes Prefix:** `/district-manager`

### 4. Upazila Supervisor
**Access Level:** Upazila-wide

**Capabilities:**
- Manage PHOs in their upazila
- Manage Customers through their PHOs
- View upazila-level hierarchy
- Filter and view users within upazila (PHO filter)
- Generate PDF reports for filtered users

**Routes Prefix:** `/upazila-supervisor`

### 5. PHO (Primary Health Officer)
**Access Level:** Personal scope

**Capabilities:**
- Manage their own Customers only
- Create/Edit/Delete Customers under their supervision
- View dashboard with customer statistics

**Routes Prefix:** `/pho`

### 6. Customer
**Access Level:** Personal scope

**Capabilities:**
- View their own dashboard
- Limited access to system

**Routes Prefix:** `/customer`

---

## Feature Implementations

### 1. Authentication System
- Laravel's built-in authentication
- Role-based middleware for route protection
- Custom redirect logic based on user roles
- Middleware: `superadmin`, `divisionalchief`, `districtmanager`, `upazilasupervisor`, `pho`, `customer`

### 2. Dashboard Features

#### Common Dashboard Elements:
- Welcome message with user name
- Statistics cards showing counts of subordinate users
- Location information display (Division, District, Upazila as applicable)
- Quick info panel
- Clickable statistics cards with hover effects (navigate to list pages)

#### Role-Specific Statistics:

**Super Admin Dashboard:**
- Divisional Chiefs count
- District Managers count
- Upazila Supervisors count
- PHOs count
- Customers count
- Total Users count

**Divisional Chief Dashboard:**
- District Managers count (in division)
- Upazila Supervisors count (in division)
- PHOs count (in division)
- Customers count (in division)

**District Manager Dashboard:**
- Upazila Supervisors count (in district)
- PHOs count (in district)
- Customers count (in district)

**Upazila Supervisor Dashboard:**
- PHOs count (in upazila)
- Customers count (in upazila)

**PHO Dashboard:**
- Customers count (under PHO)

### 3. User Management (CRUD Operations)

#### Scope-Based Access Control:
Each role can only manage users within their geographical scope.

**Example:** District Manager in "Dhaka District" can only:
- See and manage Upazila Supervisors in Dhaka District
- See and manage PHOs in Dhaka District
- See and manage Customers in Dhaka District

#### Data Inheritance:
When creating subordinate users, location data is automatically inherited:
- District Manager creates Upazila Supervisor → Division and District inherited
- Upazila Supervisor creates PHO → Division, District, and Upazila inherited
- PHO creates Customer → All location data inherited from PHO

#### Validation Rules:

**Divisional Chiefs:**
- One per Division constraint
- Division must not already have a chief

**District Managers:**
- One per District constraint
- District must not already have a manager

**Upazila Supervisors:**
- One per Upazila constraint
- Upazila must not already have a supervisor

**PHOs:**
- Multiple allowed per Upazila
- Must be assigned to an Upazila Supervisor
- Phone field nullable

**Customers:**
- Multiple allowed per PHO
- Must be assigned to a PHO
- Phone field REQUIRED with validation
- Unique constraint on phone number

### 4. Hierarchical Relationship Views

#### Super Admin Hierarchy View:
- Division selector dropdown
- Shows: Division → Districts → Upazilas → PHOs → Customers
- Expandable accordion sections
- Districts with managers shown first
- Shows unassigned locations with warning indicators

#### Divisional Chief Hierarchy View:
- Shows: District → Upazilas → PHOs → Customers (for their division)
- Expandable accordion sections
- Districts with managers shown first

#### District Manager Hierarchy View:
- Shows: Upazilas → PHOs → Customers (for their district)
- Expandable accordion sections
- Upazilas with supervisors shown first

#### Upazila Supervisor Hierarchy View:
- Shows: PHOs → Customers (for their upazila)
- Expandable accordion sections for customers under each PHO

### 5. Advanced User Filtering System

#### Filter Options by Role:

**Super Admin Filters:**
- Division → District → Upazila → PHO → Role
- Cascading AJAX dropdowns
- Apply/Clear filter buttons

**Divisional Chief Filters:**
- District → Upazila → PHO → Role
- Cascading AJAX dropdowns
- Scoped to their division

**District Manager Filters:**
- Upazila → PHO → Role
- Cascading AJAX dropdowns
- Scoped to their district

**Upazila Supervisor Filters:**
- PHO → Role
- Scoped to their upazila

#### Filter Features:
- Real-time cascading dropdowns using AJAX
- Maintains selected values after filtering
- Shows total filtered user count
- Pagination support (20 users per page)
- Role-based color-coded badges

### 6. PDF Report Generation

#### Report Features:
- Browser-based print-to-PDF functionality
- No external package dependencies
- Floating print button
- Print-optimized CSS with `@media print` rules

#### Report Contents:
- Professional header with system branding
- Report generation timestamp
- Applied filters section (highlights what criteria was used)
- Total users count summary
- Complete user table with:
  - ID, Name, Email, Phone
  - Role (color-coded badges)
  - Division, District, Upazila
- Footer with copyright information
- Landscape orientation for better table display

#### Role-Specific Reports:
- Each role's report shows only relevant filters
- Data scoped to user's access level
- Filename: `users-report-YYYY-MM-DD-HHMMSS.pdf`

### 7. Phone Number Management

**Implementation:**
- Migration: `2026_02_05_064331_add_phone_to_users_table.php`
- Field: `string('phone', 20)->nullable()->unique()`
- Database level: Nullable with unique constraint
- Application level: Required for customers, nullable for staff roles
- Validation: Unique across all users

**Validation Rules:**
```php
// For Customers (required)
'phone' => ['required', 'string', 'max:20', 'unique:users,phone']

// For other roles (nullable)
'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone']
```

### 8. Created By Tracking

**Implementation:**
- Field: `created_by` in users table
- Automatically populated when user is created
- Tracks which user created each record
- Helps in audit trail

**Example:**
```php
'created_by' => auth()->id()
```

### 9. Cascading Dropdowns (AJAX)

**Implementation:**
Multiple AJAX endpoints for dynamic form loading:

**Super Admin:**
- `/superadmin/filter-districts/{division}` - Load districts by division
- `/superadmin/filter-upzilas/{district}` - Load upazilas by district
- `/superadmin/filter-phos/{upzila}` - Load PHOs by upazila

**Divisional Chief:**
- `/divisional-chief/get-upzilas/{district}` - Load upazilas by district
- `/divisional-chief/filter-upzilas-ajax/{district}` - AJAX for filters
- `/divisional-chief/filter-phos/{upzila}` - Load PHOs by upazila

**District Manager:**
- `/district-manager/filter-phos/{upzila}` - Load PHOs by upazila

**JavaScript Implementation:**
- Event listeners on parent dropdowns
- Fetch API for AJAX calls
- Dynamic option population
- Automatic clearing of dependent dropdowns

### 10. UI/UX Enhancements

#### Clickable Dashboard Cards:
- Statistics cards wrapped in anchor tags
- Hover effects with CSS transitions
- Transform animation (translateY on hover)
- Enhanced box-shadow on hover
- Links to respective list pages

#### Hierarchy View Cards:
- Purple-themed cards (color: #6f42c1)
- Diagram icon (bi-diagram-3)
- Full-width layout
- Descriptive text about organizational structure
- Arrow icon indicating navigation

#### CSS Hover Effects:
```css
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
```

---

## Controllers

### Dashboard Controllers
- `SuperAdminController` - System-wide dashboard and user management
- `DivisionalChiefDashboardController` - Division-level dashboard
- `DistrictManagerDashboardController` - District-level dashboard
- `UpazilaSupervisorDashboardController` - Upazila-level dashboard
- `PHODashboardController` - PHO personal dashboard
- `CustomerDashboardController` - Customer personal dashboard

### Management Controllers

#### Super Admin Management:
- `DivisionalChiefController` - Manage divisional chiefs
- `DistrictManagerController` - Manage district managers
- `UpazilaSupervisorController` - Manage upazila supervisors
- `PHOController` - Manage PHOs
- `CustomerController` - Manage customers

#### Divisional Chief Management:
- `DivisionalChief\DistrictManagerManagementController`
- `DivisionalChief\UpazilaSupervisorManagementController`
- `DivisionalChief\PHOManagementController`
- `DivisionalChief\CustomerManagementController`

#### District Manager Management:
- `DistrictManager\UpazilaSupervisorManagementController`
- `DistrictManager\PHOManagementController`
- `DistrictManager\CustomerManagementController`

#### Upazila Supervisor Management:
- `UpazilaSupervisor\PHOManagementController`
- `UpazilaSupervisor\CustomerManagementController`

#### PHO Management:
- `PHO\CustomerManagementController`

---

## Routes Structure

### Route Grouping by Middleware:
```php
// Super Admin routes
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')

// Divisional Chief routes
Route::middleware(['auth', 'divisionalchief'])->prefix('divisional-chief')

// District Manager routes
Route::middleware(['auth', 'districtmanager'])->prefix('district-manager')

// Upazila Supervisor routes
Route::middleware(['auth', 'upazilasupervisor'])->prefix('upazila-supervisor')

// PHO routes
Route::middleware(['auth', 'pho'])->prefix('pho')

// Customer routes
Route::middleware(['auth', 'customer'])->prefix('customer')
```

### Route Types:
1. **Resource Routes** - Full CRUD operations (index, create, store, edit, update, destroy)
2. **Dashboard Routes** - Display role-specific dashboards
3. **Hierarchy Routes** - Display organizational structure
4. **Filter Routes** - AJAX endpoints for cascading dropdowns
5. **Report Routes** - Generate PDF reports
6. **All Users Routes** - Advanced filtering and user lists

---

## Views Structure

### Layout Files:
- `backend/layouts/app.blade.php` - Main application layout
- `backend/partials/navbar.blade.php` - Top navigation bar
- `backend/partials/sidebar-superadmin.blade.php` - Super admin sidebar
- `backend/partials/sidebar-divisional-chief.blade.php` - Divisional chief sidebar
- `backend/partials/sidebar-district-manager.blade.php` - District manager sidebar
- `backend/partials/sidebar-upazila-supervisor.blade.php` - Upazila supervisor sidebar
- `backend/partials/sidebar-pho.blade.php` - PHO sidebar

### Dashboard Views:
- `backend/superadmin/dashboard.blade.php`
- `backend/divisional-chief/dashboard.blade.php`
- `backend/district-manager/dashboard.blade.php`
- `backend/upazila-supervisor/dashboard.blade.php`
- `backend/pho/dashboard.blade.php`
- `backend/customer/dashboard.blade.php`

### Hierarchy Views:
- `backend/superadmin/hierarchy.blade.php` - With division selector
- `backend/divisional-chief/hierarchy.blade.php`
- `backend/district-manager/hierarchy.blade.php`
- `backend/upazila-supervisor/hierarchy.blade.php`

### All Users Views:
- `backend/superadmin/all-users.blade.php` - All filters
- `backend/divisional-chief/all-users.blade.php` - District/Upazila/PHO filters
- `backend/district-manager/all-users.blade.php` - Upazila/PHO filters
- `backend/upazila-supervisor/all-users.blade.php` - PHO filter only

### PDF Report Views:
- `backend/superadmin/reports/users-pdf.blade.php`
- `backend/divisional-chief/reports/users-pdf.blade.php`
- `backend/district-manager/reports/users-pdf.blade.php`
- `backend/upazila-supervisor/reports/users-pdf.blade.php`

### Management Views (CRUD):
Each role has index, create, and edit views for their manageable user types.

**Example Structure:**
```
backend/
  superadmin/
    divisional-chiefs/
      index.blade.php
      create.blade.php
      edit.blade.php
    district-managers/
      index.blade.php
      create.blade.php
      edit.blade.php
  divisional-chief/
    district-managers/
      index.blade.php
      create.blade.php
      edit.blade.php
```

---

## Key Technical Implementations

### 1. Authorization Pattern
```php
// Example: PHO checking if customer belongs to them
if ($customer->pho_id !== auth()->id()) {
    abort(403, 'Unauthorized');
}

// Example: District Manager checking if supervisor is in their district
if ($supervisor->district_id !== $districtManager->district_id) {
    abort(403, 'Unauthorized');
}
```

### 2. Scope Filtering Pattern
```php
// Example: District Manager viewing users in their district
$users = User::where('district_id', auth()->user()->district_id)
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

### 3. Data Inheritance Pattern
```php
// Example: Upazila Supervisor creating PHO
'division_id' => $upazilaSupervisor->division_id,
'district_id' => $upazilaSupervisor->district_id,
'upzila_id' => $upazilaSupervisor->upzila_id,
'upazila_supervisor_id' => $upazilaSupervisor->id,
```

### 4. One-Per-Location Validation
```php
// Example: Checking if district already has a manager
$existingManager = User::where('role', 'district_manager')
    ->where('district_id', $request->district_id)
    ->exists();

if ($existingManager) {
    return back()->withErrors([
        'district_id' => 'This district already has a manager.'
    ]);
}
```

### 5. Sorting by Assignment Status
```php
// Show districts with managers first
$sortedDistricts = $division->districts->sortByDesc(function($district) {
    return $district->districtManager ? 1 : 0;
});
```

---

## Frontend Technologies

### CSS Framework:
- Bootstrap 5.3.0
- Custom CSS for hover effects and animations
- Gradient sidebar backgrounds
- Responsive design for mobile devices

### Icons:
- Bootstrap Icons library
- Contextual icons for different user roles
- Status indicators

### JavaScript:
- Vanilla JavaScript for AJAX calls
- Fetch API for HTTP requests
- Event listeners for cascading dropdowns
- Form auto-submission on select change

---

## Security Features

1. **Role-Based Access Control (RBAC)**
   - Middleware protection on all routes
   - Authorization checks in controllers
   - Scope-based data filtering

2. **Data Validation**
   - Server-side validation for all inputs
   - Unique constraints on email and phone
   - Role-specific validation rules

3. **CSRF Protection**
   - Laravel's built-in CSRF tokens
   - @csrf directive in all forms

4. **Password Security**
   - Bcrypt hashing
   - Minimum length requirements
   - Optional on edit (only when changing)

5. **SQL Injection Prevention**
   - Eloquent ORM query builder
   - Parameter binding in all queries

---

## Known Issues Fixed

### 1. PHO Count Issue
**Problem:** `phos()` relationship was counting both PHOs and Customers
**Solution:** Added `where('role', 'pho')` filter to relationship
**File:** `app/Models/User.php`

### 2. Customer Count Issue
**Problem:** Upazila Supervisor dashboard using `upzila_id` instead of `upazila_supervisor_id`
**Solution:** Changed filter to use correct foreign key
**File:** `app/Http/Controllers/UpazilaSupervisorDashboardController.php`

### 3. Cascading Dropdown Issue
**Problem:** Divisional Chief forms using `/superadmin/get-upzilas/` endpoint
**Solution:** Created role-specific AJAX endpoints
**Files:** Routes and view files for divisional-chief

### 4. Created By Tracking
**Problem:** `created_by` field was null for customers created by PHOs
**Solution:** Added `'created_by' => auth()->id()` to all create operations
**Files:** All management controllers

---

## Development Environment

- **Server:** Laragon (Windows)
- **PHP:** 8.3.26
- **Laravel:** 12.49.0
- **Database:** MySQL
- **Web Server:** Apache/Nginx via Laragon

---

## Future Enhancement Opportunities

1. **Export Features:**
   - Excel export option
   - CSV export option

2. **Search Functionality:**
   - Global search across all users
   - Search by name, email, phone

3. **Activity Logs:**
   - User creation logs
   - Edit history tracking
   - Login activity monitoring

4. **Notifications:**
   - Email notifications for user creation
   - System alerts for managers

5. **Bulk Operations:**
   - Bulk user import via CSV
   - Bulk status updates

6. **Advanced Reporting:**
   - Custom date range filters
   - Statistical analysis
   - Charts and graphs

7. **Profile Management:**
   - User profile editing
   - Password change functionality
   - Profile photo upload

---

## File Structure Summary

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── SuperAdminController.php
│   │   ├── DivisionalChiefDashboardController.php
│   │   ├── DistrictManagerDashboardController.php
│   │   ├── UpazilaSupervisorDashboardController.php
│   │   ├── PHODashboardController.php
│   │   ├── CustomerDashboardController.php
│   │   ├── DivisionalChief/ (4 management controllers)
│   │   ├── DistrictManager/ (3 management controllers)
│   │   ├── UpazilaSupervisor/ (2 management controllers)
│   │   └── PHO/ (1 management controller)
│   └── Middleware/
│       └── (Role-based middleware)
├── Models/
│   ├── User.php
│   ├── Division.php
│   ├── District.php
│   └── Upzila.php
database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   └── 2026_02_05_064331_add_phone_to_users_table.php
resources/
├── views/
│   └── backend/
│       ├── layouts/
│       ├── partials/ (sidebars for each role)
│       ├── superadmin/ (dashboard, hierarchy, all-users, reports)
│       ├── divisional-chief/ (dashboard, hierarchy, all-users, reports, CRUD views)
│       ├── district-manager/ (dashboard, hierarchy, all-users, reports, CRUD views)
│       ├── upazila-supervisor/ (dashboard, hierarchy, all-users, reports, CRUD views)
│       ├── pho/ (dashboard, CRUD views)
│       └── customer/ (dashboard)
routes/
└── web.php (All route definitions with middleware groups)
```

---

## Total Implementation Count

- **Controllers:** 20+ controllers
- **Routes:** 100+ routes (resource routes, dashboards, AJAX endpoints)
- **Views:** 60+ Blade templates
- **Models:** 4 main models (User, Division, District, Upzila)
- **Middleware:** 6 role-based middleware
- **Migrations:** 2 migrations (base users table + phone field)
- **Relationships:** 15+ Eloquent relationships
- **AJAX Endpoints:** 10+ cascading dropdown endpoints
- **PDF Reports:** 4 report templates (one per role with all-users feature)

---

## Project Status: ✅ COMPLETE

All core features have been successfully implemented and tested. The system provides comprehensive user management with proper hierarchy, scope-based access control, advanced filtering, and reporting capabilities for all user roles.
