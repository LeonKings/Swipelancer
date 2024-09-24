@extends('layouts.nav1')

@section('content')
<div class="card m-4">
    <div class="mb-4" style="position: relative; height: 500px; overflow: hidden; border-radius: 10px;"> <!-- Adjusted height and added border-radius for better appearance -->
        <img src="{{ asset('storage/icon/welcome-img.jpg') }}" style="position: absolute; top: 50%; left: 50%; width: 100%; height: auto; transform: translate(-50%, -50%); filter: brightness(50%);" />
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center; padding: 20px;">
            <div class="text-center" style="font-weight: bold; font-size: 60px; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Welcome to <u>SWIPELANCER</u></div>
            <div style="font-weight: bold; font-size: 20px; margin-bottom: 30px; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">Get connected with your matching business partner.</div>
            <a style="text-decoration: none" href="{{ url('/role') }}">
                <button type="button" class="btn btn-primary btn-lg" style="font-weight: bold; text-transform: uppercase; letter-spacing: 1px;"><u>Sign Up Now</u></button>
            </a>
        </div>
    </div>
    <div class="mb-4" style="background-color:lightblue; position: relative; height: 500px; overflow: hidden; border-radius: 10px;"> <!-- Adjusted height and added border-radius for better appearance -->
        <img src="{{ asset('storage/icon/whyus.png') }}" style="position: absolute; top: 50%; left: 70%; width: 50%; height: auto; transform: translate(-50%, -50%); filter: brightness(100%);" />
        <div style="position: absolute; left: 30%; top: 50%; transform: translate(-50%, -50%); color: white; text-align: center; padding: 20px;">
            <div class="text-center" style="font-weight: bold; font-size: 60px; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Why Choose Us?</div>
            <div style="font-weight: bold; font-size: 20px; margin-bottom: 30px; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">
                <p>
                    ✅First Platform to Connect with Partners Privately.
                    <br/>
                    ✅Lesser Competitions.
                    <br/>
                    ✅Supportive recommendation algorithm to suit your expecations.
                    <br/>
                    ✅Swiping is fun!
                </p>
            </div>
            <a style="text-decoration: none" href="{{ url('/role') }}">
                <button type="button" class="btn btn-primary btn-lg" style="font-weight: bold; text-transform: uppercase; letter-spacing: 1px;"><u>Sign Up Now</u></button>
            </a>
        </div>
    </div>
</div>
@endsection
