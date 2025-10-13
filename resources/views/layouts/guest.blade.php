<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Foodtruck Ordering System')</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Argon CSS -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    @stack('css')
    @livewireStyles
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

{{-- Simple guest navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('menu.list') }}">
            <span class="t-style">T</span> Kafe
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGuest"
                aria-controls="navbarGuest" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarGuest">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('menu.list') }}">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('guest.cart') }}">Cart</a></li>
            </ul>
        </div>
    </div>
</nav>

{{-- Page content --}}
<main class="container py-5">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-white text-center py-3 mt-auto shadow-sm">
    <small>© {{ date('Y') }} | Developed by Juqiey</small>
</footer>

<!-- Core JS Files -->
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>


@stack('js')
@livewireScripts

<!-- ✅ SweetAlert2 Toast Notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        // Reusable SweetAlert Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            customClass: {
                popup: 'shadow-lg rounded-3'
            },
        });

        // Success message (order placed)
        Livewire.on('order-placed', event => {
            Toast.fire({
                icon: 'success',
                title: event.message || 'Order placed successfully!'
            });
        });

        // Error message (missing input / empty cart)
        Livewire.on('cart-error', event => {
            Toast.fire({
                icon: 'error',
                title: event.message || 'Something went wrong.'
            });
        });

        Livewire.on('cart-added', event => {
            Toast.fire({
                icon: 'success',
                title: event.message || 'Item added to cart!'
            });
        });

        // When the customer pickup the food
        Livewire.on('order-updated', event => {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: event.message,
                timer: 2000,
                showConfirmButton: false,
            });
        });

    });
</script>
<style>
    .t-style {
        font-family: 'Georgia', serif;
        font-style: italic;
        font-weight: bold;
        font-size: 28px;
        background: linear-gradient(180deg, #d4af37 0%, #8b6b23 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
</body>
</html>
