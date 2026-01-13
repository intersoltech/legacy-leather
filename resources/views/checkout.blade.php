@extends('layouts.master')

@section('title', 'Checkout — Legacy Leather Works')

@push('styles')
<style>
  .checkoutWrap{max-width:1180px;margin:22px auto;padding:0 18px}
  .checkoutGrid{display:grid;grid-template-columns:1.2fr .8fr;gap:22px;align-items:start}
  @media(max-width:980px){.checkoutGrid{grid-template-columns:1fr}}

  .boxCard{border:1px solid var(--line);border-radius:18px;background:#fff;overflow:hidden;box-shadow:0 10px 26px rgba(0,0,0,.06);}
  .boxHead{padding:16px 18px;border-bottom:1px solid rgba(0,0,0,.08);background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);display:flex;justify-content:space-between;align-items:flex-end;gap:12px;}
  .boxHead h2{margin:0;font-family: ui-serif, Georgia, "Times New Roman", serif;letter-spacing:.10em;text-transform:uppercase;font-size:16px;color:#3b2a1f;}
  .boxBody{padding:18px}

  .fieldRow{display:grid;grid-template-columns:1fr 1fr;gap:12px}
  @media(max-width:650px){.fieldRow{grid-template-columns:1fr}}
  .labelX{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin:0 0 8px 0;}
  .inputX,.selectX,.textareaX{width:100%;border:1px solid rgba(107,63,42,.22);border-radius:14px;padding:12px;outline:none;font-size:13px;background:#fff;color:#111;}
  .textareaX{min-height:92px;resize:vertical}

  .summaryItem{display:grid;grid-template-columns:64px 1fr;gap:12px;padding:12px;border:1px solid rgba(0,0,0,.08);border-radius:16px;background:#fff;margin-bottom:12px;}
  .summaryItem img{width:64px;height:64px;border-radius:14px;object-fit:cover;background:#f3efe9;border:1px solid rgba(0,0,0,.06);}
  .sumTop{display:flex;justify-content:space-between;gap:10px;align-items:flex-start}
  .sumName{margin:0;font-size:13px;font-weight:600;font-family: ui-serif, Georgia, "Times New Roman", serif;line-height:1.25;color:#111;}
  .sumPrice{font-weight:800;color:var(--brown);font-size:13px;white-space:nowrap}
  .sumMeta{margin-top:6px;color:#666;font-size:12px;line-height:1.6}
  .sumQty{margin-top:8px;display:inline-flex;gap:8px;align-items:center}
  .qtyPill{font-size:11px;padding:7px 10px;border-radius:999px;border:1px solid rgba(0,0,0,.10);background:var(--soft);letter-spacing:.10em;text-transform:uppercase;color:#3b2a1f;}

  .totalBox{margin-top:14px;border-top:1px solid rgba(0,0,0,.08);padding-top:14px;}
  .rowT{display:flex;justify-content:space-between;align-items:center;margin:10px 0;color:#444;font-size:13px}
  .rowT strong{font-size:16px;color:var(--brown)}
  .payNote{margin-top:10px;font-size:12px;color:#666;line-height:1.6;}

  .btnPrimaryX{width:100%;border:none;border-radius:14px;padding:14px;background:#6B3F2A;color:#fff;font-size:12px;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;margin-top:12px;}
  .btnPrimaryX:hover{filter:brightness(.95)}
  .btnGhostX{width:100%;margin-top:10px;border-radius:14px;padding:12px;border:1px solid rgba(0,0,0,.15);background:#fff;font-size:12px;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;}
  .btnGhostX:hover{background:#f7f2ee}

  .emptyState{padding:18px;color:#666;line-height:1.8;font-size:13px;border:1px dashed rgba(0,0,0,.18);border-radius:16px;background:linear-gradient(180deg,#ffffff 0%, #fbfaf8 100%);}

  .sectionHead{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;}
  .viewAll{font-size:12px;color:var(--brown);text-decoration:none;letter-spacing:.10em;text-transform:uppercase;}
  .viewAll:hover{text-decoration:underline;}
</style>
@endpush

@section('content')
<div class="checkoutWrap">
  <div class="sectionHead" style="margin:14px 0 18px;">
    <h2 style="margin:0;font-family: ui-serif, Georgia, 'Times New Roman', serif; letter-spacing:.12em; text-transform:uppercase;">
      Checkout
    </h2>
    <a class="viewAll" href="{{ url('/cart') }}">Back to Cart</a>
  </div>

  @if(session('error'))
    <div class="boxCard" style="margin-bottom:14px;">
      <div class="boxBody" style="padding:14px 18px;color:#8b2c2c;">
        <b style="letter-spacing:.10em;text-transform:uppercase;">Error</b>
        <p style="margin:10px 0 0;">{{ session('error') }}</p>
      </div>
    </div>
  @endif

  @if($errors->any())
    <div class="boxCard" style="margin-bottom:14px;">
      <div class="boxBody" style="padding:14px 18px;color:#8b2c2c;">
        <b style="letter-spacing:.10em;text-transform:uppercase;">Please fix</b>
        <ul style="margin:10px 0 0;padding-left:18px;line-height:1.7;">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <div class="checkoutGrid">

    {{-- LEFT --}}
    <div class="boxCard">
      <div class="boxHead">
        <h2>Shipping Details</h2>
        <div style="font-size:12px;color:#666;">Secure checkout</div>
      </div>

      <div class="boxBody">
        <form method="POST" action="{{ route('checkout.place') }}" id="checkoutForm">
          @csrf

          <div class="fieldRow">
            <div>
              <div class="labelX">First Name</div>
              <input class="inputX" name="first_name" required placeholder="First name" value="{{ old('first_name', auth()->user()->name ?? '') }}" />
            </div>
            <div>
              <div class="labelX">Last Name</div>
              <input class="inputX" name="last_name" required placeholder="Last name" value="{{ old('last_name') }}" />
            </div>
          </div>

          <div class="fieldRow" style="margin-top:12px;">
            <div>
              <div class="labelX">Email</div>
              <input class="inputX" name="email" type="email" required placeholder="email@example.com" value="{{ old('email', auth()->user()->email ?? '') }}" />
            </div>
            <div>
              <div class="labelX">Phone</div>
              <input class="inputX" name="phone" required placeholder="+1 234 567 890" value="{{ old('phone') }}" />
            </div>
          </div>

          <div style="margin-top:12px;">
            <div class="labelX">Address</div>
            <input class="inputX" name="address" required placeholder="Street / Area" value="{{ old('address') }}" />
          </div>

          <div class="fieldRow" style="margin-top:12px;">
            <div>
              <div class="labelX">City</div>
              <input class="inputX" name="city" required placeholder="City" value="{{ old('city') }}" />
            </div>
            <div>
              <div class="labelX">Country</div>
              <input class="inputX" name="country" required placeholder="Country" value="{{ old('country') }}" />
            </div>
          </div>

          <div class="fieldRow" style="margin-top:12px;">
            <div>
              <div class="labelX">Postal Code</div>
              <input class="inputX" name="postal_code" placeholder="Postal code" value="{{ old('postal_code') }}" />
            </div>
            <div>
              <div class="labelX">Payment Method</div>
              <select class="selectX" name="payment_method" required id="payment_method">
                <option value="cod"  {{ old('payment_method','cod')==='cod' ? 'selected' : '' }}>Cash on Delivery</option>
                <option value="stripe" {{ old('payment_method')==='stripe' ? 'selected' : '' }}>Credit/Debit Card (Stripe)</option>
                <option value="bank" {{ old('payment_method')==='bank' ? 'selected' : '' }}>Bank Transfer</option>
              </select>
            </div>
          </div>

          <div style="margin-top:12px;">
            <div class="labelX">Order Notes (optional)</div>
            <textarea class="textareaX" name="notes" placeholder="Any delivery notes...">{{ old('notes') }}</textarea>
          </div>

          <button class="btnPrimaryX" type="submit" id="placeOrderBtn">Place Order</button>
          <button class="btnGhostX" type="button" onclick="window.location.href='{{ url('/shop') }}'">Continue Shopping</button>

          <div class="payNote">
            By placing your order, you agree to our shipping & return policies.
          </div>
        </form>
      </div>
    </div>

    {{-- RIGHT --}}
    <div class="boxCard">
      <div class="boxHead">
        <h2>Order Summary</h2>
        <div style="font-size:12px;color:#666;">{{ $items->count() }} items</div>
      </div>

      <div class="boxBody">

        @if($items->isEmpty())
          <div class="emptyState">
            Your cart is empty. Please add products first.
            <div style="margin-top:10px;">
              <button class="btnPrimaryX" type="button" onclick="window.location.href='{{ url('/shop') }}'">Go to Shop</button>
            </div>
          </div>
        @else
          @foreach($items as $it)
            @php
              $img = $it->img ?? null;
              $name = $it->name ?? 'Product';
              $price = (float)($it->price ?? 0);
              $qty = (int)($it->qty ?? 1);
            @endphp

            <div class="summaryItem">
              <img src="{{ image_url($img, 'assets/img/placeholder.jpg') }}" alt="{{ $name }}" onerror="this.src='{{ asset('assets/img/placeholder.jpg') }}'">
              <div>
                <div class="sumTop">
                  <h4 class="sumName">{{ $name }}</h4>
                  <div class="sumPrice">${{ number_format($price, 0) }}</div>
                </div>
                <div class="sumMeta">Premium Leather • Luxury Finish</div>
                <div class="sumQty">
                  <span class="qtyPill">QTY {{ $qty }}</span>
                  <span class="qtyPill">TOTAL ${{ number_format($price * $qty, 0) }}</span>
                </div>
              </div>
            </div>
          @endforeach

          <div class="totalBox">
            <div class="rowT"><div>Subtotal</div><div>${{ number_format($total ?? 0, 0) }}</div></div>
            <div class="rowT"><div>Shipping</div><div>$0</div></div>
            <div class="rowT"><div><strong>Total</strong></div><div><strong>${{ number_format($total ?? 0, 0) }}</strong></div></div>
            <div class="payNote">By placing your order, you agree to our shipping & return policies.</div>
          </div>
        @endif

      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
  // Handle Stripe payment method selection
  document.getElementById('payment_method')?.addEventListener('change', function() {
    const form = document.getElementById('checkoutForm');
    const btn = document.getElementById('placeOrderBtn');
    
    if (this.value === 'stripe') {
      // Form will be intercepted by JavaScript to redirect to Stripe
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        // The form submission will be handled by the existing Stripe redirect logic
        // For now, just submit normally - the backend will handle Stripe redirect
      });
    }
  });

  // Update cart count on page load
  document.addEventListener('DOMContentLoaded', async () => {
    try{
      const r = await fetch("{{ route('cart.count') }}", { headers: { "Accept":"application/json" }});
      const j = await r.json();
      document.querySelectorAll("[data-cart-count]").forEach(el => el.textContent = j.count ?? 0);
    }catch(e){
      console.error('Failed to update cart count:', e);
    }
  });
</script>
@endpush
