@extends('layouts.nav1')

@section('content')
<h1 class="text-center my-5">Confirm Password</h1>
<div class="d-flex justify-content-center align-items-center">
    <div class="card text-white bg-info col-md-4" style="max-width: 1500px;">
        <div class="card-body">
            <form method="POST" action="{{ route('password.confirm') }}" enctype="multipart/form-data">
                @csrf
                <h5 class="mt-3">Password</h5>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Min 8 characters" required value="{{ old('password')}}">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mt-3">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
                <div class="d-flex justify-content-center align-items-center" style="margin-bottom: 20px">
                    <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">{{ __('Confirm Password') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
