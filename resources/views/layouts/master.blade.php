<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Legacy Leather Works')</title>

  {{-- CSS Assets --}}
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  @stack('styles')

  @yield('head')
</head>
<body>
  @php
    // Get cart count from database using cart_token cookie
    $cartCount = 0;
    if(request()->cookie('cart_token')) {
      $cart = \App\Models\Cart::where('token', request()->cookie('cart_token'))->first();
      if($cart) {
        $cartCount = (int)$cart->items()->sum('qty');
      }
    }
  @endphp

  <header>
    @include('partials.topbar')
    @include('partials.header')
  </header>

  <main>
    @yield('content')
  </main>

  @include('partials.footer')

  {{-- Scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
  @yield('scripts')
</body>
</html>

