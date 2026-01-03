@extends('admin.layout')
@section('title','Create Category')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Create Category</h1>
    <p class="sub">Add a new product category</p>
  </div>
  <div class="actions">
    <a href="{{ route('admin.categories.index') }}" class="btn ghost">Back</a>
  </div>
</div>

<div class="card" style="margin-top:16px;max-width:600px;">
  <form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Name *</label>
      <input type="text" name="name" class="input" value="{{ old('name') }}" required>
      @error('name')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Display Name</label>
      <input type="text" name="display_name" class="input" value="{{ old('display_name') }}" placeholder="Leave empty to use name">
      @error('display_name')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
    </div>

    <div class="row2" style="margin-bottom:16px;">
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Order</label>
        <input type="number" name="order" class="input" value="{{ old('order', 0) }}" min="0">
      </div>
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Active</label>
        <select name="is_active" class="input">
          <option value="1" {{ old('is_active', true) ? 'selected' : '' }}>Yes</option>
          <option value="0" {{ !old('is_active', true) ? 'selected' : '' }}>No</option>
        </select>
      </div>
    </div>

    <div class="actions">
      <button type="submit" class="btn">Create Category</button>
      <a href="{{ route('admin.categories.index') }}" class="btn ghost">Cancel</a>
    </div>
  </form>
</div>
@endsection

