@extends('backend.layouts.app')

@section('title', 'Edit Word')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Word</h2>
            <a href="{{ route('pho.words.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('pho.words.update', $word) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="union_id" class="form-label">Union <span class="text-danger">*</span></label>
                                <select id="union_id" name="union_id"
                                    class="form-select @error('union_id') is-invalid @enderror" required>
                                    @foreach ($unions as $union)
                                        <option value="{{ $union->id }}"
                                            {{ $word->union_id == $union->id ? 'selected' : '' }}>{{ $union->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('union_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input id="name" name="name" value="{{ old('name', $word->name) }}" required
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bn_name" class="form-label">Bangla Name</label>
                                <input id="bn_name" name="bn_name" value="{{ old('bn_name', $word->bn_name) }}"
                                    class="form-control @error('bn_name') is-invalid @enderror">
                                @error('bn_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pho.words.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Word</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
