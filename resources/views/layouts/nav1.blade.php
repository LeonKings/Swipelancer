<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Swipelancer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/cerulean/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Swipelancer</a>
            <div class="text-end">
                <a href="/role"><button class="btn btn-secondary my-2 my-sm-0" type="submit" fdprocessedid="t7hzgs">{{ __('Register') }}</button></a>
                <a href="{{ route('login') }}"><button class="btn btn-secondary my-2 my-sm-0" type="submit" fdprocessedid="t7hzgs">{{ __('Login') }}</button></a>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="mt-auto">
        <div style="position: relative; padding-bottom: 30px"></div>
    </footer>
</body>
</html>
