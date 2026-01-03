@extends('admin.layout')
@section('title','Edit Product')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Edit Product</h1>
    <p class="sub">{{ $product->name }}</p>
  </div>
  <a class="btn ghost" href="{{ route('admin.products.index') }}">Back</a>
</div>

<div class="card" style="margin-top:16px">
  <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row2">
      <div>
        <label>Product Name</label>
        <input class="input" name="name" value="{{ old('name',$product->name) }}" required>
      </div>
      <div>
        <label>Price</label>
        <input class="input" type="number" step="0.01" name="price" value="{{ old('price',$product->price) }}" required>
      </div>
    </div>

    <div style="margin-top:12px">
      <label>Description</label>
      <textarea class="input" name="description" rows="4">{{ old('description',$product->description) }}</textarea>
    </div>

    <div class="row2" style="margin-top:12px">
      <div>
        <label>Replace Image (optional)</label>
        <input class="input" type="file" name="image" accept="image/*">
      </div>
      <div>
        <label>Current Image</label>
        <img class="thumb" style="width:100%;height:140px;border-radius:16px"
             src="{{ $product->image ? asset($product->image) : asset('assets/img/placeholder.jpg') }}" alt="">
      </div>
    </div>

    <div style="margin-top:12px">
      <label>Status</label>
      <select class="input" name="status">
        <option value="active" {{ $product->status=='active'?'selected':'' }}>active</option>
        <option value="inactive" {{ $product->status=='inactive'?'selected':'' }}>inactive</option>
      </select>
    </div>

    <button class="btn" type="submit" style="margin-top:14px">Update Product</button>
  </form>
</div>
@endsection
