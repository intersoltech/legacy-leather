<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  {{-- Primary Meta Tags --}}
  <title>@yield('title', $siteSettings['site_name'] ?? 'Legacy Leather Works')</title>
  <meta name="title" content="@yield('meta_title', $siteSettings['site_name'] ?? 'Legacy Leather Works')">
  <meta name="description" content="@yield('meta_description', $siteSettings['footer_description'] ?? 'Premium leather goods crafted for an international lifestyle — timeless silhouettes, clean finishing, and luxury materials.')">
  <meta name="keywords" content="@yield('meta_keywords', 'leather goods, premium leather, leather bags, leather accessories, handmade leather, luxury leather, Legacy Leather Works')">
  <meta name="author" content="{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}">
  <meta name="robots" content="@yield('meta_robots', 'index, follow')">
  <meta name="language" content="English">
  <meta name="revisit-after" content="7 days">
  
  {{-- Canonical URL --}}
  <link rel="canonical" href="@yield('canonical_url', url()->current())">
  
  {{-- Open Graph / Facebook --}}
  <meta property="og:type" content="@yield('og_type', 'website')">
  <meta property="og:url" content="@yield('og_url', url()->current())">
  <meta property="og:title" content="@yield('og_title', $siteSettings['site_name'] ?? 'Legacy Leather Works')">
  <meta property="og:description" content="@yield('og_description', $siteSettings['footer_description'] ?? 'Premium leather goods crafted for an international lifestyle — timeless silhouettes, clean finishing, and luxury materials.')">
  <meta property="og:image" content="@yield('og_image', image_url($siteSettings['site_logo'] ?? null, asset('assets/img/logo.png')))">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}">
  <meta property="og:locale" content="en_US">
  
  {{-- Twitter Card --}}
  <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
  <meta name="twitter:url" content="@yield('og_url', url()->current())">
  <meta name="twitter:title" content="@yield('og_title', $siteSettings['site_name'] ?? 'Legacy Leather Works')">
  <meta name="twitter:description" content="@yield('og_description', $siteSettings['footer_description'] ?? 'Premium leather goods crafted for an international lifestyle — timeless silhouettes, clean finishing, and luxury materials.')">
  <meta name="twitter:image" content="@yield('og_image', image_url($siteSettings['site_logo'] ?? null, asset('assets/img/logo.png')))">
  
  {{-- Additional Meta Tags --}}
  <meta name="theme-color" content="#6B3F2A">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  
  {{-- Favicon --}}
  <link rel="icon" type="image/png" href="{{ image_url($siteSettings['site_logo'] ?? null, asset('assets/img/logo.png')) }}">
  <link rel="apple-touch-icon" href="{{ image_url($siteSettings['site_logo'] ?? null, asset('assets/img/logo.png')) }}">
  
  {{-- CSS Assets --}}
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  @stack('styles')

  {{-- Structured Data (JSON-LD) --}}
  @yield('structured_data')
  
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

