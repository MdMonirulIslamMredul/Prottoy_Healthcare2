@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2>Upazila Supervisor Details</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.upazila-supervisors.index') }}">Upazila
                            Supervisors</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $upazilaSupervisor->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Email:</label>
                        <p>{{ $upazilaSupervisor->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Phone:</label>
                        <p>{{ $upazilaSupervisor->phone }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Address:</label>
                        <p>{{ $upazilaSupervisor->address ?? 'N/A' }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">District:</label>
                            <p>{{ $upazilaSupervisor->district->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Upazila:</label>
                            <p>{{ $upazilaSupervisor->upzila->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Union:</label>
                            <p>{{ $upazilaSupervisor->union->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Additional upazila supervisor details can be added here -->

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('superadmin.upazila-supervisors.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('superadmin.upazila-supervisors.edit', $upazilaSupervisor->id) }}"
                            class="btn btn-primary">Edit
                            Upazila Supervisor</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
