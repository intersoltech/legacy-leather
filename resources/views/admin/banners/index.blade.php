@extends('admin.layout')
@section('title','Banners')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Banners</h1>
    <p class="sub">Manage homepage and shop banners</p>
  </div>
  <div class="actions">
    <a href="{{ route('admin.banners.create') }}" class="btn">+ New Banner</a>
  </div>
</div>

@if(session('success'))
  <div class="card" style="background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);margin-top:16px;">
    <div style="color:#22c55e;">{{ session('success') }}</div>
  </div>
@endif

<div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); margin-top:16px;gap:16px;">
  @forelse($banners as $banner)
    <div class="card">
      <div style="margin-bottom:12px;">
        <img src="{{ image_url($banner->image) }}" alt="{{ $banner->title }}" class="thumb" style="width:100%;height:180px;object-fit:cover;">
      </div>
      <div>
        <h3 style="margin:0 0 8px;font-size:14px;">{{ $banner->title ?? 'No Title' }}</h3>
        <div style="font-size:12px;color:var(--muted);margin-bottom:12px;">
          <div>Type: {{ $banner->type }}</div>
          <div>Order: {{ $banner->order }}</div>
          <div style="margin-top:4px;">
            <span class="status" style="{{ $banner->is_active ? 'background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);' : 'background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);' }}">
              {{ $banner->is_active ? 'Active' : 'Inactive' }}
            </span>
          </div>
        </div>
        <div class="actions" style="margin:0;">
          <a href="{{ route('admin.banners.edit', $banner) }}" class="btn ghost" style="font-size:11px;padding:6px 10px;flex:1;">Edit</a>
          <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline;flex:1;" onsubmit="return confirm('Delete this banner?');">
            @csrf @method('DELETE')
            <button type="submit" class="btn ghost" style="font-size:11px;padding:6px 10px;width:100%;color:#ef4444;">Delete</button>
          </form>
        </div>
      </div>
    </div>
  @empty
    <div class="card" style="grid-column:1/-1;text-align:center;padding:40px;color:var(--muted);">
      No banners yet. <a href="{{ route('admin.banners.create') }}" style="color:var(--accent);">Create one</a>
    </div>
  @endforelse
</div>

@if(method_exists($banners, 'hasPages') && $banners->hasPages())
  <div style="margin-top:16px;display:flex;justify-content:center;gap:8px;">
    @if($banners->onFirstPage())
      <span class="btn ghost" style="opacity:.5;">Previous</span>
    @else
      <a href="{{ $banners->previousPageUrl() }}" class="btn ghost">Previous</a>
    @endif
    <span class="btn ghost">{{ $banners->currentPage() }} / {{ $banners->lastPage() }}</span>
    @if($banners->hasMorePages())
      <a href="{{ $banners->nextPageUrl() }}" class="btn ghost">Next</a>
    @else
      <span class="btn ghost" style="opacity:.5;">Next</span>
    @endif
  </div>
@endif
@endsection

