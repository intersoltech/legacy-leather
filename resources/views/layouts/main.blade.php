<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Legacy Leather Works')</title>

    {{-- Your theme CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

{{-- If you have theme header/navbar partials, they will load, warna ignore --}}
@includeIf('partials.header')
@includeIf('partials.navbar')

<main>
    @yield('content')
</main>

@includeIf('partials.footer')

</body>
</html>
