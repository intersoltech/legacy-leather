{{-- resources/views/index.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Legacy Leather Works</title>

  {{-- ✅ CSRF for DB cart requests --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />

  <style>
    {!! (file_exists(public_path('assets/inline-home.css')) ? file_get_contents(public_path('assets/inline-home.css')) : '') !!}
  </style>
</head>

<body>

<header>
  <div class="topbar">
    <div class="container topbar-inner">
      <div class="topbar-marquee">
        <div class="marquee-track">
          <span>Worldwide Shipping</span><span>•</span><span>Easy Returns</span><span>•</span>
          <span>Premium Leather Craftsmanship</span><span>•</span><span>Legacy Leather Works</span>

          <span>Worldwide Shipping</span><span>•</span><span>Easy Returns</span><span>•</span>
          <span>Premium Leather Craftsmanship</span><span>•</span><span>Legacy Leather Works</span>
        </div>
      </div>

      <div>
        <select class="currency">
          <option>AED</option><option>USD</option><option>PKR</option><option>GBP</option>
        </select>
      </div>
    </div>
  </div>

  <div class="container nav">
    <nav class="navlinks">
      <a href="{{ url('/shop') }}">SHOP</a>
      <a href="{{ url('/about') }}">ABOUT</a>
      <a href="{{ url('/policies') }}">SHIPPING</a>
    </nav>

    <a class="brand" href="{{ url('/') }}">
      <img class="brand-logo" src="{{ asset('assets/img/logo.png') }}" alt="Legacy Leather Works">
      <span class="brand-text">Legacy Leather Works</span>
    </a>

    <div class="actions">
      <div class="search">
        <span></span>
        <input id="searchInput" placeholder="Search (Enter)" autocomplete="off" />
        <div class="searchDrop" id="searchDrop"></div>
      </div>

      <a class="cart" href="{{ url('/cart') }}">
        CART (<span data-cart-count>0</span>)
      </a>
    </div>
  </div>
</header>

<section class="heroBanner" id="heroBanner">
  <div class="heroImgTrack" id="heroImgTrack">
    <img class="hero-img" src="{{ asset('assets/img/banner.png') }}" alt="Banner 1">
    <img class="hero-img" src="{{ asset('assets/img/esha.jpg') }}" alt="Banner 2">
    <img class="hero-img" src="{{ asset('assets/img/1.jpg') }}" alt="Banner 3">
    <img class="hero-img" src="{{ asset('assets/img/banner3.png') }}" alt="Banner 4">
  </div>

  <button class="heroImgArrow left" id="heroImgPrev" aria-label="Previous">‹</button>
  <button class="heroImgArrow right" id="heroImgNext" aria-label="Next">›</button>
  <div class="heroImgDots" id="heroImgDots"></div>
</section>

<section class="section">
  <div class="luxSectionHead">
    <h2>OUR PRODUCTS</h2>
  </div>

  <div class="sliderWrap" id="featuredWrap">
    <button class="arrow left" id="featuredPrev" aria-label="Previous">‹</button>
    <button class="arrow right" id="featuredNext" aria-label="Next">›</button>

    <div class="sliderViewport">
      <div class="sliderTrack" id="featuredTrack">

        <div class="cardPro productCard"
          data-name="Classic Black Jacket"
          data-price="299"
          data-img="{{ asset('assets/img/aq.jpeg') }}"
          data-href="{{ url('/shop') }}">
          <div class="cardMedia">
            <img src="{{ asset('assets/img/aq.jpeg') }}" alt="Classic Black Jacket">
            <span class="tag">Bestseller</span>
          </div>
          <div class="cardBody">
            <div class="cardTop">
              <h3>Classic Black Jacket</h3>
              <span class="price">$299</span>
            </div>
            <p class="sub">Genuine leather • Premium stitching</p>
            <div class="cardActions">
              <button class="pillMini viewBtn" type="button">View</button>
              <button class="pillMini addCartBtn" type="button">Add to Cart</button>
            </div>
          </div>
        </div>

        <div class="cardPro productCard"
          data-name="Women Cropped Jacket"
          data-price="279"
          data-img="{{ asset('assets/img/j.jpg') }}"
          data-href="{{ url('/shop') }}">
          <div class="cardMedia">
            <img src="{{ asset('assets/img/j.jpg') }}" alt="Women Cropped Jacket">
            <span class="tag">Women</span>
          </div>
          <div class="cardBody">
            <div class="cardTop">
              <h3>Women Cropped Jacket</h3>
              <span class="price">$279</span>
            </div>
            <p class="sub">Modern cut • Soft leather</p>
            <div class="cardActions">
              <button class="pillMini viewBtn" type="button">View</button>
              <button class="pillMini addCartBtn" type="button">Add to Cart</button>
            </div>
          </div>
        </div>

        <div class="cardPro productCard"
          data-name="Tan Racer Jacket"
          data-price="319"
          data-img="{{ asset('assets/img/M4.jpg') }}"
          data-href="{{ url('/shop') }}">
          <div class="cardMedia">
            <img src="{{ asset('assets/img/M4.jpg') }}" alt="Tan Racer Jacket">
            <span class="tag">Limited</span>
          </div>
          <div class="cardBody">
            <div class="cardTop">
              <h3>Tan Racer Jacket</h3>
              <span class="price">$319</span>
            </div>
            <p class="sub">Sleek racer style • Tan leather</p>
            <div class="cardActions">
              <button class="pillMini viewBtn" type="button">View</button>
              <button class="pillMini addCartBtn" type="button">Add to Cart</button>
            </div>
          </div>
        </div>

        <div class="cardPro productCard"
          data-name="Leather Blazer"
          data-price="369"
          data-img="{{ asset('assets/img/M2.jpg') }}"
          data-href="{{ url('/shop') }}">
          <div class="cardMedia">
            <img src="{{ asset('assets/img/M2.jpg') }}" alt="Leather Blazer">
            <span class="tag">Blazer</span>
          </div>
          <div class="cardBody">
            <div class="cardTop">
              <h3>Leather Blazer</h3>
              <span class="price">$369</span>
            </div>
            <p class="sub">Formal look • Office-ready</p>
            <div class="cardActions">
              <button class="pillMini viewBtn" type="button">View</button>
              <button class="pillMini addCartBtn" type="button">Add to Cart</button>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="dots" id="featuredDots"></div>
  </div>
</section>

<div class="cartOverlay" id="cartOverlay"></div>

<div class="cartDrawer" id="cartDrawer" aria-hidden="true">
  <div class="cartHeader">
    <h3>Added to Cart</h3>
    <button class="cartClose" id="closeCart" aria-label="Close" type="button">✕</button>
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
        <button class="qBtn" id="qtyMinus" type="button">−</button>
        <div class="qNum" id="qtyNum">1</div>
        <button class="qBtn" id="qtyPlus" type="button">+</button>
      </div>
    </div>
  </div>

  <div class="cartFooter2">
    <div class="totalRow">
      <div>Total</div>
      <strong id="drawerTotal">$0</strong>
    </div>
    <button class="btnPrimary" id="checkoutBtn" type="button">Checkout</button>
    <button class="btnGhost" id="keepShopping" type="button">Keep Shopping</button>
  </div>
</div>

<footer class="llwFooter">
  <div class="llwFooterBottom">
    <div class="llwBottomInner">
      <div>© <span id="yrFooter"></span> Legacy Leather Works. All rights reserved.</div>
    </div>
  </div>
  <div class="fToast" id="fToast">Saved</div>
</footer>

<script src="{{ asset('assets/app.js') }}"></script>

<script>
/* ===== Helpers ===== */
function csrfToken(){ return document.querySelector('meta[name="csrf-token"]')?.content || ''; }
function llwToast(msg){
  const t=document.getElementById("fToast"); if(!t) return;
  t.textContent=msg; t.classList.add("show");
  setTimeout(()=>t.classList.remove("show"),2200);
}
async function apiPost(url, payload){
  const res = await fetch(url,{
    method:"POST",
    headers:{
      "Content-Type":"application/json",
      "Accept":"application/json",
      "X-CSRF-TOKEN": csrfToken()
    },
    body: JSON.stringify(payload)
  });
  if(!res.ok){
    const txt = await res.text().catch(()=> "");
    throw new Error(txt || "Request failed");
  }
  return res.json();
}
async function apiGet(url){
  const res = await fetch(url,{headers:{"Accept":"application/json"}});
  if(!res.ok) throw new Error("GET failed");
  return res.json();
}

/* ===== Hero Slider ===== */
function initHeroImageSwiper(){
  const banner=document.getElementById("heroBanner");
  const track=document.getElementById("heroImgTrack");
  const dotsEl=document.getElementById("heroImgDots");
  const prev=document.getElementById("heroImgPrev");
  const next=document.getElementById("heroImgNext");
  if(!banner||!track||!dotsEl||!prev||!next) return;

  const slides=[...track.querySelectorAll("img")];
  let i=0, timer=null;

  function buildDots(){
    dotsEl.innerHTML="";
    slides.forEach((_,idx)=>{
      const d=document.createElement("div");
      d.className="heroImgDot"+(idx===i?" active":"");
      d.addEventListener("click",()=>{ i=idx; update(); restart(); });
      dotsEl.appendChild(d);
    });
  }
  function update(){
    i=(i+slides.length)%slides.length;
    track.style.transform=`translateX(${-i*100}%)`;
    [...dotsEl.children].forEach((d,idx)=>d.classList.toggle("active",idx===i));
  }
  function restart(){
    clearInterval(timer);
    timer=setInterval(()=>{ i++; update(); },4500);
  }

  prev.addEventListener("click",()=>{ i--; update(); restart(); });
  next.addEventListener("click",()=>{ i++; update(); restart(); });

  buildDots(); update(); restart();
}

/* ===== Featured Slider ===== */
function initFeaturedSwiper(){
  const track=document.getElementById("featuredTrack");
  const dotsEl=document.getElementById("featuredDots");
  const prevBtn=document.getElementById("featuredPrev");
  const nextBtn=document.getElementById("featuredNext");
  const wrap=document.getElementById("featuredWrap");
  if(!track||!dotsEl||!prevBtn||!nextBtn) return;

  const cards=[...track.children];
  let index=0, timer=null;

  function perView(){
    const w=window.innerWidth;
    if(w<700) return 1;
    if(w<1000) return 2;
    return 4;
  }
  function maxIndex(){ return Math.max(0, cards.length - perView()); }

  function buildDots(){
    dotsEl.innerHTML="";
    const pages=maxIndex()+1;
    for(let p=0;p<pages;p++){
      const d=document.createElement("div");
      d.className="dot"+(p===index?" active":"");
      d.addEventListener("click",()=>{ index=p; update(); restart(); });
      dotsEl.appendChild(d);
    }
  }

  function update(){
    const mx=maxIndex();
    if(index>mx) index=0;
    if(index<0) index=mx;

    const first=cards[0]; if(!first) return;
    const cardWidth=first.getBoundingClientRect().width;
    const gap=16;
    track.style.transform=`translateX(${-(cardWidth+gap)*index}px)`;
    [...dotsEl.children].forEach((d,i)=>d.classList.toggle("active",i===index));
  }

  function restart(){
    clearInterval(timer);
    timer=setInterval(()=>{ index++; update(); },4000);
  }

  prevBtn.addEventListener("click",()=>{ index--; update(); restart(); });
  nextBtn.addEventListener("click",()=>{ index++; update(); restart(); });

  window.addEventListener("resize",()=>{ buildDots(); update(); });

  buildDots(); update(); restart();
}

/* ===== Search ===== */
function initSearch(){
  const input=document.getElementById("searchInput");
  const drop=document.getElementById("searchDrop");
  if(!input||!drop) return;

  const cards=[...document.querySelectorAll(".productCard")];
  const products=cards.map((card)=>({
    name:(card.dataset.name||"Product").trim(),
    price:"$"+(card.dataset.price||""),
    img: card.dataset.img || card.querySelector("img")?.src || "",
    href: card.dataset.href || "{{ url('/shop') }}",
    cat:"Leather"
  }));

  function close(){ drop.classList.remove("show"); drop.innerHTML=""; }

  function render(list){
    if(!list.length){
      drop.innerHTML=`<div class="searchEmpty">No results found.</div>`;
      drop.classList.add("show");
      return;
    }
    drop.innerHTML=list.slice(0,6).map(p=>`
      <a class="searchItem" href="${p.href}">
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

  input.addEventListener("input",()=>{
    const q=input.value.trim().toLowerCase();
    if(!q){ close(); return; }
    render(products.filter(p=>p.name.toLowerCase().includes(q)));
  });

  document.addEventListener("click",(e)=>{
    if(!drop.contains(e.target) && e.target!==input) close();
  });
}

/* ===== Cart Drawer (DB) ===== */
function initCartDrawer(){
  const overlay=document.getElementById("cartOverlay");
  const drawer=document.getElementById("cartDrawer");
  const closeBtn=document.getElementById("closeCart");
  const keepBtn=document.getElementById("keepShopping");
  const cartCountEls=document.querySelectorAll("[data-cart-count]");

  const dImg=document.getElementById("drawerImg");
  const dName=document.getElementById("drawerName");
  const dPrice=document.getElementById("drawerPrice");
  const dTotal=document.getElementById("drawerTotal");
  const qtyNum=document.getElementById("qtyNum");
  const qtyMinus=document.getElementById("qtyMinus");
  const qtyPlus=document.getElementById("qtyPlus");

  if(!overlay||!drawer) return;

  let current={name:"",price:0,img:"",qty:1};

  function money(n){ return "$"+Number(n).toFixed(0); }
  function setCount(n){ cartCountEls.forEach(el=>el.textContent=String(n||0)); }

  function open(){
    overlay.classList.add("show");
    drawer.classList.add("show");
    drawer.setAttribute("aria-hidden","false");
  }
  function close(){
    overlay.classList.remove("show");
    drawer.classList.remove("show");
    drawer.setAttribute("aria-hidden","true");
  }
  function render(){
    if(dImg){ dImg.src=current.img; dImg.alt=current.name; }
    if(dName) dName.textContent=current.name;
    if(dPrice) dPrice.textContent=money(current.price);
    if(qtyNum) qtyNum.textContent=String(current.qty);
    if(dTotal) dTotal.textContent=money(current.price*current.qty);
  }

  // load count from DB
  apiGet("{{ route('cart.count') }}").then(d=>setCount(d.count)).catch(()=>{});

  document.addEventListener("click", async (e)=>{
    const btn = e.target.closest(".addCartBtn");
    if(!btn) return;

    e.preventDefault();

    const card = btn.closest(".productCard");
    if(!card) return;

    const name=(card.dataset.name||"Product").trim();
    const price=Number(card.dataset.price||0);
    const img=card.dataset.img || card.querySelector("img")?.src || "";

    current={name,price,img,qty:1};
    render();

    try{
      const data = await apiPost("{{ route('cart.add') }}", {name,price,img,qty:1});
      setCount(data.count);
      open();
    }catch(err){
      console.error(err);
      llwToast("Add to cart failed (check /cart/add route).");
    }
  });

  qtyMinus?.addEventListener("click",()=>{ current.qty=Math.max(1,current.qty-1); render(); });
  qtyPlus?.addEventListener("click",()=>{ current.qty=current.qty+1; render(); });

  closeBtn?.addEventListener("click",close);
  keepBtn?.addEventListener("click",close);
  overlay.addEventListener("click",close);

  document.getElementById("checkoutBtn")?.addEventListener("click",()=>{
    window.location.href="{{ url('/checkout') }}";
  });

  // view btn (optional)
  document.addEventListener("click",(e)=>{
    const viewBtn=e.target.closest(".viewBtn");
    if(!viewBtn) return;
    e.preventDefault();
    const card=viewBtn.closest(".productCard");
    const href=card?.dataset.href || "{{ url('/shop') }}";
    const name=card?.dataset.name || "";
    window.location.href = name ? `${href}?search=${encodeURIComponent(name)}` : href;
  });
}

/* ===== Init ===== */
document.addEventListener("DOMContentLoaded",()=>{
  const y=document.getElementById("yrFooter");
  if(y) y.textContent=new Date().getFullYear();

  initHeroImageSwiper();
  initFeaturedSwiper();
  initSearch();
  initCartDrawer();
});
</script>

</body>
</html>
