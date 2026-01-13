@extends('admin.layout')
@section('title','Create Category')

@section('content')
<div class="pagetitle">
  <h1>Create Category</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
      <li class="breadcrumb-item active">Create Category</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Create Category</h5>

          <!-- General Form Elements -->
          <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
              <label for="name" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="display_name" class="col-sm-2 col-form-label">Display Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control @error('display_name') is-invalid @enderror" name="display_name" id="display_name" value="{{ old('display_name') }}" placeholder="Leave empty to use name">
                @error('display_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="order" class="col-sm-2 col-form-label">Order</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" name="order" id="order" value="{{ old('order', 0) }}" min="0">
              </div>
            </div>

            <div class="row mb-3">
              <label for="is_active" class="col-sm-2 col-form-label">Active</label>
              <div class="col-sm-10">
                <select class="form-select" name="is_active" id="is_active">
                  <option value="1" {{ old('is_active', true) ? 'selected' : '' }}>Yes</option>
                  <option value="0" {{ !old('is_active', true) ? 'selected' : '' }}>No</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i> Create Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </div>

          </form><!-- End General Form Elements -->

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

