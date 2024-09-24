@extends('layouts.nav2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8-mb-100">
                <div class="card mt-4 bg-info">
                    <div class="card-header text-white bg-primary" style="font-size: xx-large; text-align: center">{{ __('Matches') }}</div>

                    <div class="card-body" style="min-height: 400px;">
                        <script>
                            // console.log("User Role ID: {{ $users->role_id }}");
                            // console.log("Matched Count: {{ isset($matched) ? count($matched) : 0 }}");
                            @if(isset($matched))
                                // console.log("Matched Data: ", @json($matched));
                            @endif
                        </script>

                        @if(isset($matched) && count($matched) > 0 && $users->role_id == 2)
                            <div class="list-group bg-info" style="max-height: 300px; overflow-y: auto;">
                                @foreach($matched as $match)
                                    <a href="/chat/{{$match->users_id}}" class="list-group-item list-group-item-action d-flex align-items-center" style="color: #3cb0e8">
                                        <img src="storage/img/{{ $match->freelancer_image_link }}" alt="{{ $match->freelancer_name }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                        {{ $match->freelancer_name }}
                                    </a>
                                @endforeach
                            </div>
                        @elseif(isset($matched) && count($matched) > 0 && $users->role_id == 1)
                            <div class="list-group bg-info" style="max-height: 300px; overflow-y: auto;">
                                @foreach($matched as $match)
                                    <a href="/chat/{{$match->users_id}}" class="list-group-item list-group-item-action d-flex align-items-center" style="color: #3cb0e8">
                                        <img src="storage/img/{{ $match->employer_image_link }}" alt="{{ $match->employer_name }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                        {{ $match->employer_name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p>No matches found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
