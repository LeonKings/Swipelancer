@extends('layouts.nav1')

@section('content')
<h1 class="text-center my-5">{{ __('Reset Password') }}</h1>
<div class="d-flex justify-content-center align-items-center">
    <div class="card text-white bg-info col-md-4" style="max-width: 1500px;">
        <div class="card-body">
            <form method="POST" action="{{ route('password.email') }}" enctype="multipart/form-data">
                @csrf
                <h5 class="mt-3">Email</h5>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email')}}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="d-flex justify-content-center align-items-center">
                    <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">{{ __('Send Password Reset Link') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
