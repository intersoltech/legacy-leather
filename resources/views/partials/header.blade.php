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
            <div class="auth-actions">
                @if (auth()->user()->is_admin)
                    <a class="cartBtnTop" href="{{ route('admin.dashboard') }}"
                        style="display:inline-flex;align-items:center;gap:6px;">
                        <i class="bi bi-shield-check"></i>
                        <span class="btn-text">Admin</span>
                    </a>
                @else
                    <a class="cartBtnTop" href="{{ route('dashboard') }}"
                        style="display:inline-flex;align-items:center;gap:6px;">
                        <i class="bi bi-person"></i>
                        <span class="btn-text">{{ auth()->user()->name }}</span>
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0;">
                    @csrf
                    <button type="submit" class="cartBtnTop" style="display:inline-flex;align-items:center;gap:6px;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="btn-text">Logout</span>
                    </button>
                </form>
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
