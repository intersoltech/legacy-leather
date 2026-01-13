@extends('admin.layout')
@section('title','Social Links')

@section('content')
<div class="pagetitle">
  <h1>Social Links</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Social Links</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Social Links</h5>
            <button type="button" onclick="document.getElementById('addForm').style.display='block';" class="btn btn-primary">
              <i class="bi bi-plus-circle"></i> Add Link
            </button>
          </div>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          {{-- Add Form --}}
          <div id="addForm" class="card mb-3" style="display:none;">
            <div class="card-body">
              <h5 class="card-title mb-3">Add Social Link</h5>
              <form action="{{ route('admin.social-links.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                  <label for="platform" class="col-sm-2 col-form-label">Platform</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="platform" id="platform" placeholder="Instagram, Facebook, etc." required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="url" class="col-sm-2 col-form-label">URL</label>
                  <div class="col-sm-10">
                    <input type="url" class="form-control" name="url" id="url" placeholder="https://..." required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="icon_class" class="col-sm-2 col-form-label">Icon Class</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="icon_class" id="icon_class" placeholder="bi-instagram">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="order" class="col-sm-2 col-form-label">Order</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name="order" id="order" value="0" min="0">
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Active</label>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                      <label class="form-check-label" for="is_active">
                        Active
                      </label>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-save"></i> Add Link
                    </button>
                    <button type="button" onclick="document.getElementById('addForm').style.display='none';" class="btn btn-outline-secondary">Cancel</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">Platform</th>
                <th scope="col">URL</th>
                <th scope="col">Icon Class</th>
                <th scope="col">Order</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($socialLinks as $link)
                <tr>
                  <td><strong>{{ ucfirst($link->platform) }}</strong></td>
                  <td><a href="{{ $link->url }}" target="_blank" style="color:#007acc;font-size:12px;">{{ \Illuminate\Support\Str::limit($link->url, 40) }}</a></td>
                  <td style="color:#858585;font-size:12px;">{{ $link->icon_class ?? '-' }}</td>
                  <td>{{ $link->order }}</td>
                  <td>
                    <span class="badge {{ $link->is_active ? 'bg-success' : 'bg-danger' }}">
                      {{ $link->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <button type="button" onclick="editLink({{ $link->id }}, '{{ $link->platform }}', '{{ $link->url }}', '{{ $link->icon_class }}', {{ $link->order }}, {{ $link->is_active ? 1 : 0 }});" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                      </button>
                      <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this link?');">
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
                  <td colspan="6" class="text-center py-4" style="color:#858585;">No social links yet</td>
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

{{-- Edit Modal --}}
<div id="editForm" class="card mb-3" style="display:none;">
  <div class="card-body">
    <h5 class="card-title mb-3">Edit Social Link</h5>
    <form id="editFormForm" method="POST">
      @csrf @method('PUT')
      
      <div class="row mb-3">
        <label for="edit_platform" class="col-sm-2 col-form-label">Platform</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="platform" id="edit_platform" required>
        </div>
      </div>

      <div class="row mb-3">
        <label for="edit_url" class="col-sm-2 col-form-label">URL</label>
        <div class="col-sm-10">
          <input type="url" class="form-control" name="url" id="edit_url" required>
        </div>
      </div>

      <div class="row mb-3">
        <label for="edit_icon_class" class="col-sm-2 col-form-label">Icon Class</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="icon_class" id="edit_icon_class">
        </div>
      </div>

      <div class="row mb-3">
        <label for="edit_order" class="col-sm-2 col-form-label">Order</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="order" id="edit_order" min="0">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Active</label>
        <div class="col-sm-10">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="edit_is_active">
            <label class="form-check-label" for="edit_is_active">
              Active
            </label>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Update Link
          </button>
          <button type="button" onclick="document.getElementById('editForm').style.display='none';" class="btn btn-outline-secondary">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function editLink(id, platform, url, iconClass, order, isActive) {
  document.getElementById('editForm').style.display = 'block';
  document.getElementById('editFormForm').action = '{{ url('/admin/social-links') }}/' + id;
  document.getElementById('edit_platform').value = platform;
  document.getElementById('edit_url').value = url;
  document.getElementById('edit_icon_class').value = iconClass || '';
  document.getElementById('edit_order').value = order;
  document.getElementById('edit_is_active').checked = isActive == 1;
  document.getElementById('editForm').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endsection
