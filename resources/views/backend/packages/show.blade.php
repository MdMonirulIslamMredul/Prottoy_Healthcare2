@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Package Details</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('packages.index') }}">Packages</a></li>
                <li class="breadcrumb-item active">Details</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $package->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Price:</label>
                    <p class="fs-4 text-success">৳{{ number_format($package->price, 2) }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Status:</label>
                    <p>
                        @if($package->is_active)
                            <span class="badge bg-success fs-6">Active</span>
                        @else
                            <span class="badge bg-secondary fs-6">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Details:</label>
                <p class="text-muted">{{ $package->details }}</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Created:</label>
                    <p>{{ $package->created_at->format('d M, Y h:i A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Last Updated:</label>
                    <p>{{ $package->updated_at->format('d M, Y h:i A') }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('packages.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-primary">Edit Package</a>
            </div>
        </div>
    </div>
</div>
@endsection
