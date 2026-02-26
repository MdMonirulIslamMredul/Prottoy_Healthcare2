@extends('backend.layouts.app')

@section('title', 'Words')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Words</h2>
            <a href="{{ route('pho.words.create') }}" class="btn btn-primary">Add New Word</a>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($words->count())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Bangla Name</th>
                                <th>Union</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($words as $word)
                                <tr>
                                    <td>{{ $loop->iteration + ($words->currentPage() - 1) * $words->perPage() }}</td>
                                    <td>{{ $word->name }}</td>
                                    <td>{{ $word->bn_name }}</td>
                                    <td>{{ $word->union->name ?? 'N/A' }}</td>
                                    <td>{{ $word->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('pho.words.edit', $word) }}"
                                            class="btn btn-sm btn-secondary">Edit</a>
                                        <form action="{{ route('pho.words.destroy', $word) }}" method="POST"
                                            style="display:inline-block" onsubmit="return confirm('Delete this word?');">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <button class="btn btn-sm btn-danger">Delete</button> --}}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $words->links() }}
                @else
                    <p class="text-muted">No words created yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
