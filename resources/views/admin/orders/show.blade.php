@extends('admin.layout')
@section('title','Order Details')

@section('content')
<div class="pagetitle">
  <h1>Order Details</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
      <li class="breadcrumb-item active">{{ $order->order_ref ?? $order->order_number ?? ('#'.$order->id) }}</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    
    <!-- Left Column -->
    <div class="col-lg-8">
      
      <!-- Order Items -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Order Items</h5>
          <table class="table table-borderless">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($items as $item)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    @if($item->product_image)
                      <img src="{{ image_url($item->product_image, 'assets/img/logo.png') }}" 
                           alt="{{ $item->product_name }}" 
                           style="width:50px;height:50px;object-fit:cover;border-radius:4px;margin-right:12px;">
                    @endif
                    <span>{{ $item->product_name ?? 'N/A' }}</span>
                  </div>
                </td>
                <td>{{ $item->qty ?? 1 }}</td>
                <td>${{ number_format($item->unit_price ?? 0, 2) }}</td>
                <td><strong>${{ number_format($item->line_total ?? 0, 2) }}</strong></td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center py-4" style="color:#858585;">No items found</td>
              </tr>
              @endforelse
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                <td><strong>${{ number_format($order->subtotal ?? 0, 2) }}</strong></td>
              </tr>
              @if($order->shipping > 0)
              <tr>
                <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                <td><strong>${{ number_format($order->shipping ?? 0, 2) }}</strong></td>
              </tr>
              @endif
              <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong style="font-size:1.2em;color:#4154f1;">${{ number_format($order->total ?? 0, 2) }}</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Shipping Address -->
      @if($order->address || $order->city || $order->country)
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Shipping Address</h5>
          <div class="row mb-3">
            <div class="col-sm-12">
              <p class="mb-1"><strong>{{ $order->first_name ?? '' }} {{ $order->last_name ?? '' }}</strong></p>
              @if($order->address)
                <p class="mb-1">{{ $order->address }}</p>
              @endif
              @if($order->city || $order->country || $order->postal_code)
                <p class="mb-1">
                  @if($order->city){{ $order->city }}, @endif
                  @if($order->country){{ $order->country }} @endif
                  @if($order->postal_code){{ $order->postal_code }}@endif
                </p>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endif

    </div><!-- End Left Column -->

    <!-- Right Column -->
    <div class="col-lg-4">
      
      <!-- Order Information -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Order Information</h5>
          
          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">Order Ref:</label>
            <div class="col-sm-7">
              <strong>{{ $order->order_ref ?? $order->order_number ?? ('#'.$order->id) }}</strong>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">Status:</label>
            <div class="col-sm-7">
              <span class="badge 
                @if($order->status === 'completed') bg-success
                @elseif($order->status === 'pending') bg-warning
                @elseif($order->status === 'cancelled') bg-danger
                @elseif($order->status === 'processing') bg-info
                @elseif($order->status === 'shipped' || $order->status === 'dispatched') bg-primary
                @elseif($order->status === 'delivered') bg-success
                @else bg-secondary
                @endif
              ">{{ ucfirst($order->status ?? 'pending') }}</span>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">Date:</label>
            <div class="col-sm-7">
              {{ $order->created_at->format('M d, Y h:i A') }}
            </div>
          </div>

          @if($order->payment_method)
          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">Payment:</label>
            <div class="col-sm-7">
              <span class="badge bg-info">{{ ucfirst($order->payment_method) }}</span>
            </div>
          </div>
          @endif

          @if($order->currency)
          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">Currency:</label>
            <div class="col-sm-7">
              {{ strtoupper($order->currency) }}
            </div>
          </div>
          @endif

        </div>
      </div>

      <!-- Customer Information -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Customer Information</h5>
          
          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">Name:</label>
            <div class="col-sm-7">
              <strong>{{ $order->first_name ?? '' }} {{ $order->last_name ?? '' }}</strong>
            </div>
          </div>

          @if($order->email)
          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">Email:</label>
            <div class="col-sm-7">
              <a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
            </div>
          </div>
          @endif

          @if($order->phone)
          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">Phone:</label>
            <div class="col-sm-7">
              <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a>
            </div>
          </div>
          @endif

          @if($order->user)
          <div class="row mb-3">
            <label class="col-sm-5 col-form-label">User Account:</label>
            <div class="col-sm-7">
              <a href="{{ route('admin.users.index') }}?search={{ $order->user->email }}" class="text-primary">
                {{ $order->user->name }}
              </a>
            </div>
          </div>
          @endif

        </div>
      </div>

      <!-- Update Status -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Update Status</h5>
          
          <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
            @csrf
            
            <div class="row mb-3">
              <label for="status" class="col-sm-12 col-form-label">Order Status</label>
              <div class="col-sm-12">
                <select class="form-select" name="status" id="status" required>
                  <option value="pending" {{ ($order->status == 'pending') ? 'selected' : '' }}>Pending</option>
                  <option value="processing" {{ ($order->status == 'processing') ? 'selected' : '' }}>Processing</option>
                  <option value="dispatched" {{ ($order->status == 'dispatched') ? 'selected' : '' }}>Dispatched</option>
                  <option value="shipped" {{ ($order->status == 'shipped') ? 'selected' : '' }}>Shipped</option>
                  <option value="delivered" {{ ($order->status == 'delivered') ? 'selected' : '' }}>Delivered</option>
                  <option value="completed" {{ ($order->status == 'completed') ? 'selected' : '' }}>Completed</option>
                  <option value="cancelled" {{ ($order->status == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-check-circle"></i> Update Status
                </button>
              </div>
            </div>
          </form>

          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

        </div>
      </div>

      <!-- Notes -->
      @if($order->notes)
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Order Notes</h5>
          <p class="mb-0">{{ $order->notes }}</p>
        </div>
      </div>
      @endif

    </div><!-- End Right Column -->

  </div>
</section>
@endsection
