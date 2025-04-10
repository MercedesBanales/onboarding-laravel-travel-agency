<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @vite('resources/css/app.css')
    </head>
    <body class="flex justify-center items-center w-full h-full">
        <h1 class="text-3xl">404 Page Not Found</h1>
    </body>
</html>

