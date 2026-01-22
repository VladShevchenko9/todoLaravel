@extends('layouts.bootstrap')

@section('pageTitle', 'Register')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

            <div class="card card-light shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h1 class="h4 mb-1">Create account</h1>
                        <div class="text-muted small">Fill in the details below</div>
                    </div>

                    <form method="POST" action="{{ route('store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required
                                autofocus
                            >
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                            >
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                            >
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input
                                type="hidden"
                                name="test"
                                value="test"
                            >
                            <label for="password_confirmation" class="form-label">Confirm password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            Register
                        </button>

                        <div class="text-center mt-4 small text-muted">
                            Already have an account?
                            <a href="{{ route('loginView') }}" class="text-decoration-none">
                                Sign in
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
