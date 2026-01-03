<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title','Admin') — Legacy Leather Works</title>
  <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
</head>
<body>

<div class="wrap">
  <aside class="sidebar">
    <div class="brand">
      <div class="logo">LLW</div>
      <div>
        <h2>Legacy Leather Works</h2>
        <p>Admin Console</p>
      </div>
    </div>

    <div class="navSec">
      <div class="navTitle">Overview</div>
      <div class="nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active':'' }}">
          Dashboard <span class="badge">Live</span>
        </a>
      </div>

      <div class="navTitle">Content</div>
      <div class="nav">
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active':'' }}">
          Products
        </a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active':'' }}">
          Categories
        </a>
        <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active':'' }}">
          Banners
        </a>
      </div>

      <div class="navTitle">Settings</div>
      <div class="nav">
        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active':'' }}">
          Site Settings
        </a>
        <a href="{{ route('admin.social-links.index') }}" class="{{ request()->routeIs('admin.social-links.*') ? 'active':'' }}">
          Social Links
        </a>
      </div>

      <div class="navTitle">Orders</div>
      <div class="nav">
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active':'' }}">
          All Orders
        </a>
      </div>

      <div class="navTitle">Users</div>
      <div class="nav">
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active':'' }}">
          Users Management
        </a>
      </div>

      <div class="navTitle">Quick</div>
      <div class="nav">
        <a href="{{ url('/') }}" target="_blank">View Website <span class="badge">Open</span></a>
      </div>
    </div>
  </aside>

  <main class="main">
    @yield('content')
  </main>
</div>

</body>
</html>
{{-- resources/views/auth/login.blade.php --}}