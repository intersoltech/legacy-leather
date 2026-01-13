<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title','Admin') — Legacy Leather Works</title>
  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  
  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  @stack('styles')
</head>
<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
      <img src="{{ image_url($siteSettings['site_logo'] ?? null, 'assets/img/logo.png') }}" alt="" style="width:40px;height:40px;border-radius:8px;">
      <span class="d-none d-lg-block">{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="GET" action="{{ route('admin.products.index') }}">
      <input type="text" name="search" placeholder="Search" title="Enter search keyword" value="{{ request('search') }}">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon-->

      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ image_url(auth()->user()->profile_photo_path ?? null, 'assets/img/logo.png') }}" alt="Profile" class="rounded-circle" style="width:32px;height:32px;object-fit:cover;">
          <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{ auth()->user()->name }}</h6>
            <span>{{ auth()->user()->is_admin ? 'Administrator' : 'Customer' }}</span>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ url('/') }}" target="_blank">
              <i class="bi bi-globe"></i>
              <span>View Website</span>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center" style="border:none;background:none;width:100%;text-align:left;padding:10px 16px;">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </button>
            </form>
          </li>
        </ul>
      </li><!-- End Profile Nav -->
    </ul>
  </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#content-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Content</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="content-nav" class="nav-content collapse {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.banners.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Products</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Categories</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Banners</span>
          </a>
        </li>
      </ul>
    </li><!-- End Content Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gear"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="settings-nav" class="nav-content collapse {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.social-links.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Site Settings</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.social-links.index') }}" class="{{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Social Links</span>
          </a>
        </li>
      </ul>
    </li><!-- End Settings Nav -->

    <li class="nav-heading">Orders</li>
    <li class="nav-item">
      <a class="nav-link collapsed {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
        <i class="bi bi-cart-check"></i>
        <span>All Orders</span>
      </a>
    </li><!-- End Orders Nav -->

    <li class="nav-heading">Users</li>
    <li class="nav-item">
      <a class="nav-link collapsed {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
        <i class="bi bi-people"></i>
        <span>Users Management</span>
      </a>
    </li><!-- End Users Nav -->
  </ul>
</aside><!-- End Sidebar-->

<main id="main" class="main">
  @yield('content')
</main>

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    Admin Panel
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  
  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  

@stack('scripts')
</body>
</html>
{{-- resources/views/auth/login.blade.php --}}