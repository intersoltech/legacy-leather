@extends('admin.layout')
@section('title','Add Product')

@section('content')
<div class="pagetitle">
  <h1>Add Product</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
      <li class="breadcrumb-item active">Add Product</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Product</h5>

          <!-- General Form Elements -->
          <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
              <label for="name" class="col-sm-2 col-form-label">Product Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="price" class="col-sm-2 col-form-label">Price</label>
              <div class="col-sm-10">
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ old('price') }}" required>
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description" rows="4">{{ old('description') }}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="image" class="col-sm-2 col-form-label">Image</label>
              <div class="col-sm-10">
                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*" required>
                <small class="form-text text-muted">jpg/png/webp formats supported</small>
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="status" class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-10">
                <select class="form-select" name="status" id="status">
                  <option value="active" selected>Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i> Save Product
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
