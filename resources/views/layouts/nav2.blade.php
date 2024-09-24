<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
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
            <a class="navbar-brand me-auto" href="/home">Swipelancer</a>
            <div class="d-flex ms-auto">
                <ul class="navbar-nav d-flex flex-row">
                    <li class="nav-item">
                        <a class="nav-link" href="/home">
                            <img src="{{asset('storage/icon/home.png')}}" style="width: 30px; height: 30px;">
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{asset('storage/icon/chat.png')}}" style="width: 30px; height: 30px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/chat">Chat</a></li>
                            @if($users->role_id == 1)
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/community">Community</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{asset('storage/icon/user.png')}}" style="width: 30px; height: 30px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/subscription">Subscription</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-item" id="dark-mode">
                                    Dark Mode
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="mt-auto">
        <div style="position: relative; padding-bottom: 30px"></div>
    </footer>
</body>
</html>

<style>
    .dropdown-toggle::after {
        display: none !important;
    }

    .dropdown-menu {
        background-color: white;
        border: 0.3px solid grey; /* Add border */
    }

    .dropdown-item {
        color: black;
    }

    #btnSwitch {
        display: flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
        cursor: pointer;
    }
</style>

<script>
    // Function to update the theme and button text
    function updateTheme(theme) {
        const button = document.getElementById('dark-mode');
        document.documentElement.setAttribute('data-bs-theme', theme);
        button.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
    }

    // Check for saved theme in localStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        updateTheme(savedTheme);
    }

    // Add event listener for theme toggle button
    document.getElementById('dark-mode').addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        updateTheme(newTheme);
        localStorage.setItem('theme', newTheme);  // Save the new theme to localStorage
    });
</script>
