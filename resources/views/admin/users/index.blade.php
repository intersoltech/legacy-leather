@extends('admin.layout')
@section('title','Users Management')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Users Management</h1>
    <p class="sub">Manage customers and admin access</p>
  </div>
  <div class="actions">
    <a href="{{ route('admin.dashboard') }}" class="btn ghost">Back to Dashboard</a>
  </div>
</div>

@if(session('success'))
  <div class="card" style="background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);margin-top:16px;">
    <div style="color:#22c55e;">{{ session('success') }}</div>
  </div>
@endif

@if(session('error'))
  <div class="card" style="background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);margin-top:16px;">
    <div style="color:#ef4444;">{{ session('error') }}</div>
  </div>
@endif

{{-- Filters --}}
<div class="card" style="margin-top:16px;">
  <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
    <a href="{{ route('admin.users.index') }}" class="btn ghost" style="{{ !request('role') ? 'background:var(--card);' : '' }}">All Users</a>
    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="btn ghost" style="{{ request('role') === 'admin' ? 'background:var(--card);' : '' }}">Admins</a>
    <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" class="btn ghost" style="{{ request('role') === 'customer' ? 'background:var(--card);' : '' }}">Customers</a>
  </div>
</div>

<div class="tableWrap" style="margin-top:16px;">
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Orders</th>
        <th>Registered</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr>
          <td><strong>{{ $user->name }}</strong></td>
          <td style="color:var(--muted);font-size:12px;">{{ $user->email }}</td>
          <td>
            <span class="status" style="{{ $user->is_admin ? 'background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);' : 'background:rgba(107,63,42,.15);border-color:rgba(107,63,42,.3);' }}">
              {{ $user->is_admin ? 'Admin' : 'Customer' }}
            </span>
          </td>
          <td>{{ $user->orders()->count() }}</td>
          <td style="color:var(--muted);font-size:12px;">{{ $user->created_at->format('M d, Y') }}</td>
          <td>
            @if($user->id !== auth()->id())
              <form action="{{ route('admin.users.update-status', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ $user->is_admin ? 'Remove' : 'Grant' }} admin access for this user?');">
                @csrf
                <input type="hidden" name="is_admin" value="{{ $user->is_admin ? 0 : 1 }}">
                <button type="submit" class="btn ghost" style="font-size:11px;padding:6px 10px;">
                  {{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}
                </button>
              </form>
            @else
              <span style="color:var(--muted);font-size:11px;">You</span>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center;padding:20px;color:var(--muted);">No users found</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@if($users->hasPages())
  <div style="margin-top:16px;display:flex;justify-content:center;gap:8px;">
    @if($users->onFirstPage())
      <span class="btn ghost" style="opacity:.5;">Previous</span>
    @else
      <a href="{{ $users->previousPageUrl() }}" class="btn ghost">Previous</a>
    @endif
    <span class="btn ghost">{{ $users->currentPage() }} / {{ $users->lastPage() }}</span>
    @if($users->hasMorePages())
      <a href="{{ $users->nextPageUrl() }}" class="btn ghost">Next</a>
    @else
      <span class="btn ghost" style="opacity:.5;">Next</span>
    @endif
  </div>
@endif
@endsection

