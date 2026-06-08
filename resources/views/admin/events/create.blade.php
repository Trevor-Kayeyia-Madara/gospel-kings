@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="eyebrow mb-2">Events</div>
                    <h1 class="fw-bold">Create Event</h1>
                    <p class="muted">Add future ministry events without changing application code.</p>
                </div>
                <div class="col-lg-8">
                    <form class="content-card p-4" method="POST" action="{{ route('admin.events.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Title</label>
                                <input class="form-control" name="title" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Edition</label>
                                <input class="form-control" name="edition">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="event_category_id">
                                    <option value="">None</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Theme</label>
                                <input class="form-control" name="theme">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Summary</label>
                                <textarea class="form-control" name="summary" rows="2" required></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Venue</label>
                                <input class="form-control" name="venue" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input class="form-control" name="city">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Starts at</label>
                                <input class="form-control" type="datetime-local" name="starts_at" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ends at</label>
                                <input class="form-control" type="datetime-local" name="ends_at">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Capacity</label>
                                <input class="form-control" type="number" min="1" name="capacity">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_paid" value="1">
                                    <span class="form-check-label">Paid event</span>
                                </label>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="registration_open" value="1" checked>
                                    <span class="form-check-label">Registration open</span>
                                </label>
                            </div>
                            @if ($errors->any())
                                <div class="col-12"><div class="alert alert-danger">{{ $errors->first() }}</div></div>
                            @endif
                            <div class="col-12">
                                <button class="btn btn-primary btn-lg">Create event</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
