@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit User'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h5 class="mb-0"><i class="ni ni-single-02 me-2"></i>Edit User Details</h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control"
                                       placeholder="Enter full name" required>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control"
                                       placeholder="example@email.com" required>
                            </div>

                            {{-- Role --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">User Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Cashier</option>
                                </select>
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                    <i class="ni ni-bold-left"></i> Back
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ni ni-check-bold"></i> Update User
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-muted small text-center">
                        <i class="ni ni-lock-circle-open me-1"></i>
                        Password remains unchanged unless reset by admin.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
