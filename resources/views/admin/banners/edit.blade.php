@extends('admin.layout')
@section('title','Edit Banner')

@section('content')
<div class="pagetitle">
  <h1>Edit Banner</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banners</a></li>
      <li class="breadcrumb-item active">Edit Banner</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Banner</h5>

          @if($banner->image)
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Current Image</label>
              <div class="col-sm-10">
                <img src="{{ image_url($banner->image) }}" alt="Current" style="max-width:100%;max-height:300px;object-fit:cover;border-radius:8px;border:1px solid #3e3e42;">
              </div>
            </div>
          @endif

          <!-- General Form Elements -->
          <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row mb-3">
              <label for="image" class="col-sm-2 col-form-label">Image</label>
              <div class="col-sm-10">
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept="image/*">
                @if($banner->image)
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image">
                    <label class="form-check-label" for="remove_image">
                      Remove current image
                    </label>
                  </div>
                @endif
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="title" class="col-sm-2 col-form-label">Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $banner->title) }}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="kicker" class="col-sm-2 col-form-label">Kicker</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="kicker" id="kicker" value="{{ old('kicker', $banner->kicker) }}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="subtitle" class="col-sm-2 col-form-label">Subtitle</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="subtitle" id="subtitle" rows="3">{{ old('subtitle', $banner->subtitle) }}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="button_text" class="col-sm-2 col-form-label">Button Text</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="button_text" id="button_text" value="{{ old('button_text', $banner->button_text) }}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="button_link" class="col-sm-2 col-form-label">Button Link</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="button_link" id="button_link" value="{{ old('button_link', $banner->button_link) }}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="type" class="col-sm-2 col-form-label">Type</label>
              <div class="col-sm-10">
                <select class="form-select" name="type" id="type">
                  <option value="shop" {{ old('type', $banner->type) === 'shop' ? 'selected' : '' }}>Shop</option>
                  <option value="home" {{ old('type', $banner->type) === 'home' ? 'selected' : '' }}>Home</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="category_filter" class="col-sm-2 col-form-label">Category Filter</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="category_filter" id="category_filter" value="{{ old('category_filter', $banner->category_filter) }}" placeholder="men, women, etc.">
              </div>
            </div>

            <div class="row mb-3">
              <label for="order" class="col-sm-2 col-form-label">Order</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" name="order" id="order" value="{{ old('order', $banner->order) }}" min="0">
              </div>
            </div>

            <div class="row mb-3">
              <label for="is_active" class="col-sm-2 col-form-label">Active</label>
              <div class="col-sm-10">
                <select class="form-select" name="is_active" id="is_active">
                  <option value="1" {{ old('is_active', $banner->is_active) ? 'selected' : '' }}>Yes</option>
                  <option value="0" {{ !old('is_active', $banner->is_active) ? 'selected' : '' }}>No</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i> Update Banner
                </button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </div>

          </form><!-- End General Form Elements -->

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

