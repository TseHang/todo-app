<!DOCTYPE html>
<html style = "height:100%;width:100%;margin:0px;">
<head>
    @include('includes.head')
    @yield('css')
    <title>Todoyo~  @yield('title')</title>
</head>
<body>
    <nav class="navbar ">
        @if (session('todoApp'))
            <a id="username" class="link" href="{{ url('/') }}">{{$username}}</a>
            <a class="link" href="{{ url('/logout') }}">Logout</a>
        @else
            <a class="link" href="{{ url('/') }}">Home</a>
            <a class="link" href="{{ url('/register') }}">Register</a>
        @endif
    </nav>

    @yield('content')
    @yield('js')
</body>
</html>
