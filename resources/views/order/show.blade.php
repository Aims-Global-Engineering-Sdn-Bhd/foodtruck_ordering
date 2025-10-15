@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Order Details')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Order Details'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                {{-- 🧾 Order Details Card --}}
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-primary">
                            <i class="ni ni-basket me-1"></i> Order #{{ $order->id }}
                        </h6>
                        <a href="{{ route('order.index') }}" class="btn btn-sm btn-light border">
                            <i class="ni ni-bold-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body px-4 pt-4 pb-4">
                        {{-- ✅ Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text">{{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- 🔹 Order Information Section --}}
                        <div class="mb-4">
                            <h5 class="text-dark fw-bold mb-3">🧍 Customer Information</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="text-sm text-secondary mb-1">Customer Name</h6>
                                    <p class="fw-semibold mb-0">{{ $order->customer_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-sm text-secondary mb-1">Order Date</h6>
                                    <p class="fw-semibold mb-0">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-sm text-secondary mb-1">Status</h6>
                                    <span class="badge rounded-pill bg-{{
                                        $order->status == 0 ? 'danger' :
                                        ($order->status == 1 ? 'warning' :
                                        ($order->status == 2 ? 'info' : 'success')) }}">
                                        {{
                                            $order->status == 0 ? 'New Order' :
                                            ($order->status == 1 ? 'In Progress' :
                                            ($order->status == 2 ? 'Ready To Pick Up' : 'Completed'))
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- 🔹 Order Items Section --}}
                        <div class="border-top pt-4 mt-3 mb-4">
                            <h5 class="text-dark fw-bold mb-3">🍽️ Ordered Items</h5>

                            <div class="table-responsive shadow-sm rounded-3">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light text-secondary">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Menu Item</th>
                                        <th>Category</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Price (RM)</th>
                                        <th class="text-end">Total (RM)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order->bookings as $booking)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="fw-semibold">{{ $booking->menu->name ?? '-' }}</td>
                                            <td>{{ $booking->menu->category ?? '-' }}</td>
                                            <td class="text-center">{{ $booking->quantity }}</td>
                                            <td class="text-end">{{ number_format($booking->menu->price, 2) }}</td>
                                            <td class="text-end">{{ number_format($booking->quantity * $booking->menu->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- 🔹 Summary Section --}}
                        @php
                            $subtotal = $order->bookings->sum(fn($b) => $b->quantity * $b->menu->price);
                            $tax = $subtotal * 0.06;
                            $total = $subtotal + $tax;
                        @endphp

                        <div class="border-top pt-4 mt-3 mb-4">
                            <h5 class="text-dark fw-bold mb-3">💰 Payment Summary</h5>
                            <div class="row gy-3">
                                <div class="col-md-4">
                                    <h6 class="text-sm text-secondary mb-1">Subtotal</h6>
                                    <p class="fw-semibold mb-0">RM {{ number_format($subtotal, 2) }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-sm text-secondary mb-1">Tax (6%)</h6>
                                    <p class="fw-semibold mb-0">RM {{ number_format($tax, 2) }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-sm text-secondary mb-1">Total</h6>
                                    <h5 class="text-success fw-bold mb-0">RM {{ number_format($total, 2) }}</h5>
                                </div>
                            </div>
                        </div>

                        {{-- 🔹 Meta Info --}}
                        <div class="d-flex justify-content-between text-muted small mt-4 pt-3 border-top">
                            <div>
                                <strong>Created:</strong>
                                {{ $order->created_at->format('d M Y, h:i A') }}
                            </div>
                            <div>
                                <strong>Updated:</strong>
                                {{ $order->updated_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
