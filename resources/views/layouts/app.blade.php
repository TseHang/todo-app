<!DOCTYPE html>
<html lang="en">
<head>
    
    @include('includes.head')
    <title>Todo</title>
</head>
<body id="app-layout">
    <nav class="navbar">
        <div class="container">

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{{ url('/register') }}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</body>
</html>
