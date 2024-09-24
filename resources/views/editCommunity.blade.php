@extends('layouts.nav2')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8 mb-100">
                <div class="card mt-4">
                    <div class="card-header bg-primary" style="font-size: xx-large; text-align: center; color: white">{{ __('Edit Community') }}</div>

                    <div class="card-body bg-info" style="min-height:500px; max-height: 500px; overflow-y: auto; text-align: center;">
                        <form action="/community/edit/{{$community->id}}" method="POST">
                            @csrf
                            <div class="input-group ms-4" style="display: inline-block; text-align: left">
                                <p class="mt-3" style="color: #3cb0e8">Community Name</p>
                                <input type="text" name="community_name" style="width: 60%" id="community_name" class="form-control" placeholder="Your community name" aria-label="Your community name" aria-describedby="button-addon2" required value="{{$community->community_name}}">
                                <p class="mt-3" style="color: #3cb0e8">Community Description</p>
                                <textarea name="community_desc" style="width: 60%; height: 150px;" id="community_desc" class="form-control" placeholder="Describe your community" aria-label="Describe your community" required>{{$community->community_desc}}</textarea>
                                <p class="mt-3" style="color: #3cb0e8">Community URL</p>
                                <input type="text" name="community_url" style="width: 60%" id="community_url" class="form-control" placeholder="Insert URL to your community" aria-label="Insert URL to your community" aria-describedby="button-addon2" required value="{{$community->community_url}}">
                                <button class="btn btn-primary mt-4" style="width: 60%" type="submit" id="button-addon2">Edit</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                var successModal = document.getElementById('successModal');
                successModal.style.display = 'block';
                setTimeout(function() {
                    successModal.style.display = 'none';
                    window.location.href = "/community/mine/{{ auth()->user()->id }}";
                }, 1000); // 1 second delay
            @endif
        });
    </script>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7); /* Darker background for the modal */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px; /* Increase the max-width for larger modal */
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
@endsection
