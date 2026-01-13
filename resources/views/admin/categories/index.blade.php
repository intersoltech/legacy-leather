@extends('admin.layout')
@section('title','Categories')

@section('content')
<div class="pagetitle">
  <h1>Categories</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Categories</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Categories</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
              <i class="bi bi-plus-circle"></i> New Category
            </a>
          </div>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Display Name</th>
                <th scope="col">Order</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $category)
                <tr>
                  <td><strong>{{ $category->name }}</strong></td>
                  <td style="color:#858585;font-size:12px;">{{ $category->slug }}</td>
                  <td>{{ $category->display_name ?? $category->name }}</td>
                  <td>{{ $category->order }}</td>
                  <td>
                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                      {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                      </a>
                      <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this category?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                          <i class="bi bi-trash"></i> Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4" style="color:#858585;">No categories yet</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          <!-- End Table with stripped rows -->
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

