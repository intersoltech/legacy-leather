@extends('layouts.master')

@section('title', 'Shipping Policy • Legacy Leather Works')

@section('content')
<!-- HERO -->
<section class="pageHero">
  <div class="heroWrap">
    <div>
      <div class="kicker">Legacy Leather Works</div>
      <h1 class="hTitle">Shipping Policy</h1>
      <p class="hLead">
        We ship worldwide with secure packaging and trackable delivery.
        Below you'll find processing times, delivery estimates, and important information.
      </p>
      <div class="heroBadgeRow">
        <div class="badge">Worldwide Shipping</div>
        <div class="badge">Trackable Delivery</div>
        <div class="badge">Easy Returns</div>
      </div>
    </div>

    <div class="heroCard">
      <img src="{{ asset('assets/img/banner3.png') }}" alt="Shipping">
      <div class="note">
        <b>Secure Packaging</b>
        <p>Each order is packed carefully to protect the shape, finish, and leather texture.</p>
      </div>
    </div>
  </div>
</section>

<!-- CONTENT -->
<section class="section">
  <div class="container">
    <div class="secHead">
      <h2>Shipping Details</h2>
      <div class="small">Fast • Secure • Luxury</div>
    </div>

    <div class="grid2">
      <div class="infoCard">
        <h3><span class="dotIcon"></span> Order Processing</h3>
        <p>Orders are processed within <b>1–3 business days</b>. After dispatch, you will receive a tracking code via email/WhatsApp.</p>
      </div>

      <div class="infoCard">
        <h3><span class="dotIcon"></span> Shipping Charges</h3>
        <p>Shipping is calculated at checkout based on destination and package size. Occasionally we offer free shipping promotions.</p>
      </div>

      <div class="infoCard">
        <h3><span class="dotIcon"></span> Delivery Attempts</h3>
        <p>Couriers usually attempt delivery 2–3 times. If delivery fails, the parcel may return to origin.</p>
      </div>

      <div class="infoCard">
        <h3><span class="dotIcon"></span> Customs & Duties</h3>
        <p>International orders may be subject to customs duties/taxes. These are paid by the customer as per local laws.</p>
      </div>
    </div>

    <div class="secHead" style="margin-top:26px;">
      <h2>Estimated Delivery Times</h2>
      <div class="small">Business days</div>
    </div>

    <div class="timeline">
      <div class="tRow"><b>Pakistan</b><span>2–4 days</span></div>
      <div class="tRow"><b>Middle East</b><span>5–7 days</span></div>
      <div class="tRow"><b>UK / Europe</b><span>7–10 days</span></div>
      <div class="tRow"><b>International</b><span>7–12 days</span></div>
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
