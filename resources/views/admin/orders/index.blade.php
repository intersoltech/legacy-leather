@extends('admin.layout')
@section('title','Orders')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Orders</h1>
    <p class="sub">View orders + update delivery status</p>
  </div>
</div>

<div class="tableWrap">
  <table>
    <thead>
      <tr>
        <th>Order Ref</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Status</th>
        <th>Date</th>
        <th style="width:140px;">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($orders as $o)
      <tr>
        <td><b>{{ $o->order_ref ?? $o->order_number ?? ('#'.$o->id) }}</b></td>
        <td>{{ $o->first_name ?? '' }} {{ $o->last_name ?? '' }}</td>
        <td>${{ number_format($o->total ?? 0, 2) }}</td>
        <td><span class="status">{{ $o->status ?? 'pending' }}</span></td>
        <td>{{ optional($o->created_at)->format('d M Y') }}</td>
        <td>
          <a class="btn ghost small" href="{{ route('admin.orders.show', $o->id) }}">View</a>
        </td>
      </tr>
      @endforeach
      @if($orders->count()==0)
        <tr><td colspan="6" style="color:rgba(255,255,255,.7)">No orders.</td></tr>
      @endif
    </tbody>
  </table>
</div>
@endsection
