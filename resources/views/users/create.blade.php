@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add New User'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-gradient-primary text-white text-center py-3 rounded-top">
                        <h5 class="mb-0"><i class="ni ni-circle-08 me-2"></i>Create New User</h5>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            {{-- Full Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ni ni-single-02"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                                </div>
                            </div>

                            {{-- Username --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ni ni-circle-08"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ni ni-email-83"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                                </div>
                            </div>

                            {{-- Role --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Select Role</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ni ni-badge"></i></span>
                                    <select name="role" class="form-select" required>
                                        <option value="" selected disabled>-- Choose Role --</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                        <option value="cashier">Cashier</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="ni ni-bold-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ni ni-check-bold"></i> Create User
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-muted text-center small">
                        <i class="ni ni-single-copy-04"></i> User Management Module
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
