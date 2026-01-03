@extends('admin.layout')
@section('title','Edit Category')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Edit Category</h1>
    <p class="sub">Update category details</p>
  </div>
  <div class="actions">
    <a href="{{ route('admin.categories.index') }}" class="btn ghost">Back</a>
  </div>
</div>

<div class="card" style="margin-top:16px;max-width:600px;">
  <form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf @method('PUT')
    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Name *</label>
      <input type="text" name="name" class="input" value="{{ old('name', $category->name) }}" required>
      @error('name')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Display Name</label>
      <input type="text" name="display_name" class="input" value="{{ old('display_name', $category->display_name) }}">
      @error('display_name')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
    </div>

    <div class="row2" style="margin-bottom:16px;">
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Order</label>
        <input type="number" name="order" class="input" value="{{ old('order', $category->order) }}" min="0">
      </div>
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Active</label>
        <select name="is_active" class="input">
          <option value="1" {{ old('is_active', $category->is_active) ? 'selected' : '' }}>Yes</option>
          <option value="0" {{ !old('is_active', $category->is_active) ? 'selected' : '' }}>No</option>
        </select>
      </div>
    </div>

    <div class="actions">
      <button type="submit" class="btn">Update Category</button>
      <a href="{{ route('admin.categories.index') }}" class="btn ghost">Cancel</a>
    </div>
  </form>
</div>
@endsection

