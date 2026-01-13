@extends('admin.layout')
@section('title','Dashboard')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Dashboard</h1>
    <p class="sub">Overview of your Legacy Leather Works store</p>
  </div>
  <div class="actions">
    <a class="btn ghost" href="{{ url('/') }}" target="_blank">View Website</a>
  </div>
</div>

{{-- KPI Cards --}}
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
  <div class="card">
    <h3>Total Products</h3>
    <div class="kpi">{{ number_format($productsCount) }}</div>
    <div class="mini">Products in catalog</div>
    <a href="{{ route('admin.products.index') }}" class="btn ghost" style="margin-top:12px;display:inline-block;width:100%;text-align:center;">Manage</a>
  </div>

  <div class="card">
    <h3>Total Orders</h3>
    <div class="kpi">{{ number_format($ordersCount) }}</div>
    <div class="mini">All time orders</div>
    <a href="{{ route('admin.orders.index') }}" class="btn ghost" style="margin-top:12px;display:inline-block;width:100%;text-align:center;">View Orders</a>
  </div>

  <div class="card">
    <h3>Total Revenue</h3>
    <div class="kpi">${{ number_format($totalRevenue, 0) }}</div>
    <div class="mini">Completed orders revenue</div>
  </div>

  <div class="card">
    <h3>Pending Orders</h3>
    <div class="kpi" style="color:var(--accent);">{{ number_format($pendingOrders) }}</div>
    <div class="mini">Requires attention</div>
  </div>

  <div class="card">
    <h3>Categories</h3>
    <div class="kpi">{{ number_format($categoriesCount) }}</div>
    <div class="mini">Product categories</div>
  </div>

  <div class="card">
    <h3>Banners</h3>
    <div class="kpi">{{ number_format($bannersCount) }}</div>
    <div class="mini">Active banners</div>
  </div>
</div>

{{-- Charts and Stats --}}
<div class="grid" style="grid-template-columns: 1fr 1fr; margin-top:16px;">
  {{-- Orders by Status --}}
  <div class="card">
    <h3>Orders by Status</h3>
    <div style="margin-top:12px;">
      @foreach($ordersByStatus as $status => $count)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--line);">
          <span style="text-transform:capitalize;">{{ $status }}</span>
          <span class="status">{{ $count }}</span>
        </div>
      @endforeach
      @if(empty($ordersByStatus))
        <div class="mini" style="text-align:center;padding:20px;">No orders yet</div>
      @endif
    </div>
  </div>

  {{-- Top Products --}}
  <div class="card">
    <h3>Top Selling Products</h3>
    <div style="margin-top:12px;">
      @forelse($topProducts as $product)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--line);">
          <span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $product->product_name }}</span>
          <span class="status">{{ $product->total_sold }} sold</span>
        </div>
      @empty
        <div class="mini" style="text-align:center;padding:20px;">No sales data yet</div>
      @endforelse
    </div>
  </div>
</div>

{{-- Revenue Chart --}}
@if($revenueByMonth->count() > 0)
<div class="card" style="margin-top:16px;">
  <h3>Revenue (Last 6 Months)</h3>
  <div style="margin-top:16px;display:flex;align-items:flex-end;gap:8px;height:200px;">
    @php
      $maxRevenue = $revenueByMonth->max('revenue') ?: 1;
    @endphp
    @foreach($revenueByMonth as $month)
      @php
        $height = ($month->revenue / $maxRevenue) * 100;
        $monthLabel = \Carbon\Carbon::createFromFormat('Y-m', $month->month)->format('M Y');
      @endphp
      <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:8px;">
        <div style="width:100%;background:linear-gradient(180deg, var(--accent), var(--accent2));border-radius:8px 8px 0 0;min-height:{{ max(20, $height) }}%;max-height:100%;"></div>
        <div style="font-size:11px;color:var(--muted);text-align:center;transform:rotate(-45deg);transform-origin:center;white-space:nowrap;">{{ $monthLabel }}</div>
      </div>
    @endforeach
  </div>
</div>
@endif

{{-- Recent Orders --}}
<div class="card" style="margin-top:16px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
    <h3 style="margin:0;">Recent Orders</h3>
    <a href="{{ route('admin.orders.index') }}" class="btn ghost" style="font-size:11px;">View All</a>
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
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentOrders as $order)
          <tr>
            <td><strong>{{ $order->order_ref }}</strong></td>
            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
            <td>${{ number_format($order->total, 2) }}</td>
            <td>
              <span class="status" style="
                @if($order->status === 'completed') background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);
                @elseif($order->status === 'pending') background:rgba(251,191,36,.15);border-color:rgba(251,191,36,.3);
                @elseif($order->status === 'cancelled') background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);
                @endif
              ">{{ ucfirst($order->status) }}</span>
            </td>
            <td>{{ $order->created_at->format('M d, Y') }}</td>
            <td>
              <a href="{{ route('admin.orders.show', $order) }}" class="btn ghost" style="font-size:11px;padding:6px 10px;">View</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center;padding:20px;color:var(--muted);">No orders yet</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
