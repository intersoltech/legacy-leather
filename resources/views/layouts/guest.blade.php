{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Legacy Leather Works') }}</title>

    {{-- ✅ NO VITE / NO NODE --}}
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <style>
        {!! file_get_contents(public_path('assets/inline-home.css')) ?? '' !!}
    </style>
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

</head>
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

<body>
<link rel="stylesheet" href="{{ asset('assets/auth.css') }}">


    <div class="min-h-screen">
        {{ $slot }}
    </div>
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

</body>
</html>
