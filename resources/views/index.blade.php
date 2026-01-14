@extends('layouts.master')

@section('title', 'Legacy Leather Works')

@section('meta_description', 'Premium leather goods crafted for an international lifestyle. Shop timeless silhouettes, clean finishing, and luxury materials at Legacy Leather Works.')

@section('og_title', 'Legacy Leather Works - Premium Leather Goods')
@section('og_description', 'Premium leather goods crafted for an international lifestyle. Shop timeless silhouettes, clean finishing, and luxury materials.')
@section('og_image', asset('assets/img/logo.png'))
@section('og_type', 'website')

@section('structured_data')
@php
$socialUrls = [];
if (isset($socialLinks) && $socialLinks->isNotEmpty()) {
    foreach ($socialLinks as $link) {
        $socialUrls[] = $link->url;
    }
}
$sameAsJson = '';
if (!empty($socialUrls)) {
    $quotedUrls = [];
    foreach ($socialUrls as $url) {
        $quotedUrls[] = '"' . addslashes($url) . '"';
    }
    $sameAsJson = ',"sameAs":[' . implode(',', $quotedUrls) . ']';
}
@endphp
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "name": "{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}",
  "url": "{{ url('/') }}",
  "logo": "{{ image_url($siteSettings['site_logo'] ?? null, asset('assets/img/logo.png')) }}",
  "description": "{{ $siteSettings['footer_description'] ?? 'Premium leather goods crafted for an international lifestyle — timeless silhouettes, clean finishing, and luxury materials.' }}",
  "contactPoint": {
    "@@type": "ContactPoint",
    "telephone": "{{ $siteSettings['whatsapp_number'] ?? '' }}",
    "contactType": "Customer Service",
    "email": "{{ $siteSettings['email'] ?? '' }}"
  }{!! $sameAsJson !!}
}
</script>
@endsection

