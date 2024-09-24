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
                    <span class="close" onclick="closeModal('successModal')">&times;</span>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8-mb-100">
                <div class="card mt-4 bg-info">
                    <div class="card-header text-white bg-primary" style="font-size: xx-large; text-align: center">{{ __('My Community') }}</div>
                    <div class="m-4 bg-info">
                        <form action="/community/mine/{id}/search" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search Community" aria-label="Search Community" aria-describedby="button-addon2">
                                <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </form>
                        <div class="card-body" style="display: inline-flex">
                            <a href="/community/create" style="width: 50%;"><button class="btn btn-primary me-2" style="font-size: large; width:100%; height: 100%" type="submit" id="button-addon2">Create Community</button></a>
                            <a href="/community/mine/{id}" style="width: 50%;"><button class="btn btn-primary ms-2" style="font-size: large; width:100%; height: 100%" type="submit" id="button-addon2">My Communities</button></a>
                        </div>
                    </div>

                    <div class="card-body bg-info" style="min-height:400px; max-height: 400px; overflow-y: auto; text-align: center">
                        @foreach($communities as $comm)
                            <div class="card p-4 m-2 border-dark" style="display: inline-block; width: 100%">
                                <div style="text-align: left;">
                                    <h3 style="color: #3cb0e8">{{$comm->community_name}}</h3>
                                    <h6 style="color: #3cb0e8">{{$comm->community_desc}}</h6>
                                    <h5 style="color: #3cb0e8">Link: <a href="{{$comm->community_url}}">{{$comm->community_url}}</a></h5>
                                </div>
                                <div style="display: flex; justify-content: flex-end;">
                                    <a href="/community/edit/{{$comm->id}}" class="btn btn-primary" style="margin-right: 10px;">Edit</a>
                                    <button class="btn btn-danger" type="button" onclick="showDeleteModal('{{ $comm->id }}', '{{ $comm->community_name }}')">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div id="deleteModalMessage" class="card-header text-white bg-primary" style="font-size: x-large; text-align: center; border-radius: 10px; padding:5px;"></div>
            <div class="button-container">
                <button id="confirmDelete" class="btnCon btn-danger">Yes</button>
                <button id="cancelDelete" class="btnCon btn-primary" onclick="closeDeleteModal()">No</button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <p>Community deleted successfully!</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                var successModal = document.getElementById('successModal');
                successModal.style.display = 'block';
                setTimeout(function() {
                    successModal.style.display = 'none';
                    location.reload(); // Refresh the page to see the changes
                }, 1000); // 1 second delay
            @endif
        });

        function showDeleteModal(communityId, communityName) {
            var deleteModal = document.getElementById('deleteModal');
            var deleteModalMessage = document.getElementById('deleteModalMessage');
            deleteModalMessage.textContent = `Are you sure you want to delete "${communityName}" community?`;
            deleteModal.style.display = 'block';

            document.getElementById('confirmDelete').onclick = function() {
                deleteCommunityConfirmed(communityId);
            };
        }

        function closeDeleteModal() {
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.style.display = 'none';
        }

        function deleteCommunityConfirmed(communityId) {
            $.ajax({
                url: '/community/delete/' + communityId,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    var successModal = document.getElementById('successModal');
                    successModal.querySelector('p').textContent = 'Community deleted successfully!';
                    successModal.style.display = 'block';
                    setTimeout(function() {
                        successModal.style.display = 'none';
                        location.reload(); // Refresh the page to see the changes
                    }, 1000); // 1 second delay
                },
                error: function(error) {
                    // console.error('Error deleting community:', error);
                    closeDeleteModal();
                }
            });
        }
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
            background-color: #333; /* Dark background for content */
            color: white; /* White text for better readability */
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            text-align: center;
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

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btnCon {
            width: 100px;
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-danger {
            background-color: red;
            color: white;
            border: none;
        }

        .btn-primary {
            background-color: blue;
            color: white;
            border: none;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
@endsection
