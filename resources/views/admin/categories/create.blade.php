@extends('admin.layouts.app')

@section('page-title', 'Create Category')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
