@extends('layouts.guest')

@section('content')
    <div class="container mt-4">
        @livewire('order-page', ['orderId' => $orderId])
    </div>
@endsection
