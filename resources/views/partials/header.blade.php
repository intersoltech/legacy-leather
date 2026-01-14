<div class="container nav">
  <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
    <i class="bi bi-list"></i>
</button>
    <a class="brand" href="{{ url('/') }}">
        <img class="brand-logo" src="{{ image_url($siteSettings['site_logo'] ?? null, 'assets/img/logo.png') }}"
            alt="{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}">
        <span class="brand-text">{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}</span>
    </a>

    

    <nav class="navlinks" id="navlinks">
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
            <div class="dropdown">
                <button class="cartBtnTop dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-person"></i>
                    <span class="btn-text">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    @php
                        $isAdmin = auth()->user()->is_admin ?? false;
                    @endphp
                    @if($isAdmin)
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-shield-check"></i>
                                <span>Admin Dashboard</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a class="cartBtnTop" href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-box-arrow-in-right"></i>
                <span class="btn-text">Login</span>
            </a>
        @endauth
        <a class="cartBtnTop cart-btn" href="{{ url('/cart') }}" style="display:inline-flex;align-items:center;gap:6px;">
            <i class="bi bi-cart3"></i>
            <span class="btn-text">Cart</span>
            <span class="cartCount" data-cart-count>{{ $cartCount }}</span>
        </a>
    </div>
</div>

<style>
/* Mobile Menu Toggle Button */
.mobile-menu-toggle {
    display: none;
    background: #fff;
    border: 1px solid rgba(0,0,0,.12);
    border-radius: 8px;
    padding: 3px 12px;
    margin-left: 12px;
    cursor: pointer;
    color: #111;
    font-size: 20px;
    align-items: center;
    justify-content: center;
}

.mobile-menu-toggle:hover {
    filter: brightness(.98);
}

/* Responsive Styles */
@media (max-width: 1200px) {
    .search {
        display: none;
    }
}
@media (max-width: 980px) {
    .search {
        display: none;
    }
    
    .nav {
        grid-template-columns: auto 1fr auto;
        gap: 12px;
    }
    
    .brand-text {
        font-size: 14px;
        letter-spacing: .15em;
    }
    
    .brand-logo {
        height: 44px;
    }
    
    .navlinks {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        /* right: 0; */
        background: var(--brown);
        flex-direction: column;
        padding: 20px 18px;
        gap: 16px;
        border-top: 1px solid #5a3322;
        z-index: 100;
    }
    
    .navlinks.active {
        display: flex;
    }
    
    .navlinks a {
        padding: 12px 0;
        border-bottom: 1px solid rgba(255,255,255,.1);
        width: 100%;
    }
    
    .navlinks a:last-child {
        border-bottom: none;
    }
    
    .mobile-menu-toggle {
        display: flex;
    }
    
    .actions {
        gap: 8px;
    }
    
    .btn-text {
        display: none;
    }
    
    .cart-btn .btn-text {
        display: inline;
    }
    
    .auth-actions {
        display: flex;
        gap: 6px;
    }
    
    /* Bootstrap dropdown customization */
    .dropdown .dropdown-toggle::after {
        margin-left: 4px;
        font-size: 10px;
    }
    
    .dropdown-menu {
        border: 1px solid rgba(0,0,0,.12);
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
        min-width: 180px;
        padding: 8px 0;
    }
    
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        font-size: 14px;
    }
    
    .dropdown-item i {
        width: 18px;
        font-size: 16px;
        color: #666;
    }
    
    .dropdown-item:hover i,
    .dropdown-item:focus i {
        color: inherit;
    }
    
    .dropdown-item button {
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
}

@media (max-width: 640px) {
    .nav {
        padding: 10px 0;
    }
    
    .brand {
        gap: 8px;
    }
    
    .brand-text {
        font-size: 12px;
        letter-spacing: .12em;
    }
    
    .brand-logo {
        height: 36px;
    }
    
    .cartBtnTop {
        padding: 8px 10px;
        font-size: 11px;
    }
    
    .cartCount {
        font-size: 10px;
        padding: 2px 6px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 12px;
    }
    
    .brand-text {
        display: none;
    }
    
    .actions {
        gap: 6px;
    }
    
    .cart-btn .btn-text {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navlinks = document.getElementById('navlinks');
    
    if (mobileMenuToggle && navlinks) {
        mobileMenuToggle.addEventListener('click', function() {
            navlinks.classList.toggle('active');
            const icon = this.querySelector('i');
            if (navlinks.classList.contains('active')) {
                icon.classList.remove('bi-list');
                icon.classList.add('bi-x');
            } else {
                icon.classList.remove('bi-x');
                icon.classList.add('bi-list');
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuToggle.contains(event.target) && !navlinks.contains(event.target)) {
                navlinks.classList.remove('active');
                const icon = mobileMenuToggle.querySelector('i');
                icon.classList.remove('bi-x');
                icon.classList.add('bi-list');
            }
        });
        
        // Close menu when clicking a nav link
        navlinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                navlinks.classList.remove('active');
                const icon = mobileMenuToggle.querySelector('i');
                icon.classList.remove('bi-x');
                icon.classList.add('bi-list');
            });
        });
    }
    
});
</script>
