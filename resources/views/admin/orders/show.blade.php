@extends('admin.layout')
@section('title','Order')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Order Details</h1>
    <p class="sub">{{ $order->order_ref ?? $order->order_number ?? ('#'.$order->id) }}</p>
  </div>
  <a class="btn ghost" href="{{ route('admin.orders.index') }}">Back</a>
</div>

<div class="grid">
  <div class="card">
    <h3>Customer</h3>
    <div class="mini">
      <b>{{ $order->first_name ?? '' }} {{ $order->last_name ?? '' }}</b><br>
      {{ $order->email ?? '' }}<br>
      {{ $order->phone ?? '' }}
    </div>
  </div>

  <div class="card">
    <h3>Status Update</h3>
    <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
      @csrf
      <label>Status</label>
      <select class="input" name="status" required>
        @foreach(['pending','processing','dispatched','shipped','delivered','cancelled'] as $st)
          <option value="{{ $st }}" {{ ($order->status==$st)?'selected':'' }}>{{ $st }}</option>
        @endforeach
      </select>
      <button class="btn" type="submit" style="margin-top:12px">Update Status</button>
    </form>
  </div>
</div>

<div class="card" style="margin-top:16px">
  <h3>Items</h3>
  <div class="tableWrap" style="margin-top:10px">
    <table>
      <thead>
        <tr>
          <th>Product</th><th>Qty</th><th>Unit</th><th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $it)
        <tr>
          <td>{{ $it->product_name ?? '' }}</td>
          <td>{{ $it->qty ?? 1 }}</td>
          <td>${{ number_format($it->unit_price ?? 0,2) }}</td>
          <td>${{ number_format($it->line_total ?? 0,2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
