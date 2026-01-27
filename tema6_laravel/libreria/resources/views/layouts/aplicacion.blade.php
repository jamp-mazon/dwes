<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mi Web')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @include('layouts.menu')

    <main class="container">
        @yield('content')
    </main>

    {{-- @include('partials.footer') --}}

</body>
</html>