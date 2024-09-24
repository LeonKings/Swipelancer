@extends('layouts.nav2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8-mb-100">
                <div class="card mt-4 bg-info">
                    <div class="card-header text-white bg-primary" style="font-size: xx-large; text-align: center">{{ __('Join Our Community!') }}</div>
                    <div class="m-4">
                        <form action="/community/search" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search Community" aria-label="Search Community" aria-describedby="button-addon2">
                                <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </form>
                        <div class="card-body" style="display: inline-flex">
                            <a href="/community/create" style="width: 50%;"><button class="btn btn-primary me-2" style="font-size: large; width:100%; height: 100%" type="submit" id="button-addon2">Create Communuity</button></a>
                            <a href="/community/mine/{id}" style="width: 50%;"><button class="btn btn-primary ms-2" style="font-size: large; width:100%; height: 100%" type="submit" id="button-addon2">My Communities</button></a>
                        </div>
                    </div>

                    <div class="card-body" style="min-height:400px; max-height: 400px; overflow-y: auto; text-align: center">
                        @foreach($communities as $comm)
                            <div class="card p-4 m-2 border-dark" style="text-align: left;">
                                <h3 style="color: #3cb0e8">{{$comm->community_name}}</h3>
                                <h6 style="color: #3cb0e8">{{$comm->community_desc}}</h6>
                                <h5 style="color: #3cb0e8">Link: <a href="{{$comm->community_url}}">{{$comm->community_url}}</a></h5>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
