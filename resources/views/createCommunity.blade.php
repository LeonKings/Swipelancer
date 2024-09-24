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
                <div class="card mt-4 bg-info">
                    <div class="card-header text-white bg-primary" style="font-size: xx-large; text-align: center">{{ __('Join Our Community!') }}</div>

                    <div class="card-body" style="min-height:500px; max-height: 500px; overflow-y: auto; text-align: center;">
                        <form action="/community/create" method="POST">
                            @csrf
                            <div class="input-group ms-4" style="display: inline-block; text-align: left; width: 80%;">
                                <p class="mt-3" style="color: #3cb0e8">Community Name</p>
                                <input type="text" name="community_name" style="width: 100%" id="community_name" class="form-control" placeholder="Your community name" aria-label="Your community name" aria-describedby="button-addon2" required>
                                <p class="mt-3" style="color: #3cb0e8">Community Description</p>
                                <textarea name="community_desc" style="width: 100%; height: 150px;" id="community_desc" class="form-control" placeholder="Describe your community" aria-label="Describe your community" required></textarea>
                                <p class="mt-3" style="color: #3cb0e8">Community URL</p>
                                <input type="text" name="community_url" style="width: 100%" id="community_url" class="form-control" placeholder="Insert URL to your community" aria-label="Insert URL to your community" aria-describedby="button-addon2" required>
                                <button class="btn btn-primary mt-4" style="width: 100%" type="submit" id="button-addon2">Create</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    @if (session('success'))
        <div id="successModal" class="modal">
            <div class="modal-content">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

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
            background-color: rgba(0,0,0,0.4);
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

        .input-group {
            width: 100%; /* Ensure input group takes full width */
        }

        .input-group input,
        .input-group textarea,
        .input-group button {
            width: 100%; /* Ensure inputs and button take full width */
        }
    </style>
@endsection
