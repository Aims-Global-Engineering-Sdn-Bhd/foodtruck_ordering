@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Order Details'])
    <div class="container mt-4">
        @livewire('menu-quick-toggle')
    </div>
@endsection
