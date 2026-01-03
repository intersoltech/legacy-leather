{{-- resources/views/thank-you.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Thank You — Legacy Leather Works</title>

  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
  <style>{!! @file_get_contents(public_path('assets/inline-home.css')) !!}</style>

  <style>
    .wrap{max-width:980px;margin:26px auto;padding:0 18px}
    .card{
      background:#fff;border:1px solid rgba(0,0,0,.10);border-radius:22px;
      box-shadow:0 18px 60px rgba(0,0,0,.10);overflow:hidden;
    }
    .head{
      padding:18px 20px;border-bottom:1px solid rgba(0,0,0,.08);
      background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);
      display:flex;justify-content:space-between;gap:12px;align-items:center;
    }
    .head h1{margin:0;font-family: ui-serif, Georgia, serif;letter-spacing:.14em;text-transform:uppercase;font-size:18px;color:#3b2a1f;}
    .body{padding:18px 20px}
    .muted{color:#666;font-size:13px;line-height:1.8}
    .pill{display:inline-flex;border:1px solid rgba(0,0,0,.12);background:#fbfaf8;border-radius:999px;padding:10px 14px;
      font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#3b2a1f;
    }
    .btn{
      display:inline-flex;align-items:center;justify-content:center;text-decoration:none;
      border-radius:999px;padding:12px 16px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;
      border:1px solid rgba(0,0,0,.15);background:#fff;color:#111;
    }
    .btn.primary{background:#6B3F2A;border-color:#6B3F2A;color:#fff;}
    .btn:hover{filter:brightness(.98)}
    .row{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px}
  </style>
</head>
<body>

<div class="wrap">
  <div class="card">
    <div class="head">
      <h1>Order Confirmed</h1>
      <span class="pill">{{ $order->order_number ?? '—' }}</span>
    </div>
    <div class="body">
      @if(!$order)
        <div class="muted">Order not found.</div>
        <div class="row">
          <a class="btn primary" href="{{ url('/shop') }}">Go to Shop</a>
        </div>
      @else
        <div class="muted">
          Thank you <b>{{ $order->first_name }} {{ $order->last_name }}</b> — we received your order.
          You can track it anytime using your order number.
        </div>

        <div class="row">
          <a class="btn primary" href="{{ route('track.order') }}">Track Order</a>
          <a class="btn" href="{{ url('/shop') }}">Continue Shopping</a>
        </div>
      @endif
    </div>
  </div>
</div>

</body>
</html>
