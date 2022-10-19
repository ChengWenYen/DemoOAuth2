<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body class="hold-transition">

    @yield('content')

    @include('layouts.js')
    @yield('scripts')
</body>
</html>
