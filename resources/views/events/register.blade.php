@extends('layouts.app')

@section('title', 'Register for '.$event->title)

@section('content')
    <section class="section section-soft">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="eyebrow mb-2">Registration</div>
                    <h1 class="fw-bold">{{ $event->title }} {{ $event->edition }}</h1>
                    <p class="muted">{{ $event->summary }}</p>
                    <div class="content-card p-4">
                        <div class="fw-bold">What happens after registration?</div>
                        <p class="small muted mb-0">A registration number and QR ticket are issued immediately. Paid packages are marked for M-Pesa STK Push once Daraja credentials are connected.</p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form class="content-card p-4" method="POST" action="{{ route('events.register.store', $event) }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full name</label>
                                <input class="form-control" name="full_name" value="{{ old('full_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone number</label>
                                <input class="form-control" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Church</label>
                                <input class="form-control" name="church" value="{{ old('church') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">County/City</label>
                                <input class="form-control" name="county_city" value="{{ old('county_city') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="">Select</option>
                                    <option>Female</option>
                                    <option>Male</option>
                                    <option>Prefer not to say</option>
                                </select>
                            </div>
                            @if ($event->vipPackages->isNotEmpty())
                                <div class="col-12">
                                    <label class="form-label">Package</label>
                                    <select class="form-select" name="vip_package_id">
                                        <option value="">Free registration</option>
                                        @foreach ($event->vipPackages as $package)
                                            <option value="{{ $package->id }}">{{ $package->name }} - KES {{ number_format($package->amount) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="col-12">
                                    <div class="alert alert-danger mb-0">{{ $errors->first() }}</div>
                                </div>
                            @endif
                            <div class="col-12">
                                <button class="btn btn-primary btn-lg w-100">Submit registration</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
