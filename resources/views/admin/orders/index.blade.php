@extends('admin.layout')
@section('title','Orders')

@section('content')
<div class="pagetitle">
  <h1>Orders</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Orders</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Orders</h5>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">Order Ref</th>
                <th scope="col">Customer</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $o)
                <tr>
                  <td><strong>{{ $o->order_ref ?? $o->order_number ?? ('#'.$o->id) }}</strong></td>
                  <td>{{ $o->first_name ?? '' }} {{ $o->last_name ?? '' }}</td>
                  <td>${{ number_format($o->total ?? 0, 2) }}</td>
                  <td>
                    <span class="badge 
                      @if($o->status === 'completed') bg-success
                      @elseif($o->status === 'pending') bg-warning
                      @elseif($o->status === 'cancelled') bg-danger
                      @else bg-info
                      @endif
                    ">{{ ucfirst($o->status ?? 'pending') }}</span>
                  </td>
                  <td>{{ optional($o->created_at)->format('d M Y') }}</td>
                  <td>
                    <a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-eye"></i> View
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4" style="color:#858585;">No orders yet</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          <!-- End Table with stripped rows -->
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
