@extends('admin.layout')
@section('title','Edit Product')

@section('content')
<div class="pagetitle">
  <h1>Edit Product</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
      <li class="breadcrumb-item active">Edit Product</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Product</h5>

          <!-- General Form Elements -->
          <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <label for="name" class="col-sm-2 col-form-label">Product Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name',$product->name) }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="price" class="col-sm-2 col-form-label">Price</label>
              <div class="col-sm-10">
                <input type="number" step="0.01" class="form-control" name="price" id="price" value="{{ old('price',$product->price) }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description" rows="4">{{ old('description',$product->description) }}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="image" class="col-sm-2 col-form-label">Replace Image</label>
              <div class="col-sm-10">
                <input class="form-control" type="file" name="image" id="image" accept="image/*">
                <small class="form-text text-muted">Leave empty to keep current image</small>
              </div>
            </div>

            @if($product->image)
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Current Image</label>
              <div class="col-sm-10">
                <img src="{{ image_url($product->image, 'assets/img/placeholder.jpg') }}" alt="Current" style="max-width:200px;height:auto;border-radius:8px;border:1px solid #3e3e42;">
              </div>
            </div>
            @endif

            <div class="row mb-3">
              <label for="status" class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-10">
                <select class="form-select" name="status" id="status">
                  <option value="active" {{ old('status', $product->status)=='active'?'selected':'' }}>Active</option>
                  <option value="inactive" {{ old('status', $product->status)=='inactive'?'selected':'' }}>Inactive</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </div>

          </form><!-- End General Form Elements -->

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
