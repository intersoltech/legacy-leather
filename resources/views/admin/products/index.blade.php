@extends('admin.layout')
@section('title','Products')

@section('content')
<div class="pagetitle">
  <h1>Products</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Products</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Products</h5>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
              <i class="bi bi-plus-circle"></i> New Product
            </a>
          </div>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($products as $product)
                <tr>
                  <td>
                    @if($product->image)
                      <img src="{{ image_url($product->image) }}" alt="{{ $product->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                    @else
                      <div style="width:50px;height:50px;background:#3e3e42;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#858585;font-size:10px;">No Image</div>
                    @endif
                  </td>
                  <td><strong>{{ $product->name }}</strong></td>
                  <td style="color:#858585;font-size:12px;">{{ $product->slug }}</td>
                  <td>${{ number_format($product->price, 2) }}</td>
                  <td style="color:#858585;font-size:12px;">{{ $product->category ?? 'Uncategorized' }}</td>
                  <td>
                    <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                      {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                      </a>
                      <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this product?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                          <i class="bi bi-trash"></i> Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center py-4" style="color:#858585;">No products yet</td>
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
