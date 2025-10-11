@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Menu Details')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Menu Details'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Menu Details</h6>
                        <a href="{{ route('menu.index') }}" class="btn btn-sm btn-light border">
                            <i class="ni ni-bold-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body px-4 pt-4 pb-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text">{{session('success')}}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        {{-- Image Section --}}
                        <div class="mb-4 text-center">
                            @if($menu->url_food)
                                <div class="border rounded-3 shadow-sm d-inline-block p-2 bg-light">
                                    <img src="{{ asset($menu->url_food) }}"
                                         alt="{{ $menu->name }}"
                                         class="img-fluid rounded-3"
                                         style="max-height: 250px; object-fit: cover; width: auto;">
                                </div>
                            @else
                                <div class="border rounded-3 shadow-sm d-inline-block p-5 bg-light text-muted">
                                    <i class="ni ni-image text-secondary" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-0">No image available</p>
                                </div>
                            @endif
                        </div>

                        {{-- 🧾 Menu Details --}}
                        <div class="mb-4">
                            <h5 class="text-primary mb-1">{{ $menu->name }}</h5>
                            <p class="text-muted mb-0">{{ $menu->category }}</p>
                        </div>

                        <div class="border-top pt-3">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="text-sm mb-1 text-secondary">Price</h6>
                                    <p class="mb-0 fw-bold">RM {{ number_format($menu->price, 2) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-sm mb-1 text-secondary">Availability</h6>
                                    @if($menu->avail_status)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Unavailable</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-sm mb-1 text-secondary">Description</h6>
                                <p class="mb-0">{{ $menu->description ?? 'No description provided.' }}</p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-sm mb-1 text-secondary">Remarks</h6>
                                <p class="mb-0">{{ $menu->remark ?? '—' }}</p>
                            </div>

                            <div class="d-flex justify-content-between text-muted small mt-4 pt-3 border-top">
                                <div>
                                    <strong>Created:</strong>
                                    {{ $menu->created_at->format('d M Y, h:i A') }}
                                </div>
                                <div>
                                    <strong>Updated:</strong>
                                    {{ $menu->updated_at->format('d M Y, h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
