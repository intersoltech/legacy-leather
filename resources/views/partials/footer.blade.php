<footer class="llwFooter">
  <div class="llwFooterTop">
    <div class="llwFooterGrid">

      <div class="fCol">
        <a class="fBrand" href="{{ url('/') }}">
          <img src="{{ asset($siteSettings['site_logo'] ?? 'assets/img/logo.png') }}" alt="{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}">
          <span>{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}</span>
        </a>
        <p class="fDesc">
          {{ $siteSettings['footer_description'] ?? 'Premium leather goods crafted for an international lifestyle — timeless silhouettes, clean finishing, and luxury materials.' }}
        </p>
        <div class="fSocial">
          @foreach($socialLinks ?? [] as $social)
            <a href="{{ $social->url }}" aria-label="{{ $social->aria_label ?? $social->platform }}">
              @if($social->icon_class)
                <i class="bi {{ $social->icon_class }}"></i>
              @else
                {{ $social->icon_text ?? $social->platform }}
              @endif
            </a>
          @endforeach
        </div>
      </div>

      <div class="fCol">
        <h4 class="fTitle">Shop</h4>
        @foreach($categories->whereNotIn('slug', ['all']) as $cat)
          <a class="fLink" href="{{ url('/shop') }}?cat={{ urlencode($cat->slug) }}">{{ $cat->display_name ?? $cat->name }}</a>
        @endforeach
      </div>

      <div class="fCol">
        <h4 class="fTitle">Support</h4>
        <a class="fLink" href="{{ url('/track-order') }}">Track Order</a>
        <a class="fLink" href="{{ url('/contact') }}">Contact Us</a>
        <a class="fLink" href="{{ url('/policies') }}">Shipping Policy</a>
        <a class="fLink" href="{{ url('/policies') }}#returns">Returns & Exchange</a>
        <a class="fLink" href="{{ url('/policies') }}#privacy">Privacy Policy</a>
        <a class="fLink" href="{{ url('/policies') }}#terms">Terms & Conditions</a>
      </div>

      <div class="fCol">
        <h4 class="fTitle">Newsletter</h4>
        <p class="fDesc2">{{ $siteSettings['newsletter_text'] ?? 'Get early access to new arrivals and exclusive offers.' }}</p>

        <form class="fForm" onsubmit="event.preventDefault();">
          <input class="fInput" type="email" placeholder="Enter your email" required>
          <button class="fBtn" type="submit">Subscribe</button>
        </form>

        <div class="fContact">
          <div><i class="bi bi-whatsapp"></i> <span>WhatsApp:</span> {{ $siteSettings['whatsapp_number'] ?? '+92 300 0000000' }}</div>
          <div><i class="bi bi-envelope"></i> <span>Email:</span> {{ $siteSettings['email'] ?? 'support@legacyleatherworks.com' }}</div>
        </div>

        <a class="fWhatsApp" href="{{ $siteSettings['whatsapp_url'] ?? 'https://wa.me/923000000000' }}" target="_blank" rel="noopener">
          <i class="bi bi-whatsapp"></i> WhatsApp Us
        </a>
      </div>

    </div>
  </div>

  <div class="llwFooterBottom">
    <div class="llwBottomInner">
      <div>© <span id="yrFooter"></span> {{ $siteSettings['copyright_text'] ?? 'Legacy Leather Works. All rights reserved.' }}</div>
      <div class="fPayments">
        @foreach($siteSettings['payment_methods'] ?? ['VISA', 'MASTERCARD', 'STRIPE', 'COD'] as $method)
          <span>{{ $method }}</span>
        @endforeach
      </div>
    </div>
  </div>
</footer>

<script>
  document.getElementById('yrFooter').textContent = new Date().getFullYear();
</script>

