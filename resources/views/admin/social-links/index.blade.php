@extends('admin.layout')
@section('title','Social Links')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Social Links</h1>
    <p class="sub">Manage social media links</p>
  </div>
  <div class="actions">
    <button type="button" onclick="document.getElementById('addForm').style.display='block';" class="btn">+ Add Link</button>
  </div>
</div>

@if(session('success'))
  <div class="card" style="background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);margin-top:16px;">
    <div style="color:#22c55e;">{{ session('success') }}</div>
  </div>
@endif

{{-- Add Form --}}
<div id="addForm" class="card" style="margin-top:16px;max-width:600px;display:none;">
  <h3 style="margin:0 0 16px;">Add Social Link</h3>
  <form action="{{ route('admin.social-links.store') }}" method="POST">
    @csrf
    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Platform *</label>
      <input type="text" name="platform" class="input" placeholder="Instagram, Facebook, etc." required>
    </div>
    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">URL *</label>
      <input type="url" name="url" class="input" placeholder="https://..." required>
    </div>
    <div class="row2" style="margin-bottom:16px;">
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Icon Class</label>
        <input type="text" name="icon_class" class="input" placeholder="bi-instagram">
      </div>
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Order</label>
        <input type="number" name="order" class="input" value="0" min="0">
      </div>
    </div>
    <div style="margin-bottom:16px;">
      <label style="display:flex;align-items:center;gap:8px;font-size:12px;">
        <input type="checkbox" name="is_active" value="1" checked>
        Active
      </label>
    </div>
    <div class="actions">
      <button type="submit" class="btn">Add Link</button>
      <button type="button" onclick="document.getElementById('addForm').style.display='none';" class="btn ghost">Cancel</button>
    </div>
  </form>
</div>

{{-- List --}}
<div class="tableWrap" style="margin-top:16px;">
  <table>
    <thead>
      <tr>
        <th>Platform</th>
        <th>URL</th>
        <th>Icon Class</th>
        <th>Order</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($socialLinks as $link)
        <tr>
          <td><strong>{{ ucfirst($link->platform) }}</strong></td>
          <td><a href="{{ $link->url }}" target="_blank" style="color:var(--accent);font-size:12px;">{{ \Illuminate\Support\Str::limit($link->url, 40) }}</a></td>
          <td style="color:var(--muted);font-size:12px;">{{ $link->icon_class ?? '-' }}</td>
          <td>{{ $link->order }}</td>
          <td>
            <span class="status" style="{{ $link->is_active ? 'background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);' : 'background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);' }}">
              {{ $link->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td>
            <div class="actions" style="margin:0;">
              <button type="button" onclick="editLink({{ $link->id }}, '{{ $link->platform }}', '{{ $link->url }}', '{{ $link->icon_class }}', {{ $link->order }}, {{ $link->is_active ? 1 : 0 }});" class="btn ghost" style="font-size:11px;padding:6px 10px;">Edit</button>
              <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this link?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn ghost" style="font-size:11px;padding:6px 10px;color:#ef4444;">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center;padding:20px;color:var(--muted);">No social links yet</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Edit Modal --}}
<div id="editForm" class="card" style="margin-top:16px;max-width:600px;display:none;">
  <h3 style="margin:0 0 16px;">Edit Social Link</h3>
  <form id="editFormForm" method="POST">
    @csrf @method('PUT')
    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Platform *</label>
      <input type="text" name="platform" id="edit_platform" class="input" required>
    </div>
    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">URL *</label>
      <input type="url" name="url" id="edit_url" class="input" required>
    </div>
    <div class="row2" style="margin-bottom:16px;">
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Icon Class</label>
        <input type="text" name="icon_class" id="edit_icon_class" class="input">
      </div>
      <div>
        <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">Order</label>
        <input type="number" name="order" id="edit_order" class="input" min="0">
      </div>
    </div>
    <div style="margin-bottom:16px;">
      <label style="display:flex;align-items:center;gap:8px;font-size:12px;">
        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
        Active
      </label>
    </div>
    <div class="actions">
      <button type="submit" class="btn">Update Link</button>
      <button type="button" onclick="document.getElementById('editForm').style.display='none';" class="btn ghost">Cancel</button>
    </div>
  </form>
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

