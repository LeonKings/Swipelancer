@extends('layouts.nav2')

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="flex-grow-1 d-flex justify-content-center">
                <h1 class="text-center my-2">Add Job</h1>
            </div>
            <div style="width: 75px;"></div>
        </div>
        <?php $field_section = 0; ?>
        <div class="d-flex justify-content-center align-items-center">
            <div class="card text-white bg-info col-md-6" style="max-width: 1500px;">
                <div class="card-body">
                    <form id="addJobForm" action="{{ route('addJob') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="employerID" value="{{$employer->id}}">
                        <input type="hidden" name="userID" value="{{$users->id}}">
                        <input type="hidden" id="canAddJob" value="{{ $canAddJob }}">
                        @csrf
                        @if($canAddJob)
                            <!-- Form fields -->
                            <div class="d-flex justify-content-around align-items-center">
                                <div class="col-sm mx-2">
                                    <h6 class="mt-3">Project Name</h6>
                                    <input type="text" name="project_name" class="form-control @error('project_name') is-invalid @enderror" id="project_name" required value="{{ old('project_name')}}">
                                    @error('project_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm mx-2">
                                    <h6 class="mt-3">Project Type</h6>
                                    <div class="form-group">
                                        <select class="form-select" id="project_type" name="project_type" fdprocessedid="adilsl">
                                            <option for="project_type" value="WFO">WFO</option>
                                            <option for="project_type" value="WFH">WFH</option>
                                            <option for="project_type" value="Hybrid">Hybrid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-2">
                                <h6 class="mt-3">Project Description</h6>
                                <textarea name="project_description" class="form-control @error('project_description') is-invalid @enderror" id="project_description" required rows="3">{{ old('project_description')}}</textarea>
                                @error('project_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mx-2">
                                <h6 class="mt-3">Address</h6>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" required rows="3">{{ old('address')}}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-around align-items-center">
                                <div class="col-sm mx-2">
                                    <h6 class="mt-3">Project Fields</h6>
                                    <div class="form-group">
                                        <select class="form-select" id="project_field" name="project_field" fdprocessedid="adilsl" required>
                                            <option disabled selected></option>
                                            @foreach ($field as $f)
                                                @if ($f->id != 11)
                                                    <option for="project_field" value={{$f->id}}>{{$f->fields_of_work}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm mx-2">
                                    <h6 class="mt-3">Project Section</h6>
                                    <div class="form-group">
                                        <select class="form-select" id="project_section" name="project_section" fdprocessedid="adilsl" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around align-items-center">
                                <div class="col-sm mx-2">
                                    <h6 class="mt-3">Project Deadline</h6>
                                    <input type="date" name="project_deadline" class="form-control @error('project_deadline') is-invalid @enderror" id="project_deadline" min="{{ \Carbon\Carbon::now()->toDateString() }}" value="{{ old('project_deadline') }}">
                                    @error('project_deadline')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm mx-2">
                                    <h6 class="mt-3">Salary (Rp)</h6>
                                    <input type="number" name="salary" class="form-control @error('salary') is-invalid @enderror" id="salary" value="{{ old('salary') }}" pattern="\d*">
                                    @error('salary')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">Add</button>
                            </div>
                        @else
                            <div class="alert alert-warning text-center mt-3">
                                You have reached the job limit for your plan. Please upgrade your plan to add more jobs.
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <p>Job added successfully!</p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#project_field').on('change', function () {
                var idField = $(this).val();
                if(idField) {
                    $.ajax({
                        url: '/getSection/'+idField,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data)
                        {
                            if(data){
                                $('#project_section').empty();
                                $('#project_section').html('<option disabled selected></option>');
                                $.each(data, function(key, section){
                                    $('select[name="project_section"]').append('<option for="project_section" value="'+ section.id +'">' + section.section+ '</option>');
                                });

                                // Show success message
                                showSuccessMessage("Project sections loaded successfully!");
                            } else {
                                $('#project_section').empty();
                            }
                        },
                        error: function() {
                            // Show error message if needed
                            showErrorMessage("Failed to load project sections. Please try again later.");
                        }
                    });
                } else {
                    $('#project_section').empty();
                }
            });

            // Handle form submission
            $('#addJobForm').on('submit', function (event) {
                event.preventDefault(); // Prevent default form submission

                // Check if the user can add more jobs
                var canAddJob = $('#canAddJob').val() === '1';

                if (!canAddJob) {
                    alert("You have reached the job limit for your plan.");
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // Show success modal
                        var successModal = document.getElementById('successModal');
                        successModal.style.display = 'block';

                        // Disable user interaction
                        $('body').css('pointer-events', 'none');

                        // Close the modal after 1 second and redirect to home
                        setTimeout(function() {
                            successModal.style.display = 'none';
                            $('body').css('pointer-events', 'auto');
                            window.location.href = '/home'; // Change this to your home URL if different
                        }, 1000);
                    },
                    error: function (response) {
                        // Handle error
                        console.log('Error:', response);
                    }
                });
            });
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
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
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
    </style>
@endsection
