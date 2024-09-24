@extends('layouts.nav1')

@section('content')
<h1 class="text-center my-5">Reset Password</h1>
<div class="d-flex justify-content-center align-items-center">
    <div class="card text-white bg-info col-md-4" style="max-width: 1500px;">
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <h5 class="mt-3">Email</h5>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ $email ?? old('email') }}">
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
                <h5 class="mt-3">Confirm Password</h5>
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Min 8 characters" required value="{{ old('password_confirmation')}}">
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="d-flex justify-content-center align-items-center" style="margin-bottom: 20px">
                    <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">{{ __('Reset Password') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
