@extends('layouts.app')

@section('title', 'David Kasika')

@section('content')
    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5">
                    <img class="img-fluid rounded-3" src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=900&q=80" alt="Music ministry">
                </div>
                <div class="col-lg-7">
                    <div class="eyebrow mb-2">Ministry Profile</div>
                    <h1 class="fw-bold">David Kasika</h1>
                    <p class="lead muted">
                        David Kasika Official

Description
Gospel Music channel for uplifting music inspired by The Holy Spirit
 https://www.youtube.com/channel/UCflCGbTeg6I-xovPK_4cDTQ
Links

Subscribe to David Kasika
youtube.com/c/Davidkasika?sub_confirmation=1

David Kasika
instagram.com/davidkasika

David Kasika Official
youtube.com/channel/UCflCGbTeg6I-xovPK_4cDTQ
                    </p>
                    <div class="row g-3 mt-3">
                        @foreach (['Biography', 'Ministry Journey', 'Music Ministry', 'Messages'] as $item)
                            <div class="col-sm-6">
                                <div class="content-card p-3 fw-bold">{{ $item }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
