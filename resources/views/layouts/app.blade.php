<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.2/dist/semantic.min.css">
        <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.2/dist/semantic.min.js"></script>
        <!-- Scripts -->
        @vite(['resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
            <div class="ui container" id="app">

                <div class="row"></div>
                <div class="row"></div>

                <div class="row">
                    {{ $slot }}
                </div>
            </div>
    </body>
</html>
