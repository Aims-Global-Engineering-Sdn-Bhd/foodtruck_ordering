@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container mt-4">
        @livewire('order-receiver')
    </div>
@endsection
