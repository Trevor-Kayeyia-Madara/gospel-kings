@extends('admin.layouts.app')

@section('page-title', 'Upload Media')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Gallery</label>
                <select name="gallery_id" class="form-select">
                    <option value="">None</option>
                    @foreach ($galleries as $gallery)
                        <option value="{{ $gallery->id }}" @selected(old('gallery_id') == $gallery->id)>{{ $gallery->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="photo">Photo</option>
                    <option value="video">Video</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">File</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Thumbnail (optional)</label>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
