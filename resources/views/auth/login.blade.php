@extends('layouts.nav1')

@section('content')
<h1 class="text-center my-5">Login</h1>
<div class="d-flex justify-content-center align-items-center">
    <div class="card text-white bg-info col-md-4" style="max-width: 1500px;">
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                @csrf
                <h5 class="mt-3">Email</h5>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email')}}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <h5 class="mt-3">Password</h5>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Min 8 characters" required value="{{ old('password')}}">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <div class="mt-3">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">{{ __('Login') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>


@endsection
