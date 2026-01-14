@extends('layouts.master')

@section('title', 'Contact • Legacy Leather Works')

@section('meta_description', 'Get in touch with Legacy Leather Works. Contact us for inquiries about our premium leather goods, custom orders, or customer support.')
@section('og_title', 'Contact Us • Legacy Leather Works')
@section('og_description', 'Get in touch with Legacy Leather Works. Contact us for inquiries about our premium leather goods.')
@section('og_type', 'website')
@section('canonical_url', route('contact'))

@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ContactPage",
  "name": "Contact • Legacy Leather Works",
  "description": "Get in touch with Legacy Leather Works",
  "url": "{{ route('contact') }}",
  "mainEntity": {
    "@@type": "Organization",
    "name": "{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}",
    "email": "{{ $siteSettings['email'] ?? '' }}",
    "telephone": "{{ $siteSettings['whatsapp_number'] ?? '' }}"
  }
}
</script>
@endsection

@push('styles')
<style>
  .hero::before{
    background-image: url("{{ asset('assets/img/banner.png') }}");
  }
</style>
@endpush

@section('content')
<section class="hero">
  <div class="container">
    <div class="heroInner">
      <div class="kicker">Concierge Support</div>
      <h1 class="title">Let's Talk Leather</h1>
      <p class="sub">
        Questions about your order, custom requests, corporate gifting, or wholesale?
        Reach out — we'll respond with care.
      </p>
    </div>
  </div>
</section>

<section class="quickWrap">
  <div class="container">
    <div class="quickGrid">
      <div class="qCard">
        <div class="qTop">
          <h3>WhatsApp</h3>
          <div class="pill">Fast Reply</div>
        </div>
        <div class="qBody">
          <p>
            <i class="bi bi-whatsapp"></i>Chat with us directly on WhatsApp.<br/>
            <a href="{{ $siteSettings['whatsapp_url'] ?? 'https://wa.me/923000000000' }}" target="_blank" rel="noopener">{{ $siteSettings['whatsapp_number'] ?? '+92 300 0000000' }}</a>
          </p>
        </div>
      </div>

      <div class="qCard">
        <div class="qTop">
          <h3>Email</h3>
          <div class="pill">Support</div>
        </div>
        <div class="qBody">
          <p>
            <i class="bi bi-envelope"></i>Prefer email? We're here.<br/>
            <a href="mailto:{{ $siteSettings['email'] ?? 'support@legacyleatherworks.com' }}">{{ $siteSettings['email'] ?? 'support@legacyleatherworks.com' }}</a>
          </p>
        </div>
      </div>

      <div class="qCard">
        <div class="qTop">
          <h3>Visit</h3>
          <div class="pill">Studio</div>
        </div>
        <div class="qBody">
          <p>
            <i class="bi bi-geo-alt"></i>{!! $siteSettings['contact_address'] ?? 'Your Studio / Office Address Here<br/>City, Country' !!}
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="wrap">
  <div class="container">
    <div class="grid2">

      <!-- FORM -->
      <div class="card">
        <div class="cardHead">
          <h3>Send a Message</h3>
        </div>
        <div class="cardBody">
          <form id="contactForm" novalidate>
            <div class="row2">
              <div class="field">
                <label for="name">Full Name</label>
                <input id="name" name="name" type="text" placeholder="Your name" required />
              </div>
              <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="you@email.com" required />
              </div>
            </div>

            <div class="field">
              <label for="subject">Subject</label>
              <input id="subject" name="subject" type="text" placeholder="Order / Custom / Wholesale / Support" required />
            </div>

            <div class="field">
              <label for="message">Message</label>
              <textarea id="message" name="message" placeholder="Write your message..." required></textarea>
            </div>

            <div class="btnRow">
              <button type="submit" class="btnLux primary">Send</button>
              <button type="reset" class="btnLux">Clear</button>
            </div>

            <p class="note">
              We usually reply within 24 hours.
            </p>
          </form>
        </div>
      </div>

      <!-- SIDE INFO -->
      <div class="card">
        <div class="cardHead">
          <h3>Info</h3>
        </div>
        <div class="cardBody">
          <div class="infoRow">

            <div class="infoItem">
              <h4><i class="bi bi-clock"></i> Working Hours</h4>
              <p>{!! $siteSettings['contact_working_hours'] ?? 'Mon – Sat: 10:00 AM – 7:00 PM<br/>Sunday: Closed' !!}</p>
            </div>

            <div class="infoItem">
              <h4><i class="bi bi-question-circle"></i> Order Help</h4>
              <p>
                Include your <b>Order ID</b> for faster support.<br/>
                For custom work, share references + size details.
              </p>
            </div>

            <div class="map">
              <iframe
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                src="{{ $siteSettings['contact_map_embed'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3018.4526627807495!2d-73.40069872296034!3d40.8399844713748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e828e8e554dacf%3A0xe75990b88c579c38!2s11%20Ingersoll%20St%2C%20Huntington%20Station%2C%20NY%2011746%2C%20USA!5e0!3m2!1sen!2s!4v1768327147007!5m2!1sen!2s' }}">
              </iframe>              
              <div class="mapNote">
                {{ $siteSettings['contact_map_note'] ?? 'Google Maps → Share → Embed a map → copy iframe src and paste here.' }}
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<div class="toast" id="toast">Message sent</div>
@endsection

@push('scripts')
<script>
  /* Toast */
  const toastEl = document.getElementById("toast");
  function showToast(msg){
    if(!toastEl) return;
    toastEl.textContent = msg;
    toastEl.classList.add("show");
    setTimeout(()=>toastEl.classList.remove("show"), 1600);
  }

  /* Form submit */
  const form = document.getElementById("contactForm");
  if(form){
    form.addEventListener("submit", (e)=>{
      e.preventDefault();
      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const subject = document.getElementById("subject").value.trim();
      const message = document.getElementById("message").value.trim();

      if(!name || !email || !subject || !message){
        showToast("Please fill all fields");
        return;
      }
      showToast("Message sent");
      form.reset();
    });
  }

  /* Cart count update */
  document.addEventListener("DOMContentLoaded", async () => {
    try{
      const r = await fetch("{{ route('cart.count') }}", { headers: { "Accept":"application/json" }});
      const j = await r.json();
      document.querySelectorAll("[data-cart-count]").forEach(el => el.textContent = j.count ?? 0);
    }catch(e){}
  });
</script>
@endpush
