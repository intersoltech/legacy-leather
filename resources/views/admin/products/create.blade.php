@extends('admin.layout')
@section('title','Add Product')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Add Product</h1>
    <p class="sub">Upload image + set price</p>
  </div>
  <a class="btn ghost" href="{{ route('admin.products.index') }}">Back</a>
</div>

<div class="card" style="margin-top:16px">
  <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row2">
      <div>
        <label>Product Name</label>
        <input class="input" name="name" value="{{ old('name') }}" required>
        @error('name') <div class="err">{{ $message }}</div> @enderror
      </div>
      <div>
        <label>Price</label>
        <input class="input" type="number" step="0.01" name="price" value="{{ old('price') }}" required>
        @error('price') <div class="err">{{ $message }}</div> @enderror
      </div>
    </div>

    <div style="margin-top:12px">
      <label>Description</label>
      <textarea class="input" name="description" rows="4">{{ old('description') }}</textarea>
    </div>

    <div class="row2" style="margin-top:12px">
      <div>
        <label>Image (jpg/png/webp)</label>
        <input class="input" type="file" name="image" accept="image/*" required>
        @error('image') <div class="err">{{ $message }}</div> @enderror
      </div>
      <div>
        <label>Status</label>
        <select class="input" name="status">
          <option value="active" selected>active</option>
          <option value="inactive">inactive</option>
        </select>
      </div>
    </div>

    <button class="btn" type="submit" style="margin-top:14px">Save Product</button>
  </form>
</div>
@endsection