@section('content')
    <section class="heroBanner" id="heroBanner">
        <div class="heroImgTrack" id="heroImgTrack">
            <img class="hero-img" src="{{ asset('assets/img/banner.png') }}" alt="Legacy Leather Works Banner 1">
            <img class="hero-img" src="{{ asset('assets/img/esha.jpg') }}" alt="Legacy Leather Works Banner 1">
            <img class="hero-img" src="{{ asset('assets/img/1.jpg') }}" alt="Legacy Leather Works Banner 2">
            <img class="hero-img" src="{{ asset('assets/img/banner3.png') }}" alt="Legacy Leather Works Banner 3">
            <img class="hero-img" src="{{ asset('assets/img/banner.png') }}" alt="Legacy Leather Works Banner 1">
            <img class="hero-img" src="{{ asset('assets/img/1.jpg') }}" alt="Legacy Leather Works Banner 2">
            <img class="hero-img" src="{{ asset('assets/img/banner3.png') }}" alt="Legacy Leather Works Banner 3">
        </div>

        <button class="heroImgArrow left" id="heroImgPrev" aria-label="Previous">‹</button>
        <button class="heroImgArrow right" id="heroImgNext" aria-label="Next">›</button>
        <div class="heroImgDots" id="heroImgDots"></div>
    </section>

    <section class="section">
        <div class="luxSectionHead">
            <h2>OUR PRODUCTS</h2>
        </div>

        <div class="sliderWrap">
            <button class="arrow left" id="prevBtn" aria-label="Previous">‹</button>
            <button class="arrow right" id="nextBtn" aria-label="Next">›</button>

            <div class="sliderViewport">
                <div class="sliderTrack" id="track">

                    {{-- ✅ CARD 1 --}}
                    @php($p1 = ['name' => 'Classic Black Jacket', 'price' => 149, 'img' => asset('assets/img/aq.jpeg'), 'tag' => 'Bestseller'])
                    <div class="cardPro productCard" data-name="{{ $p1['name'] }}" data-price="{{ $p1['price'] }}"
                        data-img="{{ $p1['img'] }}">
                        <div class="cardMedia">
                            <img src="{{ $p1['img'] }}" alt="{{ $p1['name'] }}">
                            <span class="tag">{{ $p1['tag'] }}</span>
                        </div>
                        <div class="cardBody">
                            <div class="cardTop">
                                <h3>{{ $p1['name'] }}</h3>
                                <span class="price">${{ $p1['price'] }}</span>
                            </div>
                            <p class="sub">Genuine leather • Premium stitching</p>

                            <div class="cardActions">
                                <button class="pillMini viewBtn" type="button">
                                    <i class="bi bi-eye"></i> View
                                </button>

                                {{-- ✅ REAL DB Add to Cart (POST) --}}
                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $p1['name'] }}">
                                    <input type="hidden" name="price" value="{{ $p1['price'] }}">
                                    <input type="hidden" name="img" value="{{ $p1['img'] }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button class="pillMini addCartBtn" type="submit">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ✅ CARD 2 --}}
                    @php($p2 = ['name' => 'Women Cropped Jacket', 'price' => 170, 'img' => asset('assets/img/j.jpg'), 'tag' => 'Women'])
                    <div class="cardPro productCard" data-name="{{ $p2['name'] }}" data-price="{{ $p2['price'] }}"
                        data-img="{{ $p2['img'] }}">
                        <div class="cardMedia">
                            <img src="{{ $p2['img'] }}" alt="{{ $p2['name'] }}">
                            <span class="tag">{{ $p2['tag'] }}</span>
                        </div>
                        <div class="cardBody">
                            <div class="cardTop">
                                <h3>{{ $p2['name'] }}</h3>
                                <span class="price">${{ $p2['price'] }}</span>
                            </div>
                            <p class="sub">Modern cut • Soft leather</p>
                            <div class="cardActions">
                                <button class="pillMini viewBtn" type="button">
                                    <i class="bi bi-eye"></i> View
                                </button>

                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $p2['name'] }}">
                                    <input type="hidden" name="price" value="{{ $p2['price'] }}">
                                    <input type="hidden" name="img" value="{{ $p2['img'] }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button class="pillMini addCartBtn" type="submit">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ✅ CARD 3 --}}
                    @php($p3 = ['name' => 'Tan Racer Jacket', 'price' => 200, 'img' => asset('assets/img/M4.jpg'), 'tag' => 'Limited'])
                    <div class="cardPro productCard" data-name="{{ $p3['name'] }}" data-price="{{ $p3['price'] }}"
                        data-img="{{ $p3['img'] }}">
                        <div class="cardMedia">
                            <img src="{{ $p3['img'] }}" alt="{{ $p3['name'] }}">
                            <span class="tag">{{ $p3['tag'] }}</span>
                        </div>
                        <div class="cardBody">
                            <div class="cardTop">
                                <h3>{{ $p3['name'] }}</h3>
                                <span class="price">${{ $p3['price'] }}</span>
                            </div>
                            <p class="sub">Sleek racer style • Tan leather</p>
                            <div class="cardActions">
                                <button class="pillMini viewBtn" type="button">
                                    <i class="bi bi-eye"></i> View
                                </button>

                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $p3['name'] }}">
                                    <input type="hidden" name="price" value="{{ $p3['price'] }}">
                                    <input type="hidden" name="img" value="{{ $p3['img'] }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button class="pillMini addCartBtn" type="submit">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ✅ CARD 4 --}}
                    @php($p4 = ['name' => 'Leather Blazer', 'price' => 250, 'img' => asset('assets/img/M2.jpg'), 'tag' => 'Blazer'])
                    <div class="cardPro productCard" data-name="{{ $p4['name'] }}" data-price="{{ $p4['price'] }}"
                        data-img="{{ $p4['img'] }}">
                        <div class="cardMedia">
                            <img src="{{ $p4['img'] }}" alt="{{ $p4['name'] }}">
                            <span class="tag">{{ $p4['tag'] }}</span>
                        </div>
                        <div class="cardBody">
                            <div class="cardTop">
                                <h3>{{ $p4['name'] }}</h3>
                                <span class="price">${{ $p4['price'] }}</span>
                            </div>
                            <p class="sub">Formal look • Office-ready</p>
                            <div class="cardActions">
                                <button class="pillMini viewBtn" type="button">
                                    <i class="bi bi-eye"></i> View
                                </button>

                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $p4['name'] }}">
                                    <input type="hidden" name="price" value="{{ $p4['price'] }}">
                                    <input type="hidden" name="img" value="{{ $p4['img'] }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button class="pillMini addCartBtn" type="submit">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="dots" id="dots"></div>
        </div>
    </section>

    <div class="cartOverlay" id="cartOverlay"></div>

    <div class="cartDrawer" id="cartDrawer" aria-hidden="true">
        <div class="cartHeader">
            <h3>Added to Cart</h3>
            <button class="cartClose" id="closeCart" aria-label="Close" type="button">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="cartBody2">
            <div class="addedRow">
                <img id="drawerImg" src="{{ asset('assets/img/aq.jpeg') }}" alt="Product">
                <div class="addedInfo">
                    <h4 id="drawerName">Product</h4>
                    <p id="drawerPrice">$0</p>
                    <div class="addedMeta">
                        <span class="metaPill">Premium Leather</span>
                        <span class="metaPill">Luxury Finish</span>
                    </div>
                </div>
            </div>

            <div class="qtyRow">
                <span>Quantity</span>
                <div class="qtyCtrl">
                    <button class="qBtn" id="qtyMinus" type="button">
                        <i class="bi bi-dash"></i>
                    </button>
                    <div class="qNum" id="qtyNum">1</div>
                    <button class="qBtn" id="qtyPlus" type="button">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="cartFooter2">
            <div class="totalRow">
                <div>Total</div>
                <strong id="drawerTotal">$0</strong>
            </div>
            <button class="btnPrimary" id="goCheckout" type="button">Checkout</button>
            <button class="btnGhost" id="keepShopping" type="button">Keep Shopping</button>
        </div>
    </div>

    <section class="section">
        <div class="luxSectionHead">
            <h2>CATEGORIES</h2>
        </div>
        <div class="splitHero">
            <a class="heroCard" href="{{ route('shop', ['cat' => 'women']) }}">
                <img class="heroImg" src="{{ asset('assets/img/b1.jpg') }}" alt="Outerwear">
                <div class="heroShade"></div>
                <div class="heroContent">
                    <div class="heroMini">Legacy Leather Works</div>
                    <h2 class="heroTitle">WOMEN's WEAR</h2>
                    <p class="heroDesc">Thoughtfully designed to embrace the season in style.</p>
                    <span class="heroBtn">Explore Now</span>
                </div>
            </a>

            <a class="heroCard" href="{{ route('shop', ['cat' => 'men']) }}">
                <img class="heroImg" src="{{ asset('assets/img/M5.jpg') }}" alt="Cable Shop">
                <div class="heroShade"></div>
                <div class="heroContent">
                    <div class="heroMini">Legacy Leather Goods</div>
                    <h2 class="heroTitle">MEN's WEAR</h2>
                    <p class="heroDesc">Soft fabrics and iconic silhouettes crafted for timeless wear.</p>
                    <span class="heroBtn">Shop Now</span>
                </div>
            </a>
        </div>
    </section>

    <section class="luxTiles">
        <div class="luxSectionHead">
            <h2>OUR COLLECTION</h2>
        </div>

        <div class="luxGrid">
            <a class="luxTile" href="{{ route('shop', ['cat' => 'table runner']) }}">
                <img class="luxImg" src="{{ asset('assets/img/P1.jpg') }}" alt="Luxury Collection">
                <div class="luxShade"></div>
                <div class="luxText">
                    <div class="luxKicker">Legacy Leather Goods Collection</div>
                    <h3 class="luxTitle">Table Runner</h3>
                    <div class="luxCta">Shop Now</div>
                </div>
            </a>

            <a class="luxTile" href="{{ route('shop', ['cat' => 'wallet']) }}">
                <img class="luxImg" src="{{ asset('assets/img/P2.jpg') }}" alt="Luxury Men">
                <div class="luxShade"></div>
                <div class="luxText">
                    <div class="luxKicker">Legacy Leather Goods</div>
                    <h3 class="luxTitle">Wallet for Men</h3>
                    <div class="luxCta">Shop Now</div>
                </div>
            </a>

            <a class="luxTile" href="{{ route('shop', ['cat' => 'office accessories']) }}">
                <img class="luxImg" src="{{ asset('assets/img/P3.jpg') }}" alt="Luxury Home">
                <div class="luxShade"></div>
                <div class="luxText">
                    <div class="luxKicker">Legacy Leather Goods</div>
                    <h3 class="luxTitle">Leather File</h3>
                    <div class="luxCta">Shop Now</div>
                </div>
            </a>

            <a class="luxTile" href="{{ route('shop', ['cat' => 'key chains']) }}">
                <img class="luxImg" src="{{ asset('assets/img/P4.jpg') }}" alt="Luxury Collection">
                <div class="luxShade"></div>
                <div class="luxText">
                    <div class="luxKicker">Legacy Leather Goods</div>
                    <h3 class="luxTitle">Key Chains</h3>
                    <div class="luxCta">Shop Now</div>
                </div>
            </a>

            <a class="luxTile" href="{{ route('shop', ['cat' => 'wallet']) }}">
                <img class="luxImg" src="{{ asset('assets/img/P6.jpg') }}" alt="Luxury Collection">
                <div class="luxShade"></div>
                <div class="luxText">
                    <div class="luxKicker">Legacy Leather Goods</div>
                    <h3 class="luxTitle">Wallet for Women</h3>
                    <div class="luxCta">Shop Now</div>
                </div>
            </a>

            <a class="luxTile" href="{{ route('shop', ['cat' => 'office accessories']) }}">
                <img class="luxImg" src="{{ asset('assets/img/Elegant leather office essentials display.png') }}"
                    alt="Luxury Collection">
                <div class="luxShade"></div>
                <div class="luxText">
                    <div class="luxKicker">Legacy Leather Goods</div>
                    <h3 class="luxTitle">Office Accessories</h3>
                    <div class="luxCta">Shop Now</div>
                </div>
            </a>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/app.js') }}"></script>
    <script>
        function llwToast(msg) {
            const t = document.getElementById("fToast");
            if (t) {
                t.textContent = msg;
                t.classList.add("show");
                setTimeout(() => t.classList.remove("show"), 2200);
            }
        }

        /* ===== Search dropdown ===== */
        function initSearch() {
            const input = document.getElementById("topSearch");
            const drop = document.getElementById("searchDrop");
            if (!input || !drop) return;

            const cards = Array.from(document.querySelectorAll(".productCard"));
            const products = cards.map((card, idx) => {
                const img = card.querySelector("img")?.getAttribute("src") || "";
                const name = card.querySelector(".cardTop h3")?.textContent?.trim() || "Product";
                const price = card.querySelector(".price")?.textContent?.trim() || "";
                const href = "{{ route('shop') }}";
                return {
                    id: idx + 1,
                    name,
                    price,
                    img,
                    href,
                    cat: "Leather"
                };
            });

            function closeDrop() {
                drop.classList.remove("show");
                drop.innerHTML = "";
            }

            function render(list) {
                if (!list.length) {
                    drop.innerHTML = `<div class="searchEmpty">No results found.</div>`;
                    drop.classList.add("show");
                    return;
                }

                drop.innerHTML = list.slice(0, 6).map(p => `
        <a class="searchItem" href="${p.href}?search=${encodeURIComponent(p.name)}">
          <img class="sThumb" src="${p.img}" alt="${p.name}">
          <div class="sMeta">
            <div class="sName">${p.name}</div>
            <div class="sCat">${p.cat}</div>
          </div>
          <div class="sPrice">${p.price}</div>
        </a>
      `).join("");

                drop.classList.add("show");
            }

            input.addEventListener("input", () => {
                const q = input.value.trim().toLowerCase();
                if (q.length < 1) {
                    closeDrop();
                    return;
                }

                const filtered = products.filter(p => p.name.toLowerCase().includes(q));
                render(filtered);
            });

            input.addEventListener("keydown", (e) => {
                if (e.key === "Enter") {
                    const q = input.value.trim();
                    if (!q) return;
                    window.location.href = `{{ route('shop') }}?search=${encodeURIComponent(q)}`;
                }
                if (e.key === "Escape") {
                    closeDrop();
                }
            });

            document.addEventListener("click", (e) => {
                if (!drop.contains(e.target) && e.target !== input) {
                    closeDrop();
                }
            });
        }

        /* ===== HERO IMAGE SWIPER ===== */
        function initHeroImageSwiper() {
            const banner = document.getElementById("heroBanner");
            const track = document.getElementById("heroImgTrack");
            const dotsEl = document.getElementById("heroImgDots");
            const prev = document.getElementById("heroImgPrev");
            const next = document.getElementById("heroImgNext");

            if (!banner || !track || !dotsEl || !prev || !next) return;

            const slides = Array.from(track.querySelectorAll("img"));
            let i = 0;
            let timer = null;

            function buildDots() {
                dotsEl.innerHTML = "";
                slides.forEach((_, idx) => {
                    const d = document.createElement("div");
                    d.className = "heroImgDot" + (idx === i ? " active" : "");
                    d.addEventListener("click", () => {
                        i = idx;
                        update();
                        restart();
                    });
                    dotsEl.appendChild(d);
                });
            }

            function update() {
                i = (i + slides.length) % slides.length;
                track.style.transform = `translateX(${-i*100}%)`;
                Array.from(dotsEl.children).forEach((d, idx) => d.classList.toggle("active", idx === i));
            }

            function restart() {
                clearInterval(timer);
                timer = setInterval(() => {
                    i++;
                    update();
                }, 4500);
            }

            prev.addEventListener("click", () => {
                i--;
                update();
                restart();
            });
            next.addEventListener("click", () => {
                i++;
                update();
                restart();
            });

            let startX = 0,
                dragging = false;
            banner.addEventListener("touchstart", (e) => {
                dragging = true;
                startX = e.touches[0].clientX;
            }, {
                passive: true
            });
            banner.addEventListener("touchend", (e) => {
                if (!dragging) return;
                const endX = e.changedTouches[0].clientX;
                const diff = endX - startX;
                if (diff > 40) i--;
                if (diff < -40) i++;
                dragging = false;
                update();
                restart();
            });

            banner.addEventListener("mouseenter", () => clearInterval(timer));
            banner.addEventListener("mouseleave", restart);

            buildDots();
            update();
            restart();
        }

        /* ===== Featured Swiper ===== */
        function initFeaturedSwiper() {
            const track = document.getElementById("track");
            const dotsEl = document.getElementById("dots");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");

            if (!track || !dotsEl || !prevBtn || !nextBtn) return;

            const root = track.closest(".sliderWrap");
            const cards = Array.from(track.children);
            let index = 0;
            let timer = null;

            function perView() {
                const w = window.innerWidth;
                if (w < 700) return 1;
                if (w < 1000) return 2;
                return 4;
            }

            function maxIndex() {
                return Math.max(0, cards.length - perView());
            }

            function buildDots() {
                dotsEl.innerHTML = "";
                const pages = maxIndex() + 1;
                for (let i = 0; i < pages; i++) {
                    const d = document.createElement("div");
                    d.className = "dot" + (i === index ? " active" : "");
                    d.addEventListener("click", () => {
                        index = i;
                        update();
                        restart();
                    });
                    dotsEl.appendChild(d);
                }
            }

            function update() {
                index = Math.max(0, Math.min(maxIndex(), index));
                const cardWidth = cards[0].getBoundingClientRect().width;
                const gap = 16;
                const x = (cardWidth + gap) * index;
                track.style.transform = `translateX(${-x}px)`;

                Array.from(dotsEl.children).forEach((d, i) => d.classList.toggle("active", i === index));
            }

            function restart() {
                clearInterval(timer);
                timer = setInterval(() => {
                    index++;
                    update();
                }, 4000);
            }

            prevBtn.addEventListener("click", () => {
                index--;
                update();
                restart();
            });
            nextBtn.addEventListener("click", () => {
                index++;
                update();
                restart();
            });

            let startX = 0,
                dragging = false;
            if (root) {
                root.addEventListener("touchstart", (e) => {
                    dragging = true;
                    startX = e.touches[0].clientX;
                }, {
                    passive: true
                });
                root.addEventListener("touchend", (e) => {
                    if (!dragging) return;
                    const endX = e.changedTouches[0].clientX;
                    const diff = endX - startX;
                    if (diff > 40) index--;
                    if (diff < -40) index++;
                    dragging = false;
                    update();
                    restart();
                });

                root.addEventListener("mouseenter", () => clearInterval(timer));
                root.addEventListener("mouseleave", restart);
            }

            window.addEventListener("resize", () => {
                buildDots();
                update();
            });

            buildDots();
            update();
            restart();
        }

        /* ===== Drawer UI ===== */
        function initDrawerUI() {
            const overlay = document.getElementById("cartOverlay");
            const drawer = document.getElementById("cartDrawer");
            const close = document.getElementById("closeCart");
            const keep = document.getElementById("keepShopping");
            const goCheckout = document.getElementById("goCheckout");

            function open() {
                overlay.classList.add("show");
                drawer.classList.add("show");
            }

            function hide() {
                overlay.classList.remove("show");
                drawer.classList.remove("show");
            }

            document.addEventListener("submit", (e) => {
                const form = e.target.closest('form[action*="cart/add"]');
                if (!form) return;
                const card = form.closest(".productCard");
                if (card) {
                    const name = card.dataset.name || "Product";
                    const price = Number(card.dataset.price || 0);
                    const img = card.dataset.img || "";
                    document.getElementById("drawerImg").src = img;
                    document.getElementById("drawerName").textContent = name;
                    document.getElementById("drawerPrice").textContent = "$" + price;
                    document.getElementById("drawerTotal").textContent = "$" + price;
                }
                setTimeout(open, 100);
            });

            overlay?.addEventListener("click", hide);
            close?.addEventListener("click", hide);
            keep?.addEventListener("click", hide);

            goCheckout?.addEventListener("click", () => {
                window.location.href = "{{ route('checkout') }}";
            });

            document.addEventListener("click", (e) => {
                const vb = e.target.closest(".viewBtn");
                if (!vb) return;
                const card = vb.closest(".productCard");
                const name = card?.dataset.name || "";
                window.location.href = "{{ route('shop') }}" + (name ? `?search=${encodeURIComponent(name)}` : "");
            });
        }

        async function postJSON(url, payload) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json",
                },
                body: JSON.stringify(payload)
            });
            if (!res.ok) {
                const t = await res.text();
                throw new Error(t);
            }
            return res.json();
        }

        async function refreshCartCount() {
            try {
                const res = await fetch("{{ route('cart.count') }}", {
                    headers: {
                        "Accept": "application/json"
                    }
                });
                const data = await res.json();
                document.querySelectorAll("[data-cart-count]").forEach(el => el.textContent = data.count ?? 0);
            } catch (e) {}
        }

        function openDrawer() {
            document.getElementById("cartOverlay")?.classList.add("show");
            document.getElementById("cartDrawer")?.classList.add("show");
        }

        function closeDrawer() {
            document.getElementById("cartOverlay")?.classList.remove("show");
            document.getElementById("cartDrawer")?.classList.remove("show");
        }

        document.addEventListener("click", async (e) => {
            const btn = e.target.closest(".addCartBtn");
            if (btn) {
                e.preventDefault();

                const card = btn.closest(".productCard");
                if (!card) return;

                const productId = card.dataset.productId || null;
                const name = card.dataset.name || "Product";
                const price = Number(card.dataset.price || 0);
                const img = card.dataset.img || "";

                const dImg = document.getElementById("drawerImg");
                const dName = document.getElementById("drawerName");
                const dPrice = document.getElementById("drawerPrice");
                const dTotal = document.getElementById("drawerTotal");

                if (dImg) {
                    dImg.src = img;
                    dImg.alt = name;
                }
                if (dName) dName.textContent = name;
                if (dPrice) dPrice.textContent = "$" + price;
                if (dTotal) dTotal.textContent = "$" + price;

                try {
                    const data = await postJSON("{{ route('cart.add') }}", {
                        product_id: productId ? parseInt(productId) : null,
                        name,
                        price,
                        img,
                        qty: 1
                    });
                    document.querySelectorAll("[data-cart-count]").forEach(el => el.textContent = data.count ??
                        0);
                    openDrawer();
                } catch (err) {
                    alert("Add to cart error. Console check.");
                    console.error(err);
                }
                return;
            }

            if (e.target.id === "cartOverlay") closeDrawer();
            if (e.target.id === "closeCart") closeDrawer();

            const goCheckout = e.target.closest(".btnPrimary");
            if (goCheckout) {
                e.preventDefault();
                window.location.href = "{{ route('checkout') }}";
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            initHeroImageSwiper();
            initFeaturedSwiper();
            initSearch();
            initDrawerUI();
            refreshCartCount();
        });
    </script>
@endpush
