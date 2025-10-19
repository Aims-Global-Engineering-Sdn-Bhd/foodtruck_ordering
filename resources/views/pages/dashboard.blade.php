@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])

    @php
        $hour = now()->format('H');
        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 18) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good evening';
        }
    @endphp

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="card shadow-sm border-0 rounded-4 p-5 bg-white">
                    <div class="card-body">
                        <i class="ni ni-hat-3 text-primary display-4 mb-3"></i>
                        <h2 class="fw-bold text-dark mb-2">{{ $greeting }}, {{ Auth::user()->name ?? 'User' }}!</h2>
                        <p class="text-muted mb-4">Welcome to your dashboard. Here’s a quick look at your system today.</p>

                        <!-- Summary Cards -->
                        <div class="row justify-content-center mt-4">
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card border-0 shadow-sm rounded-4 p-3">
                                    <h6 class="text-muted mb-1">Total Orders</h6>
                                    <h3 class="fw-bold text-primary">{{ $ordersCount ?? 0 }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card border-0 shadow-sm rounded-4 p-3">
                                    <h6 class="text-muted mb-1">Menus Available</h6>
                                    <h3 class="fw-bold text-success">{{ $menusAvailable ?? 0 }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card border-0 shadow-sm rounded-4 p-3">
                                    <h6 class="text-muted mb-1">Bookings</h6>
                                    <h3 class="fw-bold text-info">{{ $bookingsCount ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-4">
                            <a href="{{ route('menu.index') }}" class="btn btn-primary me-2 rounded-pill px-4">
                                <i class="ni ni-collection me-1"></i> Manage Menu
                            </a>
                            <a href="{{ route('order.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="ni ni-cart me-1"></i> View Orders
                            </a>
                        </div>

                        <!-- Motivational / Tip Card -->
                        <div class="mt-5">
                            <div class="alert alert-light border-start border-3 border-primary text-start shadow-sm rounded-3">
                                <h6 class="text-dark mb-1"><i class="ni ni-bulb-61 text-primary me-2"></i>Tip of the Day</h6>
                                <p class="text-muted mb-0">
                                    Keep your menu updated! Toggle item availability easily from the <strong>Quick Menu Management</strong> page.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
