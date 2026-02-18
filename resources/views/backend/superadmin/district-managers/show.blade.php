@extends('backend.layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">District Manager Details</h4>
                    <a href="{{ route('superadmin.district-managers.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Manager Information</h5>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">ID:</label>
                            <div class="col-sm-9">{{ $districtManager->id }}</div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">Name:</label>
                            <div class="col-sm-9">{{ $districtManager->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">Email:</label>
                            <div class="col-sm-9">{{ $districtManager->email }}</div>
                        </div>

                        @if ($districtManager->division)
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-semibold">Division:</label>
                                <div class="col-sm-9">{{ $districtManager->division->name }}</div>
                            </div>
                        @endif

                        @if ($districtManager->district)
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-semibold">District:</label>
                                <div class="col-sm-9">{{ $districtManager->district->name }}</div>
                            </div>
                        @endif

                        @if ($districtManager->upazila)
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-semibold">Upazila:</label>
                                <div class="col-sm-9">{{ $districtManager->upazila->name }}</div>
                            </div>
                        @endif

                        @if ($districtManager->phone)
                            <hr />
                            <h5>Contact Information</h5>

                            <p><i class='bi bi-phone me-2'></i>{{ $districtManager->phone }}</p>
                        @endif

                    </div>
                </div>

                <!-- Action Buttons -->
                @can('update', $districtManager)
                    <!-- Edit Button -->
                    @if (auth()->user()->can('update', $districtManager))
                        <!-- Edit Button -->
                        <!-- You can add an edit button here if needed -->
                    @endif
                @endcan

                <!-- Delete Button -->
                @can('delete', $districtManager)
                    <!-- Delete Button -->
                    @if (auth()->user()->can('delete', $districtManager))
                        <!-- Delete Button -->
                        <!-- You can add a delete button here if needed -->
                    @endif
                @endcan
            </div>
            </section>
        </div>
    </div>
@endsection
