@extends('layouts.nav1')

@section('content')
    <?php $field_section = 0; ?>
    @if ($role_id == 1)
    <h1 class="text-center my-2">Sign Up as Freelancer</h1>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card text-white bg-info col-md-6" style="max-width: 1500px;">
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mx-2">
                        <h6 class="mt-3">Profile Image</h6>
                        <input class="form-control" type="file" id="freelancer_image_link" name="freelancer_image_link" required value="{{ old('freelancer_image_link')}}">
                        @error('freelancer_image_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mx-2">
                    <h6 class="mt-3">Email</h6>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email')}}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mx-2">
                        <h6 class="mt-3">Password</h6>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Min 8 characters" required value="{{ old('password')}}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mx-2">
                        <h6 class="mt-3">Confirm Password</h6>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Min 8 characters" required value="{{ old('password_confirmation')}}">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="col-sm mx-2">
                            <h6 class="mt-3">Name</h6>
                            <input type="text" name="freelancer_name" class="form-control @error('freelancer_name') is-invalid @enderror" id="freelancer_name" placeholder="freelancer_name" required value="{{ old('freelancer_name')}}">
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
                                    <input type="number" name="min_salary" class="form-control @error('min_salary') is-invalid @enderror" id="min_salary" required value="{{ old('min_salary')}}">
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
                                    <input type="number" name="max_salary" class="form-control @error('max_salary') is-invalid @enderror" id="max_salary" required value="{{ old('max_salary')}}">
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
                                    <option disabled selected></option>
                                    @foreach ($study as $s)
                                        <option for="last_study" value="{{$s->last_study}}">{{$s->last_study}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm mx-2">
                            <h6 class="mt-3">Section of Work (1)</h6>
                            <div class="form-group">
                                <select class="form-select" id="section_1" name="section_1" fdprocessedid="adilsl" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-around align-items-center">
                        <div class="col-sm mx-2">
                            <h6 class="mt-3">Field of Work</h6>
                            <div class="form-group">
                                <select class="form-select" id="field_of_work" name="field_of_work" fdprocessedid="adilsl" required>
                                    <option disabled selected></option>
                                    @foreach ($field as $f)
                                        @if($f->id != 11)
                                            <option for="field_of_work" value={{$f->id}}>{{$f->fields_of_work}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm mx-2">
                            <h6 class="mt-3">Section of Work (2)*</h6>
                            <div class="form-group">
                                <select class="form-select" id="section_2" name="section_2" fdprocessedid="adilsl" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-around align-items-center">
                        <div class="col-sm mx-2">
                            <h6 class="mt-3">CV</h6>
                            <input class="form-control" type="file" id="cv_link" name="cv_link" required value="{{ old('cv_link')}}">
                            @error('cv_link')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm mx-2">
                            <h6 class="mt-3">Section of Work (3)*</h6>
                            <div class="form-group">
                                <select class="form-select" id="section_3" name="section_3" fdprocessedid="adilsl" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-around align-items-center">
                        <div class="col-sm mx-2">
                            <h6 class="mt-3">Portfolio</h6>
                            <textarea name="portfolio" class="form-control @error('portfolio') is-invalid @enderror" id="portfolio" required value="{{ old('portfolio')}}" rows="3"></textarea>
                            @error('portfolio')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm mx-2">
                            <h6 class="mt-3">Describe Yourselves</h6>
                            <textarea name="describe_yourselves" class="form-control @error('describe_yourselves') is-invalid @enderror" id="describe_yourselves" required value="{{ old('describe_yourselves')}}" rows="3"></textarea>
                            @error('describe_yourselves')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="role_id" id="role_id" value=1>
                    <input type="hidden" name="plan" id="plan" value="Free">
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">Register</button>
                    </div>
                    <h6 class="mt-3 mx-2">*=Optional</h6>
                    </form>
                </div>
            </div>
        </div>
    @else
        <h1 class="text-center my-5">Sign Up as Employer</h1>
        <div class="d-flex justify-content-center align-items-center">
            <div class="card text-white bg-info col-md-4" style="max-width: 1500px;">
                <div class="card-body">
                    <form method="post" action="{{ route('register') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <h6 class="mt-3">Profile Image</h6>
                        <input class="form-control" type="file" id="employer_image_link" name="employer_image_link" required value="{{ old('employer_image_link')}}">
                        @error('employer_image_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Email</h6>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email')}}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Password</h6>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Min 8 characters" required value="{{ old('password')}}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Confirm Password</h6>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Min 8 characters" required value="{{ old('password_confirmation')}}">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <h6 class="mt-3">Person or Company</h6>
                        <div class="form-group">
                            <select class="form-select" id="employer_type" name="employer_type" fdprocessedid="adilsl" required>
                                <option disabled selected></option>
                                <option for="employer_type" value="Person">Person</option>
                                <option for="employer_type" value="Company">Company</option>
                            </select>
                        </div>
                        <h6 class="mt-3">Person or Company Name</h6>
                            <input type="text" name="employer_name" class="form-control @error('employer_name') is-invalid @enderror" id="employer_name" placeholder="employer_name" required value="{{ old('employer_name')}}">
                            @error('employer_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        <input type="hidden" name="role_id" id="role_id" value=2>
                        <input type="hidden" name="plan" id="plan" value="Free">
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <script>
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
                                $('#section_1').html('<option disabled selected></option>');
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
@endsection
