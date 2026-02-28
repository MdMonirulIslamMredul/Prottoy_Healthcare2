@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Available Packages</h2>
            <a href="{{ route('customer.packages.index') }}" class="btn btn-secondary">My Purchase History</a>
        </div>

        <div class="row">
            @forelse($packages as $package)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-info shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $package->name }}</h5>
                            <div class="small text-muted">৳{{ number_format($package->price, 2) }} <span
                                    class="ms-2 badge bg-info">{{ $package->is_active ? 'Active' : 'Inactive' }}</span>
                            </div>

                            <p class="card-text text-muted flex-grow-1 mt-2">
                                {{ Str::limit(strip_tags($package->details), 120) }}</p>

                            <div class="mt-3 d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-package-details"
                                    data-title="{{ e($package->name) }}"
                                    data-details="{{ base64_encode($package->details) }}">
                                    <i class="bi bi-eye me-1"></i> Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No packages available</p>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.btn-package-details').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const title = this.getAttribute('data-title') || 'Package Details';
                        const detailsB64 = this.getAttribute('data-details') || '';
                        let html = '';
                        try {
                            html = detailsB64 ? atob(detailsB64) : '';
                        } catch (e) {
                            html = '';
                        }
                        const modal = new bootstrap.Modal(document.getElementById(
                            'packageDetailsModal'));
                        document.getElementById('packageDetailsTitle').textContent = title;
                        document.getElementById('packageDetailsBody').innerHTML = html ||
                            '<p class="text-muted">No details available.</p>';
                        modal.show();
                    });
                });
            });
        </script>
    @endpush

    <!-- Modal -->
    <div class="modal fade" id="packageDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="packageDetailsTitle">Package Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="packageDetailsBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
