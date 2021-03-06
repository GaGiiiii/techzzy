<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/5c5689b7a2.js"></script>

    {{-- BOOTSTRAP --}}
    <link href="https://bootswatch.com/5/sandstone/bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{ $cssLink ?? '' }}

    <!-- OWL CAROUSEL -->
    {{ $owlCarouselCSS ?? '' }}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/global.js') }}" defer></script>
    {{ $jsLink ?? '' }}
</head>

<body class="font-sans antialiased">

    @include('layouts.navigation')

    <!-- Page Content -->
    <div class="container">
        <main>
            {{ $slot }}
        </main>
    </div>

    @include('layouts.footer')

    <!-- OWL CAROUSEL -->
    {{ $owlCarouselJS ?? '' }}

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>
