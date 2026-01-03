@extends('layouts.master')

@section('title', 'Order Details • Legacy Leather Works')

@section('content')
<div class="container" style="padding:34px 18px;">
  <div style="margin-bottom:24px;">
    <a href="{{ route('dashboard') }}" style="display:inline-flex;align-items:center;gap:8px;color:var(--brown);text-decoration:none;font-size:13px;margin-bottom:12px;">
      <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h1 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:28px;color:#2a1b14;">
      Order Details
    </h1>
    <p style="margin:8px 0 0;color:#666;font-size:14px;">Order Reference: <strong>{{ $order->order_ref }}</strong></p>
  </div>

  <div class="grid" style="grid-template-columns: 1fr 400px; gap:20px;">
    {{-- Order Items --}}
    <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;overflow:hidden;background:#fff;">
      <div style="padding:18px;border-bottom:1px solid rgba(0,0,0,.08);background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);">
        <h2 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:18px;color:#2a1b14;">
          Order Items
        </h2>
      </div>
      <div style="padding:18px;">
        @foreach($order->items as $item)
          <div style="display:grid;grid-template-columns:80px 1fr;gap:14px;padding:14px;border:1px solid rgba(0,0,0,.08);border-radius:14px;margin-bottom:12px;background:#fff;">
            <img src="{{ $item->product_image ? (str_starts_with($item->product_image, 'http') ? $item->product_image : asset($item->product_image)) : asset('assets/img/placeholder.jpg') }}" 
                 alt="{{ $item->product_name }}" 
                 style="width:80px;height:80px;border-radius:12px;object-fit:cover;border:1px solid rgba(0,0,0,.08);">
            <div>
              <h4 style="margin:0 0 6px;font-size:14px;font-weight:600;color:#2a1b14;">{{ $item->product_name }}</h4>
              <div style="font-size:12px;color:#666;margin-bottom:8px;">
                Quantity: {{ $item->qty }} × ${{ number_format($item->unit_price, 0) }}
              </div>
              <div style="font-size:14px;font-weight:800;color:var(--brown);">
                ${{ number_format($item->line_total, 0) }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Order Summary --}}
    <div>
      <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;overflow:hidden;background:#fff;margin-bottom:16px;">
        <div style="padding:18px;border-bottom:1px solid rgba(0,0,0,.08);background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);">
          <h2 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:18px;color:#2a1b14;">
            Order Summary
          </h2>
        </div>
        <div style="padding:18px;">
          <div style="display:flex;justify-content:space-between;margin-bottom:12px;font-size:14px;color:#666;">
            <span>Subtotal</span>
            <span>${{ number_format($order->subtotal, 0) }}</span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:12px;font-size:14px;color:#666;">
            <span>Shipping</span>
            <span>${{ number_format($order->shipping, 0) }}</span>
          </div>
          <div style="border-top:1px solid rgba(0,0,0,.08);padding-top:12px;margin-top:12px;display:flex;justify-content:space-between;font-size:16px;font-weight:800;color:var(--brown);">
            <span>Total</span>
            <span>${{ number_format($order->total, 0) }}</span>
          </div>
        </div>
      </div>

      <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;overflow:hidden;background:#fff;margin-bottom:16px;">
        <div style="padding:18px;border-bottom:1px solid rgba(0,0,0,.08);background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);">
          <h2 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:18px;color:#2a1b14;">
            Shipping Address
          </h2>
        </div>
        <div style="padding:18px;font-size:14px;color:#666;line-height:1.8;">
          <div><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></div>
          <div>{{ $order->address }}</div>
          <div>{{ $order->city }}, {{ $order->country }} {{ $order->postal_code }}</div>
          <div style="margin-top:12px;">
            <div><strong>Email:</strong> {{ $order->email }}</div>
            <div><strong>Phone:</strong> {{ $order->phone }}</div>
          </div>
        </div>
      </div>

      <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;overflow:hidden;background:#fff;">
        <div style="padding:18px;border-bottom:1px solid rgba(0,0,0,.08);background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);">
          <h2 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:18px;color:#2a1b14;">
            Order Status
          </h2>
        </div>
        <div style="padding:18px;">
          <div style="margin-bottom:12px;">
            <span style="padding:8px 12px;border-radius:999px;font-size:12px;letter-spacing:.10em;text-transform:uppercase;background:rgba(107,63,42,.12);color:var(--brown);border:1px solid rgba(107,63,42,.20);">
              {{ ucfirst($order->status) }}
            </span>
          </div>
          <div style="font-size:13px;color:#666;">
            <div>Placed: {{ $order->created_at->format('M d, Y g:i A') }}</div>
            @if($order->updated_at != $order->created_at)
              <div>Updated: {{ $order->updated_at->format('M d, Y g:i A') }}</div>
            @endif
          </div>
          @if($order->notes)
            <div style="margin-top:12px;padding:12px;background:#fbfaf8;border-radius:12px;font-size:13px;color:#666;">
              <strong>Notes:</strong> {{ $order->notes }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<style>
@media(max-width:980px){
  .grid{grid-template-columns:1fr !important;}
}
</style>
@endsection

