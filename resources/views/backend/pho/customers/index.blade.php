@extends('backend.layouts.app')

@section('title', 'Manage Customers')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Customers</h2>
            <a href="{{ route('pho.customers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Customer
            </a>
        </div>

        <div class="mb-3">
            <form method="GET" action="{{ route('pho.customers.index') }}" class="row g-2">
                <div class="col-auto flex-grow-1">
                    <input type="search" name="q" class="form-control" placeholder="Search by name, email or phone"
                        value="{{ request('q', $search ?? '') }}">
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('pho.customers.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body" id="customers-list">
                @include('backend.pho.customers._list')
            </div>
        </div>

        @push('scripts')
            <script>
                (function() {
                    const input = document.querySelector('input[name="q"]');
                    const listContainer = document.getElementById('customers-list');

                    function debounce(fn, delay = 300) {
                        let t;
                        return function(...args) {
                            clearTimeout(t);
                            t = setTimeout(() => fn.apply(this, args), delay);
                        };
                    }

                    async function fetchList(url) {
                        try {
                            const res = await fetch(url, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });
                            const html = await res.text();
                            listContainer.innerHTML = html;
                            attachPaginationHandlers();
                        } catch (err) {
                            console.error('Failed to fetch customers list', err);
                        }
                    }

                    function attachPaginationHandlers() {
                        document.querySelectorAll('#customers-list a.page-link').forEach(link => {
                            link.removeEventListener('click', handlePageClick);
                            link.addEventListener('click', handlePageClick);
                        });
                    }

                    function handlePageClick(e) {
                        e.preventDefault();
                        const href = this.getAttribute('href');
                        if (href) {
                            fetchList(href);
                            history.pushState(null, '', href);
                        }
                    }

                    // Live search on input
                    if (input) {
                        const onInput = debounce(function(e) {
                            const q = e.target.value.trim();
                            const url = new URL(window.location.href);
                            if (q) url.searchParams.set('q', q);
                            else url.searchParams.delete('q');
                            fetchList(url.toString());
                        }, 300);

                        input.addEventListener('input', onInput);
                    }

                    // Clear button: re-fetch without q (delegated)
                    document.querySelectorAll('a.btn-outline-secondary').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            // allow default navigation to happen; also update list via AJAX
                            setTimeout(() => fetchList(window.location.href), 10);
                        });
                    });

                    // Init pagination handlers on page load
                    attachPaginationHandlers();
                })();
            </script>
        @endpush
    </div>
@endsection
