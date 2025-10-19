@extends('layouts.app')

@section('content')
    <main class="main-content mt-0">
        <section class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-7">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Welcome to TKCafe</h2>
                            <p class="text-muted">Please sign in to continue</p>
                        </div>

                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-header pb-0 text-start bg-white border-0">
                                <h4 class="font-weight-bolder">Sign In</h4>
                                <p class="mb-0">Enter your email and password</p>
                            </div>

                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login.perform') }}">
                                    @csrf
                                    @method('post')

                                    <div class="mb-3">
                                        <input type="email" name="email"
                                               class="form-control form-control-lg"
                                               value=""
                                               placeholder="Email address"
                                               required>
                                        @error('email')
                                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <input type="password" name="password"
                                               class="form-control form-control-lg"
                                               placeholder="Password"
                                               value=""
                                               required>
                                        @error('password')
                                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="remember" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0">Sign in</button>
                                    </div>
                                </form>
                            </div>

                            <div class="card-footer text-center bg-white border-0 pt-0">
                                <p class="mb-1 text-sm mx-auto">
                                    Forgot your password?
                                    <a href="{{ route('reset-password') }}" class="text-primary text-gradient fw-bold">Reset here</a>
                                </p>
                                <p class="mb-0 text-sm mx-auto">
                                    Don't have an account?
                                    <a href="{{ route('register') }}" class="text-primary text-gradient fw-bold">Sign up</a>
                                </p>
                            </div>
                        </div>

                        <p class="text-center text-muted small mt-3">
                            &copy; {{ date('Y') }} TKCafe. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
