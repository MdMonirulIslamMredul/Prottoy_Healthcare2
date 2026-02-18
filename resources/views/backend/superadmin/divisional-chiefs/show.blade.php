@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2>Divisional Chief Details</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb       -item"><a href="{{ route('superadmin.divisional-chiefs.index') }}">Divisional
                            Chiefs</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $divisionalChief->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Email:</label>
                        <p>{{ $divisionalChief->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Division:</label>
                        <p>{{ $divisionalChief->division->name ?? 'N/A' }}</p>
                    </div>

                    <!-- Additional divisional chief details can be added here -->

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('superadmin.divisional-chiefs.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('superadmin.divisional-chiefs.edit', $divisionalChief->id) }}"
                            class="btn btn-primary">Edit Divisional Chief</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
