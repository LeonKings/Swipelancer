@extends('layouts.nav2')

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="flex-grow-1 d-flex justify-content-center">
                <h1 class="text-center my-2">{{ $jobs->project_name }}</h1>
            </div>
            <div style="width: 75px;"></div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <div class="card text-white bg-info col-md-6" style="max-width: 1500px;">
                <div class="card-body">
                    <form id="updateForm" action="{{ route('editJobPost') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employerID" value="{{ $employer->id }}">
                        <input type="hidden" name="userID" value="{{ $users->id }}">
                        <input type="hidden" name="jobID" value="{{ $jobs->id }}">

                        <div class="mx-2">
                            <h6 class="mt-3">Project Type</h6>
                            <div class="form-group">
                                <select class="form-select" id="project_type" name="project_type">
                                    <option value="WFO" {{ $jobs->project_type == 'WFO' ? 'selected' : '' }}>WFO</option>
                                    <option value="WFH" {{ $jobs->project_type == 'WFH' ? 'selected' : '' }}>WFH</option>
                                    <option value="Hybrid" {{ $jobs->project_type == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                            </div>
                        </div>

                        <div class="mx-2">
                            <h6 class="mt-3">Project Description</h6>
                            <textarea name="project_description" class="form-control @error('project_description') is-invalid @enderror" id="project_description" required rows="3">{{ old('project_description', $jobs->project_description) }}</textarea>
                            @error('project_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mx-2">
                            <h6 class="mt-3">Address</h6>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" required rows="3">{{ old('address', $jobs->address) }}</textarea>
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
                                    <select class="form-select" id="project_field" name="project_field" required>
                                        <option disabled selected></option>
                                        @foreach ($fields as $field)
                                            @if ($field->id != 11)
                                                <option value="{{ $field->id }}" {{ $jobs->project_field == $field->id ? 'selected' : '' }}>{{ $field->fields_of_work }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Project Section</h6>
                                <div class="form-group">
                                    <select class="form-select" id="project_section" name="project_section" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around align-items-center">
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Project Deadline</h6>
                                <input type="date" name="project_deadline" class="form-control @error('project_deadline') is-invalid @enderror" id="project_deadline" min="{{ \Carbon\Carbon::now()->toDateString() }}" value="{{ old('project_deadline', $jobs->project_deadline) }}">
                                @error('project_deadline')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Salary</h6>
                                <input type="number" name="salary" class="form-control @error('salary') is-invalid @enderror" id="salary" value="{{ old('salary', $jobs->salary) }}" pattern="\d*">
                                @error('salary')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Update successful!</p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadProjectSections(idField, selectedSectionId = null) {
                if (idField) {
                    $.ajax({
                        url: '/getSection/' + idField,
                        type: "GET",
                        data: {"_token": "{{ csrf_token() }}"},
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                $('#project_section').empty();
                                $('#project_section').append('<option disabled selected></option>');
                                $.each(data, function (key, section) {
                                    $('#project_section').append('<option value="' + section.id + '"' + (selectedSectionId == section.id ? ' selected' : '') + '>' + section.section + '</option>');
                                });
                            } else {
                                $('#project_section').empty();
                            }
                        }
                    });
                } else {
                    $('#project_section').empty();
                }
            }

            // Initial load
            var initialFieldId = $('#project_field').val();
            var initialSectionId = "{{ $jobs->project_section }}";
            loadProjectSections(initialFieldId, initialSectionId);

            // Change event
            $('#project_field').on('change', function () {
                var idField = $(this).val();
                loadProjectSections(idField);
            });

            // Handle form submission
            $('#updateForm').on('submit', function (event) {
                event.preventDefault(); // Prevent default form submission

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

                        // After 1 second, hide modal and redirect
                        setTimeout(function() {
                            successModal.style.display = 'none';
                            window.location.href = "{{ route('home') }}";
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
