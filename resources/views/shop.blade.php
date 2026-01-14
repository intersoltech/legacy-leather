@extends('layouts.master')

@section('title', 'Shop • Legacy Leather Works')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
@endpush

@section('content')
<section class="bannerWrap">
  <div class="bannerFull">
    <div class="swiper bannerSwiper" id="bannerSwiper">
      <div class="swiper-wrapper">
        @foreach($banners ?? [] as $banner)
        <div class="swiper-slide">
            <img src="{{ image_url($banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}">
          <div class="bannerOverlay"></div>
            @if($banner->title || $banner->kicker || $banner->subtitle)
          <div class="bannerText">
                @if($banner->kicker)
                  <div class="bannerKicker">{{ $banner->kicker }}</div>
                @endif
                @if($banner->title)
                  <div class="bannerTitle">{{ $banner->title }}</div>
                @endif
                @if($banner->subtitle)
                  <div class="bannerSub">{{ $banner->subtitle }}</div>
                @endif
                @if($banner->button_text || $banner->button_link)
            <div class="bannerBtns">
                    @if($banner->button_text)
                      <button class="bBtn primary" data-banner-cat="{{ $banner->category_filter ?? 'all' }}" data-shop-base="{{ url('/shop') }}" type="button">{{ $banner->button_text }}</button>
                    @endif
              <button class="bBtn" data-banner-cat="all" data-shop-base="{{ url('/shop') }}" type="button">Shop All</button>
            </div>
                @endif
          </div>
            @endif
          </div>
        @endforeach
      </div>

      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev" aria-label="Previous"></div>
      <div class="swiper-button-next" aria-label="Next"></div>
    </div>
  </div>
</section>

<section class="controls">
  <div class="container">
    <div class="bar">
      <div class="leftControls">
        <div class="chipRow" id="catRow">
          @foreach($categories as $cat)
            <a class="chip {{ ($selectedCategory ?? 'all') === $cat->name ? 'active' : '' }}" 
               href="{{ url('/shop') }}{{ $cat->name !== 'all' ? '?cat=' . urlencode($cat->name) : '' }}" 
               data-cat="{{ $cat->name }}">
              {{ $cat->display_name ?? $cat->name }}
            </a>
          @endforeach
        </div>
      </div>

      <div class="rightControls">
        <div style="position:relative;display:inline-block;">
          <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#666;pointer-events:none;"></i>
          <input class="miniSearch" id="q" placeholder="Search products..." style="padding-left:36px;" />
        </div>
        <select class="select" id="sort" disabled>
          <option selected>Sort: Featured</option>
        </select>
        <button class="clearBtn" id="clearFilters" type="button">
          <i class="bi bi-x-circle"></i> Clear
        </button>
      </div>
    </div>
  </div>
</section>

<div class="productsGrid" id="grid">
  @foreach($products as $product)
  <div class="luxCard productCard" data-product-id="{{ $product->id }}" data-cat="{{ $product->category }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}"
    data-img="{{ image_url($product->image) }}"
    data-desc="{{ $product->description }}"
    data-href="{{ route('product.show', $product->id) }}">
    <div class="luxMedia"><img src="{{ image_url($product->image) }}" alt="{{ $product->name }}"></div>
    <div class="luxBody">
      <h3 class="luxTitle">{{ $product->name }}</h3>
      <p class="luxSub">{{ $product->description }}</p>
      <div class="luxRow">
        <span class="luxPrice">${{ number_format($product->price, 0) }}</span>
        <div class="luxActions">
          <a class="luxBtn" href="{{ route('product.show', $product->id) }}">
            <i class="bi bi-eye"></i> View
          </a>
          <button class="luxBtn primary addToCartBtn" type="button" 
                  data-product-id="{{ $product->id }}"
                  data-name="{{ $product->name }}"
                  data-price="{{ $product->price }}"
                  data-img="{{ image_url($product->image) }}">
            <i class="bi bi-cart-plus"></i> Add
          </button>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <div class="empty" id="shopEmptyMsg">
    <div style="font-family:var(--serif);letter-spacing:.14em;text-transform:uppercase;color:#2a1b14;font-size:16px;">
      No products found
    </div>
    <div style="margin-top:8px;">Try another search or category.</div>
  </div>
</div>

