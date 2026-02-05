@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="bi bi-diagram-3 text-purple me-2"></i>User Hierarchy
                    </h2>
                    <p class="text-muted mb-0">Complete organizational structure for {{ $divisionalChief->division->name }}</p>
                </div>
                <a href="{{ route('divisionalchief.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Divisional Chief (Root) -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-person-badge text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $divisionalChief->name }}</h5>
                            <p class="mb-0 text-muted">Divisional Chief - {{ $divisionalChief->division->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($districts->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>No districts found in this division.
        </div>
    @else
        @foreach($districts as $district)
            <!-- District Level -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="ms-4">
                        <div class="card border-success shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                        <i class="bi bi-geo-alt text-success fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0">{{ $district->name }}</h5>
                                        <p class="mb-0 text-muted">District</p>
                                    </div>
                                    @if($district->districtManager)
                                        <div class="border-start ps-3">
                                            <strong>Manager:</strong> {{ $district->districtManager->name }}<br>
                                            <small class="text-muted">{{ $district->districtManager->email }}</small>
                                        </div>
                                    @else
                                        <div class="text-warning">
                                            <i class="bi bi-exclamation-triangle me-1"></i>No Manager Assigned
                                        </div>
                                    @endif
                                </div>

                                @if($district->upzilas->isNotEmpty())
                                    <!-- Upazila Level -->
                                    <div class="mt-3">
                                        @foreach($district->upzilas as $upzila)
                                            <div class="ms-4 mb-3">
                                                <div class="card border-info">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3">
                                                                <i class="bi bi-pin-map text-info fs-5"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">{{ $upzila->name }}</h6>
                                                                <small class="text-muted">Upazila</small>
                                                            </div>
                                                            @if($upzila->upazilaSupervisor)
                                                                <div class="border-start ps-3">
                                                                    <strong>Supervisor:</strong> {{ $upzila->upazilaSupervisor->name }}<br>
                                                                    <small class="text-muted">{{ $upzila->upazilaSupervisor->email }}</small>
                                                                </div>
                                                            @else
                                                                <div class="text-warning">
                                                                    <i class="bi bi-exclamation-triangle me-1"></i>No Supervisor
                                                                </div>
                                                            @endif
                                                        </div>

                                                        @if($upzila->phos->isNotEmpty())
                                                            <!-- PHO Level -->
                                                            <div class="mt-3">
                                                                <div class="accordion" id="phoAccordion{{ $upzila->id }}">
                                                                    <div class="accordion-item border-0">
                                                                        <h2 class="accordion-header">
                                                                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#phos{{ $upzila->id }}">
                                                                                <i class="bi bi-people text-warning me-2"></i>
                                                                                <strong>PHOs ({{ $upzila->phos->count() }})</strong>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="phos{{ $upzila->id }}" class="accordion-collapse collapse" data-bs-parent="#phoAccordion{{ $upzila->id }}">
                                                                            <div class="accordion-body">
                                                                                @foreach($upzila->phos as $pho)
                                                                                    <div class="ms-3 mb-2">
                                                                                        <div class="card border-warning">
                                                                                            <div class="card-body py-2">
                                                                                                <div class="d-flex align-items-center">
                                                                                                    <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                                                                                                        <i class="bi bi-person text-warning"></i>
                                                                                                    </div>
                                                                                                    <div class="flex-grow-1">
                                                                                                        <strong>{{ $pho->name }}</strong><br>
                                                                                                        <small class="text-muted">{{ $pho->email }}</small>
                                                                                                        @if($pho->phone)
                                                                                                            | <small class="text-muted">{{ $pho->phone }}</small>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                    <div class="text-end">
                                                                                                        <span class="badge bg-warning text-dark">PHO</span>
                                                                                                        @if($pho->customers->isNotEmpty())
                                                                                                            <br><small class="text-muted">{{ $pho->customers->count() }} customers</small>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>

                                                                                                @if($pho->customers->isNotEmpty())
                                                                                                    <!-- Customer Level -->
                                                                                                    <div class="mt-2">
                                                                                                        <div class="accordion" id="customerAccordion{{ $pho->id }}">
                                                                                                            <div class="accordion-item border-0">
                                                                                                                <h2 class="accordion-header">
                                                                                                                    <button class="accordion-button collapsed bg-light py-1" type="button" data-bs-toggle="collapse" data-bs-target="#customers{{ $pho->id }}">
                                                                                                                        <i class="bi bi-person-circle text-secondary me-2"></i>
                                                                                                                        <small><strong>Customers ({{ $pho->customers->count() }})</strong></small>
                                                                                                                    </button>
                                                                                                                </h2>
                                                                                                                <div id="customers{{ $pho->id }}" class="accordion-collapse collapse" data-bs-parent="#customerAccordion{{ $pho->id }}">
                                                                                                                    <div class="accordion-body py-2">
                                                                                                                        @foreach($pho->customers as $customer)
                                                                                                                            <div class="d-flex align-items-center mb-1 p-2 border rounded">
                                                                                                                                <i class="bi bi-person-circle text-secondary me-2"></i>
                                                                                                                                <div class="flex-grow-1">
                                                                                                                                    <small><strong>{{ $customer->name }}</strong></small><br>
                                                                                                                                    <small class="text-muted">{{ $customer->email }}</small>
                                                                                                                                    @if($customer->phone)
                                                                                                                                        | <small class="text-muted">{{ $customer->phone }}</small>
                                                                                                                                    @endif
                                                                                                                                </div>
                                                                                                                                <span class="badge bg-secondary">Customer</span>
                                                                                                                            </div>
                                                                                                                        @endforeach
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="alert alert-warning mt-2 mb-0 py-2">
                                                                <small><i class="bi bi-info-circle me-1"></i>No PHOs assigned to this upazila</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-warning mt-3 mb-0">
                                        <i class="bi bi-info-circle me-2"></i>No upazilas in this district
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
.bg-purple {
    background-color: #6f42c1;
}

.text-purple {
    color: #6f42c1;
}

.accordion-button:not(.collapsed) {
    background-color: #f8f9fa !important;
    color: inherit;
}

.accordion-button:focus {
    box-shadow: none;
}
</style>
@endsection
