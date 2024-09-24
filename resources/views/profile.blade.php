@extends('layouts.nav2')

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="flex-grow-1 d-flex justify-content-center">
                <h1 class="text-center my-2">Profile</h1>
            </div>
            <div style="width: 75px;"></div>
        </div>
    </div>
    @if ($users->role_id == 1)
        <div class="d-flex justify-content-center align-items-center">
            <div class="card text-white bg-info col-md-6" style="max-width: 1500px;">
                <div class="card-body">
                    <form action="/UpdateFreelancer/{{$users->id}}/{{$freelancer->id}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="mx-2">
                            <h6 class="mt-3">Profile Image</h6>
                            <img src="{{asset("storage/img/".$freelancer->freelancer_image_link)}}" style="width: 300px; height: 400px; object-fit: contain;"/>
                            <input class="form-control" type="file" id="freelancer_image_link" name="freelancer_image_link" value="{{ old('freelancer_image_link')}}">
                            @error('freelancer_image_link')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mx-2">
                            <h6 class="mt-3">Email</h6>
                            <input type="email" name="email" disabled="" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{$users->email}}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mx-2">
                            <h6 class="mt-3">Password</h6>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Min 8 characters" value="{{ old('password')}}">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mx-2">
                            <h6 class="mt-3">Confirm Password</h6>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Min 8 characters" value="{{ old('password_confirmation')}}">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-around align-items-center">
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Name</h6>
                                <input type="text" name="freelancer_name" class="form-control @error('freelancer_name') is-invalid @enderror" id="freelancer_name" placeholder="freelancer_name" required value="{{$freelancer->freelancer_name}}">
                                @error('freelancer_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Expected Salary Range (Rp)</h6>
                                <div class="d-flex justify-content-around align-items-center">
                                    <div>
                                        <input type="number" name="min_salary" class="form-control @error('min_salary') is-invalid @enderror" id="min_salary" required value="{{$freelancer->min_salary}}">
                                        @error('min_salary')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div>
                                        <h6>-</h6>
                                    </div>
                                    <div>
                                        <input type="number" name="max_salary" class="form-control @error('max_salary') is-invalid @enderror" id="max_salary" required value="{{$freelancer->max_salary}}">
                                        @error('max_salary')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around align-items-center">
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Last Study</h6>
                                <div class="form-group">
                                    <select class="form-select" id="last_study" name="last_study" fdprocessedid="adilsl" required>
                                        <option disabled></option>
                                        @foreach ($study as $s)
                                            @if ($freelancer->last_study == $s->last_study)
                                                <option for="last_study" selected value="{{$s->last_study}}">{{$s->last_study}}</option>
                                            @else
                                                <option for="last_study" value="{{$s->last_study}}">{{$s->last_study}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Section of Work (1)</h6>
                                <div class="form-group">
                                    <select class="form-select" id="section_1" name="section_1" fdprocessedid="adilsl" required>
                                        <option disabled></option>
                                        @foreach ($section as $s)
                                            @if ($freelancer->field_of_work == $s->fields_id)
                                                @if ($s->id == $freelancer->section_1)
                                                    <option for="section_1" selected value={{$s->id}}>{{$s->section}}</option>
                                                @else
                                                    <option for="section_1" value={{$s->id}}>{{$s->section}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around align-items-center">
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Field of Work</h6>
                                <div class="form-group">
                                    <select class="form-select" id="field_of_work" name="field_of_work" fdprocessedid="adilsl" required>
                                        <option disabled></option>
                                        @foreach ($field as $f)
                                            @if ($f->id != 11)
                                                @if ($f->id == $freelancer->field_of_work)
                                                    <option for="field_of_work" selected value={{$f->id}}>{{$f->fields_of_work}}</option>
                                                @else
                                                    <option for="field_of_work" value={{$f->id}}>{{$f->fields_of_work}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Section of Work (2)*</h6>
                                <div class="form-group">
                                    <select class="form-select" id="section_2" name="section_2" fdprocessedid="adilsl" required>
                                        @if ($freelancer->field_of_work == 0)
                                            <option selected for="section_2" value="70">-</option>
                                        @else
                                            <option for="section_2" value="70">-</option>
                                        @endif
                                        @foreach ($section as $s)
                                            @if ($freelancer->field_of_work == $s->fields_id)
                                                @if ($s->id == $freelancer->section_2)
                                                    <option for="section_2" selected value={{$s->id}}>{{$s->section}}</option>
                                                @else
                                                    <option for="section_2" value={{$s->id}}>{{$s->section}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around align-items-center">
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">CV</h6>
                                <div class="d-flex justify-content-around align-items-center">
                                    <input class="form-control" type="file" id="cv_link" name="cv_link" value="{{ old('cv_link')}}">
                                    @error('cv_link')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <a href="{{ url('/download', $freelancer->cv_link) }}">
                                        <img src="{{ asset('storage/icon/download.png') }}" style="width: 30px; height: 30px; object-fit: contain;" />
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Section of Work (3)*</h6>
                                <div class="form-group">
                                    <select class="form-select" id="section_3" name="section_3" fdprocessedid="adilsl" required>
                                        @if ($freelancer->field_of_work == 0)
                                            <option selected for="section_3" value="70">-</option>
                                        @else
                                            <option for="section_3" value="70">-</option>
                                        @endif
                                        @foreach ($section as $s)
                                            @if ($freelancer->field_of_work == $s->fields_id)
                                                @if ($s->id == $freelancer->section_3)
                                                    <option for="section_3" selected value={{$s->id}}>{{$s->section}}</option>
                                                @else
                                                    <option for="section_3" value={{$s->id}}>{{$s->section}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around align-items-center">
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Portfolio</h6>
                                <textarea name="portfolio" class="form-control @error('portfolio') is-invalid @enderror" id="portfolio" required value="{{$freelancer->portfolio}}" rows="3">{{$freelancer->portfolio}}</textarea>
                                @error('portfolio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-sm mx-2">
                                <h6 class="mt-3">Describe Yourselves</h6>
                                <textarea name="describe_yourselves" class="form-control @error('describe_yourselves') is-invalid @enderror" id="describe_yourselves" required value="{{$freelancer->describe_yourselves}}" rows="3">{{$freelancer->describe_yourselves}}</textarea>
                                @error('describe_yourselves')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <h6 class="mt-3">Subscription</h6>
                        <input type="text" name="plan" class="form-control @error('plan') is-invalid @enderror" id="plan" placeholder="Subscription" required value="{{$users->plan}}" readonly>
                        @error('plan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">Update</button>
                        </div>
                        <h6 class="mt-3 mx-2">*=Optional</h6>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center align-items-center">
            <div class="card text-white bg-info col-md-4" style="max-width: 1500px;">
                <div class="card-body">
                    <form method="POST" action="/UpdateEmployer/{{$users->id}}/{{$employer->id}}" enctype="multipart/form-data">
                        @csrf
                        <h6 class="mt-3">Profile Image</h6>
                        <img src="{{asset("/storage/img/".$employer->employer_image_link)}}" style="width: 300px; height: 400px; object-fit: contain; "/>
                        <input class="form-control" type="file" id="employer_image_link" name="employer_image_link" value="{{ old('employer_image_link')}}">
                        @error('employer_image_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Email</h6>
                        <input type="email" name="email" disabled="" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{$users->email}}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Password</h6>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Min 8 characters" value="{{ old('password')}}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Confirm Password</h6>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Min 8 characters" value="{{ old('password_confirmation')}}">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Person or Company Name</h6>
                        <input type="text" name="employer_name" class="form-control @error('employer_name') is-invalid @enderror" id="employer_name" placeholder="employer_name" required value="{{$employer->employer_name}}">
                        @error('employer_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Type</h6>
                        <div class="form-group">
                            <select class="form-select" id="employer_type" name="employer_type" fdprocessedid="adilsl" required>
                                <option disabled></option>
                                @if ($employer->employer_type == "Person")
                                    <option for="employer_type" selected value="Person">Person</option>
                                    <option for="employer_type" value="Company">Company</option>
                                @else
                                    <option for="employer_type" value="Person">Person</option>
                                    <option for="employer_type" selected value="Company">Company</option>
                                @endif
                            </select>
                        </div>
                        <h6 class="mt-3">Subscription</h6>
                        <input type="text" name="plan" class="form-control @error('plan') is-invalid @enderror" id="plan" placeholder="Subscription" required value="{{$users->plan}}" readonly>
                        @error('plan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
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
                    window.location.href = "/home";
                }, 1000); // 1 second delay
            @endif
        });

        $(document).ready(function () {
            $('#field_of_work').on('change', function () {
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
                                $('#section_1').empty();
                                $('#section_1').html('<option selected disabled></option>');
                                $.each(data, function(key, section){
                                    $('select[name="section_1"]').append('<option for="section_1" value="'+ section.id +'">' + section.section+ '</option>');
                                });
                                $('#section_2').empty();
                                $('#section_2').html('<option for="section_2" value="70">-</option>');
                                $.each(data, function(key, section){
                                    $('select[name="section_2"]').append('<option for="section_2" value="'+ section.id +'">' + section.section+ '</option>');
                                });
                                $('#section_3').empty();
                                $('#section_3').html('<option for="section_3" value="70">-</option>');
                                $.each(data, function(key, section){
                                    $('select[name="section_3"]').append('<option for="section_3" value="'+ section.id +'">' + section.section+ '</option>');
                                });
                            }else{
                                $('#section_1').empty();
                                $('#section_2').empty();
                                $('#section_3').empty();
                            }
                        }
                    });
                }else{
                    $('#section_1').empty();
                    $('#section_2').empty();
                    $('#section_3').empty();
                }
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
