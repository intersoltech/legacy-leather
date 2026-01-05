@extends('layouts.master')

@section('title', 'My Account • Legacy Leather Works')

@section('content')
<div class="container" style="padding:34px 18px;">
  <div style="margin-bottom:24px;">
    <h1 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:28px;color:#2a1b14;">
      My Account
    </h1>
    <p style="margin:8px 0 0;color:#666;font-size:14px;">Welcome back, {{ auth()->user()->name }}!</p>
  </div>

  {{-- Stats Cards --}}
  <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:24px;">
    <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;padding:18px;background:#fff;">
      <div style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;">Total Orders</div>
      <div style="font-size:32px;font-weight:800;color:var(--brown);">{{ $stats['total_orders'] }}</div>
    </div>
    <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;padding:18px;background:#fff;">
      <div style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;">Pending</div>
      <div style="font-size:32px;font-weight:800;color:#f59e0b;">{{ $stats['pending_orders'] }}</div>
    </div>
    <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;padding:18px;background:#fff;">
      <div style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;">Completed</div>
      <div style="font-size:32px;font-weight:800;color:#10b981;">{{ $stats['completed_orders'] }}</div>
    </div>
    <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;padding:18px;background:#fff;">
      <div style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;">Total Spent</div>
      <div style="font-size:32px;font-weight:800;color:var(--brown);">${{ number_format($stats['total_spent'], 0) }}</div>
    </div>
  </div>

  {{-- Quick Actions --}}
  <div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;">
    <a href="{{ route('profile.edit') }}" class="btn" style="display:inline-flex;align-items:center;gap:8px;padding:12px 18px;border-radius:14px;background:var(--brown);color:#fff;text-decoration:none;font-size:12px;letter-spacing:.12em;text-transform:uppercase;">
      <i class="bi bi-person"></i> Edit Profile
    </a>
    <a href="{{ route('shop') }}" class="btn" style="display:inline-flex;align-items:center;gap:8px;padding:12px 18px;border-radius:14px;background:#fff;border:1px solid rgba(0,0,0,.12);color:#111;text-decoration:none;font-size:12px;letter-spacing:.12em;text-transform:uppercase;">
      <i class="bi bi-bag"></i> Continue Shopping
    </a>
  </div>

  {{-- Order History --}}
  <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;overflow:hidden;background:#fff;">
    <div style="padding:18px;border-bottom:1px solid rgba(0,0,0,.08);background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);">
      <h2 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:18px;color:#2a1b14;">
        Order History
      </h2>
    </div>
    <div style="padding:18px;">
      @if($orders->count() > 0)
        <div style="display:grid;gap:12px;">
          @foreach($orders as $order)
            <div style="border:1px solid rgba(0,0,0,.08);border-radius:14px;padding:16px;background:#fff;">
              <div style="display:flex;justify-content:space-between;align-items:start;gap:16px;flex-wrap:wrap;">
                <div style="flex:1;">
                  <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <strong style="font-size:14px;color:#2a1b14;">{{ $order->order_ref }}</strong>
                    <span style="padding:6px 10px;border-radius:999px;font-size:11px;letter-spacing:.10em;text-transform:uppercase;background:rgba(107,63,42,.12);color:var(--brown);border:1px solid rgba(107,63,42,.20);">
                      {{ ucfirst($order->status) }}
                    </span>
                  </div>
                  <div style="font-size:13px;color:#666;margin-bottom:4px;">
                    Placed on {{ $order->created_at->format('M d, Y') }}
                  </div>
                  <div style="font-size:13px;color:#666;">
                    {{ $order->items->count() }} item(s) • Total: <strong style="color:var(--brown);">${{ number_format($order->total, 0) }}</strong>
                  </div>
                </div>
                <div>
                  <a href="{{ route('user.orders.show', $order) }}" class="btn" style="display:inline-flex;align-items:center;gap:6px;padding:10px 14px;border-radius:12px;background:var(--brown);color:#fff;text-decoration:none;font-size:11px;letter-spacing:.12em;text-transform:uppercase;">
                    View Details
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        @if(method_exists($orders, 'hasPages') && $orders->hasPages())
          <div style="margin-top:20px;display:flex;justify-content:center;gap:8px;">
            @if($orders->onFirstPage())
              <span style="padding:10px 14px;border-radius:12px;background:#f5f5f5;color:#999;font-size:12px;">Previous</span>
            @else
              <a href="{{ $orders->previousPageUrl() }}" style="padding:10px 14px;border-radius:12px;background:#fff;border:1px solid rgba(0,0,0,.12);color:#111;text-decoration:none;font-size:12px;">Previous</a>
            @endif
            <span style="padding:10px 14px;border-radius:12px;background:#f5f5f5;color:#666;font-size:12px;">Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</span>
            @if($orders->hasMorePages())
              <a href="{{ $orders->nextPageUrl() }}" style="padding:10px 14px;border-radius:12px;background:#fff;border:1px solid rgba(0,0,0,.12);color:#111;text-decoration:none;font-size:12px;">Next</a>
            @else
              <span style="padding:10px 14px;border-radius:12px;background:#f5f5f5;color:#999;font-size:12px;">Next</span>
            @endif
          </div>
        @endif
      @else
        <div style="text-align:center;padding:40px 20px;color:#666;">
          <i class="bi bi-inbox" style="font-size:48px;color:#ddd;margin-bottom:16px;display:block;"></i>
          <p style="margin:0;font-size:14px;">No orders yet.</p>
          <a href="{{ route('shop') }}" style="display:inline-block;margin-top:16px;padding:12px 18px;border-radius:14px;background:var(--brown);color:#fff;text-decoration:none;font-size:12px;letter-spacing:.12em;text-transform:uppercase;">
            Start Shopping
          </a>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection

