<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $attributes['title'] }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    @include ('components.layout.navigation')

    <main id="content" class="mb-5">
        <div class="container mt-5">
            {{ $slot }}
        </div>
    </main>

    @include ('components.layout.footer')

</body>

</html>
