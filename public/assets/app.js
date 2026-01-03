/* =========================
   Legacy Leather Works - Clean JS (Laravel)
   One cart key, view product support, shop filters, no duplicates
========================= */

const CART_KEY = "llw_cart";
const VIEW_KEY = "llw_view_product";

/* ---------- Cart Helpers ---------- */
function readCart(){
  try { return JSON.parse(localStorage.getItem(CART_KEY) || "[]"); }
  catch { return []; }
}
function saveCart(cart){
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
}
function cartCount(cart){
  return (cart || []).reduce((s,i)=> s + Number(i.qty || 0), 0);
}
function updateCartCount(){
  const cart = readCart();
  document.querySelectorAll("[data-cart-count]").forEach(el=>{
    el.textContent = cartCount(cart);
  });
}

/* ---------- Shop Helpers ---------- */
function debounce(fn, wait=150){
  let t; return (...args)=>{ clearTimeout(t); t=setTimeout(()=>fn(...args), wait); };
}
function getCatFromURL(){
  const u = new URL(window.location.href);
  return (u.searchParams.get("cat") || "all").toLowerCase().trim();
}
function setActiveChip(){
  const cat = getCatFromURL();
  document.querySelectorAll("#catRow .chip").forEach(ch=>{
    const c = (ch.dataset.cat || "").toLowerCase().trim();
    ch.classList.toggle("active", c === cat);
  });
}

/* =========================
   BANNER SWIPER (Shop page)
   Requires: #bannerSwiper
========================= */
function initBannerSwiper(){
  const el = document.getElementById("bannerSwiper");
  if(!el || typeof Swiper === "undefined") return;

  new Swiper("#bannerSwiper", {
    loop: true,
    autoplay: { delay: 3500, disableOnInteraction: false },
    pagination: { el: ".swiper-pagination", clickable: true },
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    effect: "slide",
    speed: 700
  });

  // Banner buttons -> URL category
  document.querySelectorAll("[data-banner-cat]").forEach(btn=>{
    btn.addEventListener("click", ()=>{
      const cat = (btn.getAttribute("data-banner-cat") || "all").toLowerCase().trim();
      const base = btn.getAttribute("data-shop-base") || "/shop";
      if(cat === "all") window.location.href = base;
      else window.location.href = base + "?cat=" + encodeURIComponent(cat);
    });
  });
}

/* =========================
   SHOP FILTERS (works on existing cards)
   Card needs:
   .productCard (also keep .luxCard for design)
   data-cat, data-name, data-desc
========================= */
function applyShopFilters(){
  const grid = document.getElementById("grid");
  if(!grid) return;

  const cat = getCatFromURL();
  const qEl = document.getElementById("q");
  const query = (qEl?.value || "").toLowerCase().trim();

  const cards = grid.querySelectorAll(".productCard");
  let any = false;

  cards.forEach(card=>{
    const title = (card.dataset.name || card.querySelector(".luxTitle")?.innerText || "").toLowerCase();
    const desc  = (card.dataset.desc || card.querySelector(".luxSub")?.innerText || "").toLowerCase();
    const ccat  = (card.dataset.cat || "").toLowerCase().trim();

    const catMatch = (cat === "all") || (ccat === cat);
    const searchMatch = !query || title.includes(query) || desc.includes(query);

    const show = catMatch && searchMatch;
    card.style.display = show ? "" : "none";
    if(show) any = true;
  });

  // optional empty message
  const empty = document.getElementById("shopEmptyMsg");
  if(empty){
    empty.style.display = any ? "none" : "block";
  }
}

function initShopSearch(){
  const q = document.getElementById("q");
  const clearBtn = document.getElementById("clearFilters");
  const topSearch = document.getElementById("topSearch");

  q?.addEventListener("input", debounce(applyShopFilters, 120));

  if(topSearch){
    topSearch.addEventListener("keydown", (e)=>{
      if(e.key !== "Enter") return;
      const val = topSearch.value.trim();
      if(!val) return;
      q.value = val;
      applyShopFilters();
      const controls = document.querySelector(".controls");
      if(controls){
        window.scrollTo({ top: controls.offsetTop - 80, behavior: "smooth" });
      }
    });
  }

  clearBtn?.addEventListener("click", ()=>{
    if(q) q.value = "";
    if(topSearch) topSearch.value = "";
    applyShopFilters();
  });
}

/* =========================
   VIEW + ADD TO CART (Shop cards)
   Buttons:
   .viewBtn  => saves llw_view_product, goes to data-href (/product)
   .addCartBtn => adds to llw_cart, updates count, toast
========================= */
function initShopCardActions(){
  document.addEventListener("click", (e)=>{
    const addBtn  = e.target.closest(".addCartBtn");
    const viewBtn = e.target.closest(".viewBtn");

    // ADD
    if(addBtn){
      const card = addBtn.closest(".productCard");
      if(!card) return;

      const name  = (card.dataset.name || card.querySelector(".luxTitle")?.innerText || "Product").trim();
      const price = Number(card.dataset.price || 0);
      const img   = card.dataset.img || card.querySelector("img")?.getAttribute("src") || "";
      const cat   = (card.dataset.cat || "").trim();
      const desc  = (card.dataset.desc || card.querySelector(".luxSub")?.innerText || "").trim();

      const cart = readCart();
      const found = cart.find(x => x.name === name);
      if(found) found.qty += 1;
      else cart.push({ name, price, img, cat, desc, qty: 1 });

      saveCart(cart);
      updateCartCount();

      const toast = document.getElementById("toast");
      if(toast){
        toast.textContent = "Added to cart";
        toast.classList.add("show");
        setTimeout(()=>toast.classList.remove("show"), 1400);
      }
      return;
    }

    // VIEW
    if(viewBtn){
      const card = viewBtn.closest(".productCard");
      if(!card) return;

      const product = {
        name: (card.dataset.name || card.querySelector(".luxTitle")?.innerText || "").trim(),
        price: Number(card.dataset.price || 0),
        img: card.dataset.img || card.querySelector("img")?.getAttribute("src") || "",
        cat: (card.dataset.cat || "").trim(),
        desc: (card.dataset.desc || card.querySelector(".luxSub")?.innerText || "").trim(),
      };

      localStorage.setItem(VIEW_KEY, JSON.stringify(product));

      const href = card.dataset.href || "/product";
      window.location.href = href;
    }
  });
}

/* =========================
   Place Order demo (optional)
========================= */
function initPlaceOrder(){
  const btn = document.getElementById("placeOrderBtn");
  if(!btn) return;
  btn.addEventListener("click", (e)=>{
    e.preventDefault();
    alert("Order placed (demo) ✅");
    // cart clear mat karo
  });
}

/* =========================
   INIT (ONLY ONE)
========================= */
document.addEventListener("DOMContentLoaded", ()=>{
  updateCartCount();

  // Shop page
  initBannerSwiper();
  if(document.getElementById("grid")){
    setActiveChip();
    initShopSearch();
    applyShopFilters();
    initShopCardActions();
  }

  // Checkout page (if you have summary IDs)
  // initCheckoutSummary();  // (agar tum checkout page IDs use kar rahi ho to yahan add kar dena)

  initPlaceOrder();
});

console.log("app loaded", localStorage.getItem("llw_cart"));
