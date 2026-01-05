<div class="container nav">
    <a class="brand" href="{{ url('/') }}">
        <img class="brand-logo" src="{{ image_url($siteSettings['site_logo'] ?? null, 'assets/img/logo.png') }}"
            alt="{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}">
        <span class="brand-text">{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}</span>
    </a>

    <nav class="navlinks">
        <a href="{{ url('/shop') }}">SHOP</a>
        <a href="{{ url('/about') }}">ABOUT</a>
        <a href="{{ url('/policies') }}">SHIPPING</a>
        <a href="{{ url('/contact') }}">CONTACT</a>
    </nav>

    <div class="actions">
        <div class="search">
            <i class="bi bi-search"></i>
            <input id="topSearch" placeholder="Search (Enter)" />
            <div class="searchDrop" id="searchDrop"></div>
        </div>
        @auth
            <div style="position:relative;display:flex;gap:8px;align-items:center;">
                @if (auth()->user()->is_admin)
                    <a class="cartBtnTop" href="{{ route('admin.dashboard') }}"
                        style="display:inline-flex;align-items:center;gap:6px;">
                        <i class="bi bi-shield-check"></i>
                        <span>Admin</span>
                    </a>
                @else
                    <a class="cartBtnTop" href="{{ route('dashboard') }}"
                        style="display:inline-flex;align-items:center;gap:6px;">
                        <i class="bi bi-person"></i>
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0;">
                    @csrf
                    <button type="submit" class="cartBtnTop" style="display:inline-flex;align-items:center;gap:6px;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        @else
            <a class="cartBtnTop" href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        @endauth
        <a class="cartBtnTop" href="{{ url('/cart') }}" style="display:inline-flex;align-items:center;gap:6px;">
            <i class="bi bi-cart3"></i>
            <span>Cart</span>
            <span class="cartCount" data-cart-count>{{ $cartCount }}</span>
        </a>
    </div>
</div>
