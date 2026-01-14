@extends('layouts.master')

@section('title', 'About • Legacy Leather Works')

@section('meta_description', 'Learn about Legacy Leather Works - premium leather goods crafted for an international lifestyle with timeless silhouettes and luxury materials.')
@section('og_title', 'About Us • Legacy Leather Works')
@section('og_description', 'Learn about Legacy Leather Works - premium leather goods crafted for an international lifestyle.')
@section('og_type', 'website')
@section('canonical_url', route('about'))

@section('content')
<!-- HERO -->
<section class="aboutHero">
  <div class="heroGrid">
    <div>
      <div class="kicker">Legacy Leather Works</div>
      <h1 class="title">Crafted to last. Designed to feel luxury.</h1>
      <p class="lead">
        Legacy Leather Works is built on timeless silhouettes, premium materials, and
        clean finishing. We believe leather should age beautifully — every stitch,
        every edge, and every detail is made to feel refined and elevated.
      </p>

      <div class="heroBtns">
        <a class="btn primary" href="{{ url('/shop') }}">Shop Collection</a>
        <a class="btn ghost" href="{{ url('/contact') }}">Contact Us</a>
      </div>
    </div>

    <div class="heroCard">
      <img class="heroImg" src="{{ asset('assets/img/banner3.png') }}" alt="Legacy Leather Works">
      <div class="heroNote">
        <b>Premium Craftsmanship</b>
        <p>
          From cutting to stitching — our focus stays on comfort, structure, and a finish
          that looks premium in every light.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- VALUES -->
<section class="section">
  <div class="container">
    <div class="sectionHead">
      <h2>What we stand for</h2>
      <div class="small">Quality • Detail • Trust</div>
    </div>

    <div class="grid3">
      <div class="tile">
        <div class="tileTop">
          <h3>Materials</h3>
          <span class="pill">Premium Leather</span>
        </div>
        <p>
          We choose strong, durable materials with a refined texture — built to hold its
          shape and age gracefully over time.
        </p>
      </div>

      <div class="tile">
        <div class="tileTop">
          <h3>Craft</h3>
          <span class="pill">Clean Finish</span>
        </div>
        <p>
          Minimal, luxury look comes from precision: neat edges, balanced panels,
          and stitching that feels premium up close.
        </p>
      </div>

      <div class="tile">
        <div class="tileTop">
          <h3>Service</h3>
          <span class="pill">Easy Returns</span>
        </div>
        <p>
          Smooth experience matters. Fast support, clear policies, and easy returns —
          so you can shop with confidence.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- STORY -->
<section class="story">
  <div class="storyGrid">
    <div class="storyImg">
      <img src="{{ asset('assets/img/b1.jpg') }}" alt="Our Story">
    </div>

    <div class="storyBox">
      <h2>Our story</h2>
      <p>
        Legacy Leather Works was born from a childhood memory — watching a father transform raw leather into something meaningful. To him, leather was never just material; it was a promise of quality, patience, and longevity.

        That same spirit lives on today. Every piece we create is handcrafted from premium leather with care, honesty, and respect for true craftsmanship. We don't rush the process, and we don't treat orders as transactions — each one is part of a continuing legacy.

        When you choose Legacy Leather Works, you're not just buying leather.
        You're holding a memory. A tradition.
      </p>
      <p>
        We focus on design that feels international: structured silhouettes, soft comfort,
        and a finish that looks luxury in photos and in real life.
      </p>

      <div class="miniStats">
        <div class="stat">
          <b>Design</b>
          <span>Timeless silhouettes</span>
        </div>
        <div class="stat">
          <b>Finish</b>
          <span>Luxury clean edges</span>
        </div>
        <div class="stat">
          <b>Promise</b>
          <span>Built to last</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <div class="container">
    <div class="ctaCard">
      <div>
        <h3>Ready to explore the collection?</h3>
        <p>
          Discover jackets, wallets, and accessories crafted with premium leather and a
          luxury feel — designed for modern everyday style.
        </p>
      </div>
      <div class="heroBtns" style="margin:0;">
        <a class="btn primary" href="{{ url('/shop') }}">Shop Now</a>
        <a class="btn ghost" href="{{ url('/policies') }}">Shipping Info</a>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/app.js') }}"></script>
<script>
  document.addEventListener("DOMContentLoaded", async () => {
    try{
      const r = await fetch("{{ route('cart.count') }}", { headers: { "Accept":"application/json" }});
      const j = await r.json();
      document.querySelectorAll("[data-cart-count]").forEach(el => el.textContent = j.count ?? 0);
    }catch(e){}
  });
</script>
@endpush
