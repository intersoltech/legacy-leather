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
    <div class="brand" style="display:flex;flex-direction:column;align-items:center;gap:4px;">
      <img class="brand-logo" src="{{ image_url($siteSettings['site_logo'] ?? null, 'assets/img/logo.png') }}"
            alt="{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}" style="width:44px;height:44px;border-radius:14px;">
      <p class="brand-text">{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}</p>
      <p class="brand-text-small">Admin Console</p>
      
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

      <div class="navTitle">Account</div>
      <div class="nav">
        <div style="padding:8px 12px;color:var(--muted);font-size:12px;">
          {{ auth()->user()->name }}
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
          @csrf
          <button type="submit" style="width:100%;text-align:left;padding:8px 12px;border:none;background:none;color:inherit;cursor:pointer;font-size:13px;display:flex;align-items:center;gap:8px;border-radius:8px;transition:background .2s;" onmouseover="this.style.background='rgba(0,0,0,.05)'" onmouseout="this.style.background='none'">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
          </button>
        </form>
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