@extends('admin.layouts.app')

@section('page-title', 'Edit Category')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
