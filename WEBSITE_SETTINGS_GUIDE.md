# Website Settings Management - Implementation Guide

## Overview
Complete CRUD system for managing frontend website content including:
- Hero Sliders
- Services
- About Content (Mission/Vision)
- Leadership Team
- Policies & Legal
- Gallery

## ✅ What's Completed

### 1. Database & Models
✅ All migrations created and run
✅ Models with fillable fields and scopes
✅ Proper relationships and casts

### 2. Controller
✅ WebsiteSettingsController with all CRUD methods
✅ Image upload handling
✅ Validation rules
✅ Storage management

### 3. Routes  
✅ All routes registered under superadmin middleware
✅ Proper naming conventions

### 4. Sidebar Navigation
✅ Dropdown menu with all sections
✅ Active state highlighting
✅ Proper icons

### 5. Views Created
✅ **Sliders**
  - index.blade.php - Table view with image preview
  - create.blade.php - Full form with image upload

✅ **Services**
  - index.blade.php - Card grid view

✅ **About Content**
  - index.blade.php - Table with type badges

✅ **Leadership**
  - index.blade.php - Table with photos and contacts

✅ **Policies**
  - index.blade.php - List group style

✅ **Gallery**
  - index.blade.php - Image grid with overlay badges

## 📋 Remaining Views to Create

Follow the same pattern as provided examples for:

### Services
- create.blade.php (similar to sliders/create but with icon field, textarea for description)
- edit.blade.php (pre-fill form with existing data)

### About Content
Path: resources/views/backend/superadmin/website/about/
- index.blade.php (table with type, title, content)
- create.blade.php (dropdown for type: mission/vision/about)
- edit.blade.php

### Leadership
Path: resources/views/backend/superadmin/website/leadership/
- index.blade.php (cards with photos, name, designation)
- create.blade.php (form with photo upload)
- edit.blade.php

### Policies
Path: resources/views/backend/superadmin/website/policies/
- index.blade.php (list with title, slug, order)
- create.blade.php (wysiwyg editor recommended)
- edit.blade.php

### Gallery
Path: resources/views/backend/superadmin/website/gallery/
- index.blade.php (image grid)
- create.blade.php (image upload with category)
- edit.blade.php

## 🎨 View Template Pattern

Each CRUD follows this structure:

### Index View
```blade
@extends('backend.layouts.app')
@section('title', 'Title')
@section('content')
    <h2>Title</h2>
    <a href="create">Add New</a>
    <table or cards>
        @forelse($items as $item)
            // Display item with edit/delete
        @empty
            // Empty state
        @endforelse
    </table>
    {{ $items->links() }}
@endsection
```

### Create/Edit View
```blade
@extends('backend.layouts.app')
@section('title', 'Create/Edit')
@section('content')
    <breadcrumb>
    <form method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') // for edit only
        
        // Form fields with validation errors
        
        <button type="submit">Save</button>
    </form>
@endsection
```

## 🔧 Key Features in Controller

1. **Image Upload**: All handled in controller
2. **Validation**: Required fields validated
3. **Active/Inactive**: Checkbox toggle
4. **Ordering**: Integer field for sorting
5. **Storage**: Uses Laravel's Storage facade

## 📸 Image Storage

All images stored in: `storage/app/public/{folder}/`

Folders:
- sliders/
- services/
- about/
- leadership/
- gallery/

Don't forget to run: `php artisan storage:link`

## 🎯 Next Steps

1. Create remaining views following the slider/service pattern
2. Test CRUD operations for each section
3. Add sample data via seeders (optional)
4. Update frontend to pull from database

## 💡 Quick Tips

- Copy sliders/create.blade.php as template
- Adjust fields based on migration
- Use same layout and styling
- Bootstrap icons: https://icons.getbootstrap.com/
- Image preview with: `asset('storage/' . $item->image)`

## 🔗 Route Naming Convention

All routes follow: `superadmin.website.{section}.{action}`

Examples:
- superadmin.website.sliders.index
- superadmin.website.services.create
- superadmin.website.about.edit

## ✨ Access

Navigate to: Dashboard → Settings → Website Settings → [Section]
