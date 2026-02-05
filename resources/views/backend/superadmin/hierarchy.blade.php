@extends('backend.layouts.app')

@section('title', 'User Hierarchy')
@section('page-title', 'User Hierarchy')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="bi bi-diagram-3 text-purple me-2"></i>Complete User Hierarchy
                    </h2>
                    <p class="text-muted mb-0">Full organizational structure of the Prottoy Healthcare system</p>
                </div>
                <a href="{{ route('superadmin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Division Selector -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('superadmin.hierarchy') }}" id="divisionForm">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="division_id" class="form-label">
                                    <i class="bi bi-funnel text-primary me-1"></i>
                                    <strong>Select Division to View Hierarchy</strong>
                                </label>
                                <select name="division_id" id="division_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Select a Division --</option>
                                    @foreach($allDivisions as $division)
                                        <option value="{{ $division->id }}" {{ $selectedDivisionId == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i>View Hierarchy
                                </button>
                                @if($selectedDivisionId)
                                    <a href="{{ route('superadmin.hierarchy') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(!$selectedDivisionId)
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>Please select a division from the dropdown above to view its organizational hierarchy.
        </div>
    @elseif($divisions->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>No divisions found in the system.
        </div>
    @else
        @foreach($divisions as $division)
            <!-- Division Level -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-primary shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                    <i class="bi bi-globe text-primary fs-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 class="mb-0">{{ $division->name }}</h4>
                                    <p class="mb-0 text-muted">Division</p>
                                </div>
                                @if($division->divisionalChief)
                                    <div class="border-start ps-3">
                                        <strong>Divisional Chief:</strong> {{ $division->divisionalChief->name }}<br>
                                        <small class="text-muted">{{ $division->divisionalChief->email }}</small>
                                    </div>
                                @else
                                    <div class="text-warning">
                                        <i class="bi bi-exclamation-triangle me-1"></i>No Chief Assigned
                                    </div>
                                @endif
                            </div>

                            @if($division->districts->isNotEmpty())
                                <!-- District Level -->
                                <div class="mt-3">
                                    @foreach($division->districts as $district)
                                        <div class="ms-4 mb-3">
                                            <div class="card border-success">
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
                                                                <i class="bi bi-exclamation-triangle me-1"></i>No Manager
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if($district->upzilas->isNotEmpty())
                                                        <!-- Upazila Level -->
                                                        <div class="mt-3">
                                                            <div class="accordion" id="upazilaAccordion{{ $district->id }}">
                                                                <div class="accordion-item border-0">
                                                                    <h2 class="accordion-header">
                                                                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#upzilas{{ $district->id }}">
                                                                            <i class="bi bi-pin-map text-info me-2"></i>
                                                                            <strong>Upazilas ({{ $district->upzilas->count() }})</strong>
                                                                        </button>
                                                                    </h2>
                                                                    <div id="upzilas{{ $district->id }}" class="accordion-collapse collapse" data-bs-parent="#upazilaAccordion{{ $district->id }}">
                                                                        <div class="accordion-body">
                                                                            @foreach($district->upzilas as $upzila)
                                                                                <div class="ms-3 mb-2">
                                                                                    <div class="card border-info">
                                                                                        <div class="card-body py-2">
                                                                                            <div class="d-flex align-items-center">
                                                                                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-2">
                                                                                                    <i class="bi bi-pin-map text-info"></i>
                                                                                                </div>
                                                                                                <div class="flex-grow-1">
                                                                                                    <strong>{{ $upzila->name }}</strong>
                                                                                                    @if($upzila->upazilaSupervisor)
                                                                                                        <br><small class="text-muted">Supervisor: {{ $upzila->upazilaSupervisor->name }}</small>
                                                                                                    @endif
                                                                                                </div>
                                                                                                @if($upzila->phos->isNotEmpty())
                                                                                                    <span class="badge bg-info">{{ $upzila->phos->count() }} PHOs</span>
                                                                                                @endif
                                                                                            </div>

                                                                                            @if($upzila->phos->isNotEmpty())
                                                                                                <!-- PHO Level -->
                                                                                                <div class="mt-2">
                                                                                                    <div class="accordion" id="phoAccordion{{ $upzila->id }}">
                                                                                                        <div class="accordion-item border-0">
                                                                                                            <h2 class="accordion-header">
                                                                                                                <button class="accordion-button collapsed bg-light py-1" type="button" data-bs-toggle="collapse" data-bs-target="#phos{{ $upzila->id }}">
                                                                                                                    <i class="bi bi-people text-warning me-2"></i>
                                                                                                                    <small><strong>PHOs ({{ $upzila->phos->count() }})</strong></small>
                                                                                                                </button>
                                                                                                            </h2>
                                                                                                            <div id="phos{{ $upzila->id }}" class="accordion-collapse collapse" data-bs-parent="#phoAccordion{{ $upzila->id }}">
                                                                                                                <div class="accordion-body py-2">
                                                                                                                    @foreach($upzila->phos as $pho)
                                                                                                                        <div class="d-flex align-items-center mb-1 p-2 border rounded">
                                                                                                                            <i class="bi bi-person text-warning me-2"></i>
                                                                                                                            <div class="flex-grow-1">
                                                                                                                                <small><strong>{{ $pho->name }}</strong></small>
                                                                                                                                @if($pho->customers->isNotEmpty())
                                                                                                                                    <br><small class="text-muted">{{ $pho->customers->count() }} customers</small>
                                                                                                                                @endif
                                                                                                                            </div>
                                                                                                                            @if($pho->customers->isNotEmpty())
                                                                                                                                <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#customers{{ $pho->id }}">
                                                                                                                                    <i class="bi bi-chevron-down"></i>
                                                                                                                                </button>
                                                                                                                            @endif
                                                                                                                        </div>
                                                                                                                        @if($pho->customers->isNotEmpty())
                                                                                                                            <!-- Customer Level -->
                                                                                                                            <div class="collapse ms-4 mb-2" id="customers{{ $pho->id }}">
                                                                                                                                @foreach($pho->customers as $customer)
                                                                                                                                    <div class="d-flex align-items-center mb-1 p-1 border rounded bg-light">
                                                                                                                                        <i class="bi bi-person-circle text-secondary me-2"></i>
                                                                                                                                        <small>{{ $customer->name }}</small>
                                                                                                                                    </div>
                                                                                                                                @endforeach
                                                                                                                            </div>
                                                                                                                        @endif
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
                                                        <div class="alert alert-warning mt-3 mb-0 py-2">
                                                            <small><i class="bi bi-info-circle me-1"></i>No upazilas in this district</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning mt-3 mb-0">
                                    <i class="bi bi-info-circle me-2"></i>No districts in this division
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@push('styles')
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
@endpush