<div class="toast" id="toast">Added</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  function initBannerSwiper(){
    new Swiper("#bannerSwiper", {
      loop: true,
      autoplay: { delay: 3500, disableOnInteraction: false },
      pagination: { el: ".swiper-pagination", clickable: true },
      navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
      effect: "slide",
      speed: 700
    });

    document.querySelectorAll("[data-banner-cat]").forEach(btn=>{
      btn.addEventListener("click", ()=>{
        const cat = (btn.getAttribute("data-banner-cat") || "all").toLowerCase().trim();
        const base = btn.getAttribute("data-shop-base") || "{{ url('/shop') }}";
        if(cat === "all") window.location.href = base;
        else window.location.href = base + "?cat=" + encodeURIComponent(cat);
      });
    });
  }

  function getCatFromURL(){
    const u = new URL(window.location.href);
    return (u.searchParams.get("cat") || "all").toLowerCase().trim();
  }

  function setActiveChip(){
    const cat = getCatFromURL();
    document.querySelectorAll("#catRow .chip").forEach(ch=>{
      const c = (ch.dataset.cat || "").toLowerCase();
      ch.classList.toggle("active", c === cat);
    });
  }

  function applyFilters(){
    const grid = document.getElementById("grid");
    if(!grid) return;

    const cat = getCatFromURL();
    const qEl = document.getElementById("q");
    const query = (qEl?.value || "").toLowerCase().trim();

    const cards = grid.querySelectorAll(".luxCard.productCard");
    let shown = 0;

    cards.forEach(card=>{
      const title = (card.dataset.name || "").toLowerCase();
      const desc  = (card.dataset.desc || "").toLowerCase();
      const ccat  = (card.dataset.cat || "").toLowerCase();

      const catMatch = (cat === "all") || (ccat === cat);
      const searchMatch = !query || title.includes(query) || desc.includes(query);

      const show = catMatch && searchMatch;
      card.style.display = show ? "" : "none";
      if(show) shown++;
    });

    const empty = document.getElementById("shopEmptyMsg");
    if(empty){
      empty.style.display = shown ? "none" : "block";
    }
  }

  function debounce(fn, wait=150){
    let t; return (...args)=>{ clearTimeout(t); t=setTimeout(()=>fn(...args), wait); };
  }

  document.addEventListener("DOMContentLoaded", ()=>{
    initBannerSwiper();
    setActiveChip();
    applyFilters();

    const q = document.getElementById("q");
    const clearBtn = document.getElementById("clearFilters");
    const topSearch = document.getElementById("topSearch");

    q?.addEventListener("input", debounce(applyFilters, 120));

    if(topSearch){
      topSearch.addEventListener("keydown", (e)=>{
        if(e.key !== "Enter") return;
        const val = topSearch.value.trim();
        if(!val) return;
        q.value = val;
        applyFilters();
        window.scrollTo({ top: document.querySelector(".controls")?.offsetTop - 80 || 0, behavior:"smooth" });
      });
    }

    clearBtn?.addEventListener("click", ()=>{
      if(q) q.value = "";
      if(topSearch) topSearch.value = "";
      applyFilters();
    });
  });
</script>
<script src="{{ asset('assets/app.js') }}"></script>
<script>
// Add to cart functionality
document.addEventListener("click", async (e) => {
  const btn = e.target.closest(".addToCartBtn");
  if (!btn) return;

  e.preventDefault();
  const productId = btn.dataset.productId || btn.closest('[data-product-id]')?.dataset.productId || null;
  const name = btn.dataset.name || "Product";
  const price = parseFloat(btn.dataset.price || 0);
  const img = btn.dataset.img || "";

  // Disable button temporarily
  btn.disabled = true;
  const originalText = btn.innerHTML;
  btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Adding...';

  try {
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const response = await fetch("{{ route('cart.add') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": token,
        "Accept": "application/json",
      },
      body: JSON.stringify({ 
        product_id: productId ? parseInt(productId) : null,
        name, 
        price, 
        img, 
        qty: 1 
      })
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(errorText || 'Failed to add to cart');
    }

    const data = await response.json();
    
    // Update cart count
    document.querySelectorAll("[data-cart-count]").forEach(el => {
      el.textContent = data.count ?? 0;
    });

    // Show toast
    const toast = document.getElementById("toast");
    if (toast) {
      toast.textContent = "Added to cart!";
      toast.classList.add("show");
      setTimeout(() => toast.classList.remove("show"), 2000);
    }

    // Re-enable button
    btn.disabled = false;
    btn.innerHTML = originalText;
  } catch (error) {
    console.error("Add to cart error:", error);
    alert("Failed to add item to cart. Please try again.");
    btn.disabled = false;
    btn.innerHTML = originalText;
  }
});

// Load cart count on page load
document.addEventListener("DOMContentLoaded", async () => {
  try{
    const r = await fetch("{{ route('cart.count') }}", { headers: { "Accept":"application/json" }});
    const j = await r.json();
    document.querySelectorAll("[data-cart-count]").forEach(el => el.textContent = j.count ?? 0);
  }catch(e){}
});
</script>
@endpush
