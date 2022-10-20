<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body class="hold-transition">
    <div class="wrapper">
        @auth
            @include('layouts.navbar')
            @include('layouts.sidebar')
        @endauth
        @yield('content')
        @auth
            @include('layouts.footer')
        @endauth
    </div>
    @include('layouts.js')
    @yield('scripts')
</body>
</html>
