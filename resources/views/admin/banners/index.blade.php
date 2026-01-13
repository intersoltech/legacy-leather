@extends('admin.layout')
@section('title','Banners')

@section('content')
<div class="pagetitle">
  <h1>Banners</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Banners</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Banners</h5>
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
              <i class="bi bi-plus-circle"></i> New Banner
            </a>
          </div>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div class="row">
            @forelse($banners as $banner)
              <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                  <img src="{{ image_url($banner->image) }}" alt="{{ $banner->title }}" class="card-img-top" style="height:200px;object-fit:cover;">
                  <div class="card-body">
                    <h6 class="card-title">{{ $banner->title ?? 'No Title' }}</h6>
                    <p class="card-text" style="font-size:12px;color:#858585;margin-bottom:8px;">
                      <strong>Type:</strong> {{ ucfirst($banner->type) }}<br>
                      <strong>Order:</strong> {{ $banner->order }}
                    </p>
                    <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-danger' }}">
                      {{ $banner->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </div>
                  <div class="card-footer bg-transparent border-top-0">
                    <div class="d-flex gap-2">
                      <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary flex-fill">
                        <i class="bi bi-pencil"></i> Edit
                      </a>
                      <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline;flex:1;" onsubmit="return confirm('Delete this banner?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                          <i class="bi bi-trash"></i> Delete
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="alert alert-info text-center">
                  No banners yet. <a href="{{ route('admin.banners.create') }}" class="alert-link">Create one</a>
                </div>
              </div>
            @endforelse
          </div>

          @if(method_exists($banners, 'hasPages') && $banners->hasPages())
            <div class="d-flex justify-content-center mt-4">
              {{ $banners->links() }}
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
