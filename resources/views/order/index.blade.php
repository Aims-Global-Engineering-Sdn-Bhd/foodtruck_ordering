@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Order Management')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Menu List'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Order List</h6>

                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Success!</strong> {{session('success')}}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Total Amount (RM)</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{$order->date}}</td>
                                        <td class="align-middle">{{$order->customer_name}}</td>
                                        <td class="align-middle">
                                            @switch($order->status)
                                                @case(0)
                                                <span class="text-primary fw-semibold">🆕 New Order</span>
                                                @break

                                                @case(1)
                                                <span class="text-warning fw-semibold">⏳ In Progress</span>
                                                @break

                                                @case(2)
                                                <span class="text-info fw-semibold">📦 Ready To Pick Up</span>
                                                @break

                                                @case(3)
                                                <span class="text-success fw-semibold">✅ Completed</span>
                                                @break

                                                @default
                                                <span class="text-muted">Unknown</span>
                                            @endswitch
                                        </td>
                                        <td class="align-middle">{{number_format($order->total_amount, 2)}}</td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('order.show', $order->id) }}"
                                               class="btn btn-sm btn-info text-white"
                                               title="View">
                                                <i class="ni ni-single-copy-04"></i>
                                            </a>

                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
    </div>
@endsection
