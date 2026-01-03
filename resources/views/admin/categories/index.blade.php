@extends('admin.layout')
@section('title','Categories')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Categories</h1>
    <p class="sub">Manage product categories</p>
  </div>
  <div class="actions">
    <a href="{{ route('admin.categories.create') }}" class="btn">+ New Category</a>
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
        <th>Name</th>
        <th>Slug</th>
        <th>Display Name</th>
        <th>Order</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($categories as $category)
        <tr>
          <td><strong>{{ $category->name }}</strong></td>
          <td style="color:var(--muted);font-size:12px;">{{ $category->slug }}</td>
          <td>{{ $category->display_name ?? $category->name }}</td>
          <td>{{ $category->order }}</td>
          <td>
            <span class="status" style="{{ $category->is_active ? 'background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);' : 'background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);' }}">
              {{ $category->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td>
            <div class="actions" style="margin:0;">
              <a href="{{ route('admin.categories.edit', $category) }}" class="btn ghost" style="font-size:11px;padding:6px 10px;">Edit</a>
              <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this category?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn ghost" style="font-size:11px;padding:6px 10px;color:#ef4444;">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center;padding:20px;color:var(--muted);">No categories yet</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@if($categories->hasPages())
  <div style="margin-top:16px;display:flex;justify-content:center;gap:8px;">
    @if($categories->onFirstPage())
      <span class="btn ghost" style="opacity:.5;">Previous</span>
    @else
      <a href="{{ $categories->previousPageUrl() }}" class="btn ghost">Previous</a>
    @endif
    <span class="btn ghost">{{ $categories->currentPage() }} / {{ $categories->lastPage() }}</span>
    @if($categories->hasMorePages())
      <a href="{{ $categories->nextPageUrl() }}" class="btn ghost">Next</a>
    @else
      <span class="btn ghost" style="opacity:.5;">Next</span>
    @endif
  </div>
@endif
@endsection

