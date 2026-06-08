@extends('admin.layouts.app')

@section('page-title', 'Edit User')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Roles</label>
                <select name="roles[]" class="form-select" multiple>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->label }}</option>
                    @endforeach
                </select>
                <div class="form-text">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</div>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
