@if ($customers->count() > 0)
    <div id="customers-list-content">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                            <td>
                                <small>
                                    {{ $customer->upzila->name ?? 'N/A' }},
                                    {{ $customer->district->name ?? 'N/A' }}
                                </small>
                            </td>
                            <td>{{ $customer->created_at->format('d M Y') }}</td>
                            <td>

                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pho.packages.create', ['customer_id' => $customer->id]) }}"
                                        class="btn btn-outline-success" title="Purchase Package">
                                        <i class="bi bi-cart-plus"></i>
                                    </a>
                                    <a href="{{ route('pho.customers.edit', $customer->id) }}"
                                        class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pho.customers.destroy', $customer->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3" id="customers-pagination">
            {{ $customers->links() }}
        </div>
    </div>
@else
    <div class="text-center py-5" id="customers-list-content-empty">
        <i class="bi bi-people" style="font-size: 3rem; color: #ccc;"></i>
        @if (!empty(request('q')) || !empty($search))
            <p class="text-muted mt-3">No customers match your search.</p>
        @else
            <p class="text-muted mt-3">No customers found. Click "Add New Customer" to create one.</p>
        @endif
    </div>
@endif
