@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Package Details</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('packages.index') }}">Packages</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div>
                                <h3 class="h5 mb-1">{{ $package->name }}</h3>
                                <p class="text-muted mb-0">Package ID: <span class="fw-medium">#{{ $package->id }}</span>
                                </p>
                            </div>
                            <div class="text-end">
                                <div class="mb-1">
                                    <span class="fs-5 text-success fw-bold">৳{{ number_format($package->price, 2) }}</span>
                                </div>
                                <div>
                                    @if ($package->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="mb-2">Overview</h6>
                            <div class="text-muted lh-lg">{!! $package->details !!}</div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <h6 class="mb-1">Created</h6>
                                <p class="mb-0 text-muted">{{ $package->created_at->format('d M, Y h:i A') }}</p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <h6 class="mb-1">Last Updated</h6>
                                <p class="mb-0 text-muted">{{ $package->updated_at->format('d M, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top:1rem;">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="fs-3 fw-bold text-success">৳{{ number_format($package->price, 2) }}</div>
                            <div class="text-muted">One-time / Per purchase</div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary">Back</a>
                            <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-primary">Edit Package</a>
                            {{-- <a href="#" class="btn btn-success">Purchase Now</a> --}}
                        </div>

                        <hr>

                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><strong>Status:</strong>
                                <div>
                                    @if ($package->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </div>
                            </li>
                            <li class="mb-2"><strong>Created:</strong>
                                <div class="text-muted">{{ $package->created_at->format('d M, Y') }}</div>
                            </li>
                            <li class="mb-2"><strong>Updated:</strong>
                                <div class="text-muted">{{ $package->updated_at->format('d M, Y') }}</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
