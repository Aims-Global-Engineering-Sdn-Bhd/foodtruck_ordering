@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])

    <div id="alert">
        @include('components.alert')
    </div>

    <div class="container-fluid py-4">

        <!-- Profile Header -->
        <div class="card shadow-lg mx-4 mb-4 border-0">
            <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded-circle me-3" style="font-size: 1.5rem;">
                        {{ strtoupper(substr(auth()->user()->firstname ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname ?? 'Firstname' }} {{ auth()->user()->lastname ?? 'Lastname' }}
                        </h5>
                        <p class="text-sm text-muted mb-0">{{ auth()->user()->email ?? 'user@email.com' }}</p>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <div class="card border-0 shadow-sm">
            <form role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0 fw-bold text-primary">Edit Profile</h6>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto px-3">Save Changes</button>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-uppercase text-sm text-muted">User Information</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control" type="text" name="username"
                                   value="{{ old('username', auth()->user()->username) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input class="form-control" type="email" name="email"
                                   value="{{ old('email', auth()->user()->email) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input class="form-control" type="text" name="firstname"
                                   value="{{ old('firstname', auth()->user()->firstname) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lastname"
                                   value="{{ old('lastname', auth()->user()->lastname) }}">
                        </div>
                    </div>

                    <hr class="horizontal dark my-3">

                    <p class="text-uppercase text-sm text-muted">Contact Information</p>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <input class="form-control" type="text" name="address"
                                   value="{{ old('address', auth()->user()->address) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <input class="form-control" type="text" name="city"
                                   value="{{ old('city', auth()->user()->city) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Country</label>
                            <input class="form-control" type="text" name="country"
                                   value="{{ old('country', auth()->user()->country) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Postal Code</label>
                            <input class="form-control" type="text" name="postal"
                                   value="{{ old('postal', auth()->user()->postal) }}">
                        </div>
                    </div>

                    <hr class="horizontal dark my-3">

                    <p class="text-uppercase text-sm text-muted">About</p>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">About Me</label>
                            <textarea class="form-control" name="about" rows="3">{{ old('about', auth()->user()->about) }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
