@extends('admin.layout')
@section('title','Products')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Products</h1>
    <p class="sub">Manage products</p>
  </div>
  <div class="actions">
    <a href="{{ route('admin.products.create') }}" class="btn">+ New Product</a>
  </div>
</div>

@if(session('success'))
  <div class="card" style="background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);margin-top:16px;">
    <div style="color:#22c55e;">{{ session('success') }}</div>
  </div>
@endif

<div class="tableWrap" style="margin-top:16px;">
  <table>
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Price</th>
        <th>Category</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($products as $product)
        <tr>
          <td>
            @if($product->image)
              <img src="{{ image_url($product->image) }}" alt="{{ $product->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
            @else
              <div style="width:50px;height:50px;background:#f5f5f5;border-radius:4px;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:10px;">No Image</div>
            @endif
          </td>
          <td><strong>{{ $product->name }}</strong></td>
          <td style="color:var(--muted);font-size:12px;">{{ $product->slug }}</td>
          <td>${{ number_format($product->price, 2) }}</td>
          <td style="color:var(--muted);font-size:12px;">{{ $product->category ?? 'Uncategorized' }}</td>
          <td>
            <span class="status" style="{{ $product->is_active ? 'background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);' : 'background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);' }}">
              {{ $product->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td>
            <div class="actions" style="margin:0;">
              <a href="{{ route('admin.products.edit', $product) }}" class="btn ghost" style="font-size:11px;padding:6px 10px;">Edit</a>
              <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this product?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn ghost" style="font-size:11px;padding:6px 10px;color:#ef4444;">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:20px;color:var(--muted);">No products yet</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@if(method_exists($products, 'hasPages') && $products->hasPages())
  <div style="margin-top:16px;display:flex;justify-content:center;gap:8px;">
    @if($products->onFirstPage())
      <span class="btn ghost" style="opacity:.5;">Previous</span>
    @else
      <a href="{{ $products->previousPageUrl() }}" class="btn ghost">Previous</a>
    @endif
    <span class="btn ghost">{{ $products->currentPage() }} / {{ $products->lastPage() }}</span>
    @if($products->hasMorePages())
      <a href="{{ $products->nextPageUrl() }}" class="btn ghost">Next</a>
    @else
      <span class="btn ghost" style="opacity:.5;">Next</span>
    @endif
  </div>
@endif
@endsection
