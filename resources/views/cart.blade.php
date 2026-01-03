@extends('layouts.master')

@section('title', 'Cart — Legacy Leather Works')

@section('content')
@php
  $count = $items->sum(fn($i)=> (int)($i->qty ?? 0));
  $subtotal = $items->sum(fn($i)=> (float)($i->price ?? 0) * (int)($i->qty ?? 0));
@endphp

<main class="cartPageWrap">
  <h1 class="cartTitle">Your Cart</h1>

  <div class="cartGrid">
    {{-- LEFT: items --}}
    <div class="cartBox">
      <div class="cartBoxHead">
        <h3>Items</h3>
        <div style="font-size:12px;color:#666;letter-spacing:.10em;text-transform:uppercase" data-cart-item-count>
          {{ $count }} Items
        </div>
      </div>

      <div class="cartBoxBody">
        @if($items->isEmpty())
          <div class="emptyCart">
            Your cart is empty.<br/>
            Please add products from Shop.
          </div>
        @else
          @foreach($items as $item)
            @php
              $name = $item->name ?? 'Product';
              $price = (float)($item->price ?? 0);
              $qty = (int)($item->qty ?? 1);
              $img = $item->img ?? 'assets/img/placeholder.jpg';
              $lineTotal = $price * $qty;
            @endphp

            <div class="cartRowItem" data-cart-item="{{ $item->id }}">
              <img src="{{ Str::startsWith($img, ['http://','https://','/']) ? $img : asset($img) }}"
                   alt="{{ $name }}"
                   onerror="this.src='{{ asset('assets/img/placeholder.jpg') }}'">

              <div>
                <div class="cartRowTop">
                  <h4>{{ $name }}</h4>
                  <div class="cartRowPrice" data-item-total="{{ $item->id }}">${{ number_format($lineTotal, 0) }}</div>
                </div>

                <div class="cartRowMeta">Premium Leather • Luxury Finish</div>

                <div class="cartQtyRow">
                  <div class="qtyBox">
                    {{-- minus --}}
                    <button class="qtyBtn cartUpdateBtn" type="button" 
                            data-item-id="{{ $item->id }}"
                            data-action="decrease">−</button>

                    <div class="qtyNum" data-item-qty="{{ $item->id }}">{{ $qty }}</div>

                    {{-- plus --}}
                    <button class="qtyBtn cartUpdateBtn" type="button"
                            data-item-id="{{ $item->id }}"
                            data-action="increase">+</button>
                  </div>

                  {{-- remove --}}
                  <button class="removeBtn cartRemoveBtn" type="button"
                          data-item-id="{{ $item->id }}">Remove</button>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>

    {{-- RIGHT: summary --}}
    <div class="cartBox">
      <div class="cartBoxHead">
        <h3>Summary</h3>
      </div>

      <div class="summaryBox">
        <div class="sumRow">
          <div>Subtotal</div>
          <div data-cart-subtotal>${{ number_format($subtotal, 0) }}</div>
        </div>

        <div class="sumRow">
          <div>Shipping</div>
          <div style="color:#666;font-size:12px">Calculated at checkout</div>
        </div>

        <div class="sumRow" style="border-top:1px solid rgba(0,0,0,.08);padding-top:12px;margin-top:12px">
          <div>Total</div>
          <strong data-cart-total>${{ number_format($subtotal, 0) }}</strong>
        </div>

        <button class="sumBtn" type="button" onclick="window.location.href='{{ route('checkout') }}'">Checkout</button>
        <button class="sumGhost" type="button" onclick="window.location.href='{{ url('/shop') }}'">Continue Shopping</button>
      </div>
    </div>
  </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/app.js') }}"></script>
<script>
// Helper function to make AJAX requests
async function cartRequest(url, data) {
  const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
  const response = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": token,
      "Accept": "application/json",
    },
    body: JSON.stringify(data)
  });

  if (!response.ok) {
    const errorText = await response.text();
    throw new Error(errorText || 'Request failed');
  }

  return response.json();
}

