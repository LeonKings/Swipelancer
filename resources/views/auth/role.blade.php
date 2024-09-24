@extends('layouts.nav1')

@section('content')

    <h1 class="text-center my-5">Sign Up as</h1>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card text-white bg-info col-md-4" style="max-width: 1500px;">
            <div class="card-body">
                    <form method="POST" action="/Register" enctype="multipart/form-data">
                        @csrf
                        <h5 class="mt-3">Sign Up as</h5>
                        <div class="form-group">
                            <select class="form-select" id="role_id" name="role_id" fdprocessedid="adilsl">
                                <option disabled selected></option>
                                <option for="role_id" value=1>Freelancer</option>
                                <option for="role_id" value=2>Employer</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="w-50 btn btn-lg btn-primary mt-4" formmethod="post" type="submit">Register</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

@endsection
