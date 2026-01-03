@extends('admin.layout')
@section('title','Edit Banner')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Edit Banner</h1>
    <p class="sub">Update banner details</p>
  </div>
  <div class="actions">
    <a href="{{ route('admin.banners.index') }}" class="btn ghost">Back</a>
  </div>
</div>

<div class="card" style="margin-top:16px;max-width:700px;">
  @if($banner->image)
    <div style="margin-bottom:16px;">
      <img src="{{ asset('storage/' . $banner->image) }}" alt="Current" style="width:100%;max-height:300px;object-fit:cover;border-radius:12px;border:1px solid var(--line);">
    </div>
  @endif

  <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Image</label>
      <input type="file" name="image" class="input" accept="image/*">
      @if($banner->image)
        <label style="display:flex;align-items:center;gap:8px;margin-top:8px;font-size:12px;">
          <input type="checkbox" name="remove_image" value="1">
          Remove current image
        </label>
      @endif
      @error('image')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Title</label>
      <input type="text" name="title" class="input" value="{{ old('title', $banner->title) }}">
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Kicker</label>
      <input type="text" name="kicker" class="input" value="{{ old('kicker', $banner->kicker) }}">
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Subtitle</label>
      <textarea name="subtitle" class="input" rows="3">{{ old('subtitle', $banner->subtitle) }}</textarea>
    </div>

    <div class="row2" style="margin-bottom:16px;">
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Button Text</label>
        <input type="text" name="button_text" class="input" value="{{ old('button_text', $banner->button_text) }}">
      </div>
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Button Link</label>
        <input type="text" name="button_link" class="input" value="{{ old('button_link', $banner->button_link) }}">
      </div>
    </div>

    <div class="row2" style="margin-bottom:16px;">
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Type</label>
        <select name="type" class="input">
          <option value="shop" {{ old('type', $banner->type) === 'shop' ? 'selected' : '' }}>Shop</option>
          <option value="home" {{ old('type', $banner->type) === 'home' ? 'selected' : '' }}>Home</option>
        </select>
      </div>
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Category Filter</label>
        <input type="text" name="category_filter" class="input" value="{{ old('category_filter', $banner->category_filter) }}">
      </div>
    </div>

    <div class="row2" style="margin-bottom:16px;">
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Order</label>
        <input type="number" name="order" class="input" value="{{ old('order', $banner->order) }}" min="0">
      </div>
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Active</label>
        <select name="is_active" class="input">
          <option value="1" {{ old('is_active', $banner->is_active) ? 'selected' : '' }}>Yes</option>
          <option value="0" {{ !old('is_active', $banner->is_active) ? 'selected' : '' }}>No</option>
        </select>
      </div>
    </div>

    <div class="actions">
      <button type="submit" class="btn">Update Banner</button>
      <a href="{{ route('admin.banners.index') }}" class="btn ghost">Cancel</a>
    </div>
  </form>
</div>
@endsection