// Update cart count in header
async function updateCartCount() {
  try {
    const r = await fetch("{{ route('cart.count') }}", { headers: { "Accept":"application/json" }});
    const j = await r.json();
    document.querySelectorAll("[data-cart-count]").forEach(el => el.textContent = j.count ?? 0);
  } catch(e) {
    console.error("Failed to update cart count:", e);
  }
}

// Update cart totals
function updateCartTotals(subtotal) {
  const formatted = "$" + Math.round(subtotal).toLocaleString();
  document.querySelectorAll("[data-cart-subtotal]").forEach(el => el.textContent = formatted);
  document.querySelectorAll("[data-cart-total]").forEach(el => el.textContent = formatted);
}

// Handle quantity update (increase/decrease)
document.addEventListener("click", async (e) => {
  const btn = e.target.closest(".cartUpdateBtn");
  if (!btn) return;

  e.preventDefault();
  const itemId = parseInt(btn.dataset.itemId);
  const action = btn.dataset.action;
  
  if (!itemId) return;

  // Get current quantity
  const qtyEl = document.querySelector(`[data-item-qty="${itemId}"]`);
  if (!qtyEl) return;

  let currentQty = parseInt(qtyEl.textContent) || 1;
  let newQty = action === "increase" ? currentQty + 1 : Math.max(1, currentQty - 1);

  // Disable buttons temporarily
  btn.disabled = true;

  try {
    const data = await cartRequest("{{ route('cart.update') }}", {
      id: itemId,
      qty: newQty
    });

    // Update quantity display
    qtyEl.textContent = data.item.qty;

    // Update line total
    const lineTotalEl = document.querySelector(`[data-item-total="${itemId}"]`);
    if (lineTotalEl) {
      lineTotalEl.textContent = "$" + Math.round(data.item.line_total).toLocaleString();
    }

    // Update cart totals
    updateCartTotals(data.subtotal);

    // Update cart count in header
    await updateCartCount();

    // Update item count display
    document.querySelectorAll("[data-cart-item-count]").forEach(el => {
      el.textContent = data.count + " Items";
    });

    // If quantity is 0, remove the item (shouldn't happen, but just in case)
    if (data.item.qty <= 0) {
      const itemRow = document.querySelector(`[data-cart-item="${itemId}"]`);
      if (itemRow) {
        itemRow.remove();
        // Check if cart is empty
        const remainingItems = document.querySelectorAll("[data-cart-item]");
        if (remainingItems.length === 0) {
          location.reload(); // Reload to show empty cart message
        }
      }
    }

  } catch (error) {
    console.error("Update cart error:", error);
    alert("Failed to update quantity. Please try again.");
  } finally {
    btn.disabled = false;
  }
});

// Handle remove item
document.addEventListener("click", async (e) => {
  const btn = e.target.closest(".cartRemoveBtn");
  if (!btn) return;

  e.preventDefault();
  const itemId = parseInt(btn.dataset.itemId);
  
  if (!itemId) return;

  if (!confirm("Are you sure you want to remove this item from your cart?")) {
    return;
  }

  // Disable button
  btn.disabled = true;
  btn.textContent = "Removing...";

  try {
    const data = await cartRequest("{{ route('cart.remove') }}", {
      id: itemId
    });

    // Remove item from DOM
    const itemRow = document.querySelector(`[data-cart-item="${itemId}"]`);
    if (itemRow) {
      itemRow.remove();
    }

    // Update cart totals
    updateCartTotals(data.subtotal);

    // Update cart count in header
    await updateCartCount();

    // Update item count in header
    document.querySelectorAll("[data-cart-item-count]").forEach(el => {
      el.textContent = data.count + " Items";
    });

    // Check if cart is empty
    const remainingItems = document.querySelectorAll("[data-cart-item]");
    if (remainingItems.length === 0) {
      location.reload(); // Reload to show empty cart message
    }

  } catch (error) {
    console.error("Remove cart item error:", error);
    alert("Failed to remove item. Please try again.");
    btn.disabled = false;
    btn.textContent = "Remove";
  }
});

// Load cart count on page load
document.addEventListener("DOMContentLoaded", async () => {
  await updateCartCount();
});
</script>
@endpush
