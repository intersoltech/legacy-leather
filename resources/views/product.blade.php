@if(!$product)
  <div style="padding:80px;text-align:center">
    <h2>No product selected</h2>
    <a href="{{ route('shop') }}">Back to shop</a>
  </div>
  @php return; @endphp
@endif

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Product • Legacy Leather Works</title>
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />

  <style>
    :root{ --brown:#6B3F2A; --cream:#fbf7f2; --serif: ui-serif, Georgia, "Times New Roman", serif; }
    body{ margin:0; font-family:system-ui; background:var(--cream); }
    header{background:var(--brown); padding:14px 0;}
    .container{max-width:1100px;margin:0 auto;padding:0 18px;}
    .top{display:flex;justify-content:space-between;align-items:center;color:#fff;}
    .brand{display:flex;gap:12px;align-items:center;text-decoration:none;color:#fff;}
    .brand img{height:44px;background:#fff;border-radius:12px;padding:4px;}
    .cartBtn{background:#fff;border:1px solid rgba(0,0,0,.12);border-radius:999px;padding:10px 14px;
      font-size:12px;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;text-decoration:none;color:#111;}
    .wrap{padding:30px 0;}
    .card{
      background:#fff;border-radius:22px;overflow:hidden;box-shadow:0 25px 80px rgba(0,0,0,.12);
      display:grid;grid-template-columns:1fr 1fr;gap:0;
    }
    @media(max-width:900px){ .card{grid-template-columns:1fr;} }
    .imgBox{background:#f3efe9;min-height:360px;}
    .imgBox img{width:100%;height:100%;object-fit:cover;display:block;}
    .info{padding:24px;}
    .kicker{font-family:var(--serif);letter-spacing:.18em;text-transform:uppercase;font-size:11px;color:var(--brown);}
    .title{margin:10px 0 10px;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:26px;line-height:1.2;}
    .desc{color:#666;line-height:1.8;font-size:14px;margin:0 0 16px;}
    .price{font-size:20px;font-weight:900;color:var(--brown);margin:0 0 18px;}
    .row{display:flex;gap:10px;flex-wrap:wrap;align-items:center;}
    .btn{
      border-radius:16px;padding:12px 16px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;
      border:1px solid rgba(0,0,0,.12);background:#fff;cursor:pointer;transition:.2s ease;
    }
    .btn.primary{background:var(--brown);border-color:var(--brown);color:#fff;}
    .btn:hover{transform:translateY(-1px);filter:brightness(.98)}
    .toast{
      position:fixed;right:18px;bottom:18px;z-index:9999;background:#111;color:#fff;
      border-radius:14px;padding:12px 14px;box-shadow:0 18px 50px rgba(0,0,0,.25);
      transform:translateY(16px);opacity:0;pointer-events:none;transition:.25s ease;
      font-size:12px; letter-spacing:.08em; text-transform:uppercase;
    }
    .toast.show{transform:translateY(0);opacity:1;pointer-events:auto}
  </style>
</head>

<body>
<header>
  <div class="container top">
    <a class="brand" href="{{ url('/shop') }}">
      <img src="{{ image_url($product->image) }}" alt="{{ $product->name }}">
<h1>{{ $product->name }}</h1>
<p>{{ $product->description }}</p>
<p>${{ number_format($product->price,2) }}</p>

      <span>Legacy Leather Works</span>
    </a>
    <a class="cartBtn" href="{{ url('/checkout') }}">Checkout (<span data-cart-count>0</span>)</a>
  </div>
</header>

<section class="wrap">
  <div class="container">
    <div class="card">
      <div class="imgBox">
        <img id="pImg" src="{{ asset('assets/img/bag 2.jpg') }}" alt="Product">
      </div>
      <div class="info">
        <div class="kicker" id="pCat">Premium</div>
        <h1 class="title" id="pName">Product</h1>
        <p class="desc" id="pDesc">Description</p>
        <div class="price" id="pPrice">$0</div>

        <div class="row">
          <button class="btn" type="button" onclick="window.location.href='{{ url('/shop') }}'">Back to Shop</button>
          <button class="btn primary" id="addBtn" type="button">Add to Cart</button>
          <button class="btn primary" type="button" onclick="window.location.href='{{ url('/checkout') }}'">Go to Checkout</button>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="toast" id="toast">Added</div>

<script>
const CART_KEY = "llw_cart";

function readCart(){
  try { return JSON.parse(localStorage.getItem(CART_KEY) || "[]"); }
  catch { return []; }
}
function saveCart(cart){
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
}
function cartCount(cart){
  return (cart||[]).reduce((s,i)=> s + Number(i.qty||0), 0);
}
function updateCartCount(){
  const cart = readCart();
  document.querySelectorAll("[data-cart-count]").forEach(el=> el.textContent = cartCount(cart));
}
function showToast(msg){
  const t = document.getElementById("toast");
  if(!t) return;
  t.textContent = msg;
  t.classList.add("show");
  setTimeout(()=>t.classList.remove("show"), 1400);
}

document.addEventListener("DOMContentLoaded", ()=>{
  updateCartCount();

  // ✅ read product from localStorage
  let p = null;
  try { p = JSON.parse(localStorage.getItem("llw_view_product") || "null"); } catch(e){ p = null; }

  if(!p || !p.name){
    // fallback
    document.getElementById("pName").textContent = "Product not found";
    document.getElementById("pDesc").textContent = "Please go back to Shop and click View again.";
    return;
  }

  document.getElementById("pName").textContent = p.name || "Product";
  document.getElementById("pDesc").textContent = p.desc || "Premium leather product.";
  document.getElementById("pPrice").textContent = "$" + Number(p.price||0).toFixed(0);
  document.getElementById("pCat").textContent = (p.cat || "Premium").toUpperCase();

  const img = document.getElementById("pImg");
  img.src = p.img || img.src;
  img.onerror = ()=>{ img.src = "{{ asset('assets/img/banner.png') }}"; };

  document.getElementById("addBtn").addEventListener("click", ()=>{
    const cart = readCart();
    const found = cart.find(x => x.name === p.name);
    if(found) found.qty += 1;
    else cart.push({ name: p.name, price: Number(p.price||0), img: p.img||"", cat: p.cat||"", qty: 1 });

    saveCart(cart);
    updateCartCount();
    showToast("Added to cart");
  });
});
</script>
</body>
</html>
