<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/cerulean/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Swipelancer</a>
            <div class="text-end">
                    <a href="{{ route('logout') }}"><button class="btn btn-secondary my-2 my-sm-0" type="submit" fdprocessedid="t7hzgs"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
            </div>
        </div>
    </nav>
    </nav>
    <h1 class="text-center my-5">Verify Your Email Address</h1>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card text-white bg-info col-md-4" style="max-width: 1500px;">
            <div class="card-body">
                @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not see the email') }},
                    {{ __('please check your spam email.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                    {{ __('If you open the email in your phone, please login first to verify') }}.
            </div>
        </div>
    </div>

    <footer class="mt-auto">
        <div style="position: relative; padding-bottom: 30px"></div>
    </footer>
</body>
</html>

