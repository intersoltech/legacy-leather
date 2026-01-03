<div class="topbar">
  <div class="container topbar-inner">
    <div class="topbar-marquee">
      <div class="marquee-track">
        @php
          $marqueeItems = explode('•', $siteSettings['marquee_text'] ?? 'Worldwide Shipping•Easy Returns•Premium Leather Craftsmanship•Legacy Leather Works');
        @endphp
        @foreach($marqueeItems as $item)
          <span>{{ trim($item) }}</span><span>•</span>
        @endforeach
        @foreach($marqueeItems as $item)
          <span>{{ trim($item) }}</span><span>•</span>
        @endforeach
      </div>
    </div>
    <div>
      <select class="currency" id="currencySel" aria-label="Currency">
        @foreach($siteSettings['currencies'] ?? ['AED', 'USD', 'PKR', 'GBP'] as $curr)
          <option value="{{ $curr }}" {{ $curr === ($siteSettings['default_currency'] ?? 'USD') ? 'selected' : '' }}>{{ $curr }}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>

