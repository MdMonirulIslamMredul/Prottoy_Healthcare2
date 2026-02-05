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
                    <p class="text-muted mb-0">Complete organizational structure for {{ $upazilaSupervisor->upzila->name }}</p>
                </div>
                <a href="{{ route('upazilasupervisor.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Upazila Supervisor (Root) -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-info shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="bi bi-person-badge text-info fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $upazilaSupervisor->name }}</h5>
                            <p class="mb-0 text-muted">Upazila Supervisor - {{ $upazilaSupervisor->upzila->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($phos->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>No PHOs found under your supervision.
        </div>
    @else
        <!-- PHO Level -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="ms-4">
                    @foreach($phos as $pho)
                        <div class="card border-warning shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                        <i class="bi bi-person-vcard text-warning fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0">{{ $pho->name }}</h5>
                                        <p class="mb-0 text-muted">PHO</p>
                                        <small class="text-muted">{{ $pho->email }}</small>
                                        @if($pho->phone)
                                            | <small class="text-muted">{{ $pho->phone }}</small>
                                        @endif
                                    </div>
                                    @if($pho->customers->isNotEmpty())
                                        <div class="text-end">
                                            <span class="badge bg-warning text-dark">{{ $pho->customers->count() }} Customers</span>
                                        </div>
                                    @endif
                                </div>

                                @if($pho->customers->isNotEmpty())
                                    <!-- Customer Level -->
                                    <div class="mt-3">
                                        <div class="accordion" id="customerAccordion{{ $pho->id }}">
                                            <div class="accordion-item border-0">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#customers{{ $pho->id }}">
                                                        <i class="bi bi-person-circle text-secondary me-2"></i>
                                                        <strong>Customers ({{ $pho->customers->count() }})</strong>
                                                    </button>
                                                </h2>
                                                <div id="customers{{ $pho->id }}" class="accordion-collapse collapse" data-bs-parent="#customerAccordion{{ $pho->id }}">
                                                    <div class="accordion-body">
                                                        @foreach($pho->customers as $customer)
                                                            <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                                                <div class="rounded-circle bg-secondary bg-opacity-10 p-2 me-2">
                                                                    <i class="bi bi-person-circle text-secondary"></i>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <strong>{{ $customer->name }}</strong><br>
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
                                @else
                                    <div class="alert alert-warning mt-3 mb-0 py-2">
                                        <small><i class="bi bi-info-circle me-1"></i>No customers assigned to this PHO</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
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
