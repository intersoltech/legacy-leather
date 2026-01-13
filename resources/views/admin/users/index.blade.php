@extends('admin.layout')
@section('title','Users Management')

@section('content')
<div class="pagetitle">
  <h1>Users Management</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Users</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Users Management</h5>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          {{-- Filters --}}
          <div class="mb-3">
            <div class="btn-group" role="group">
              <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary {{ !request('role') ? 'active' : '' }}">
                All Users
              </a>
              <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="btn btn-outline-primary {{ request('role') === 'admin' ? 'active' : '' }}">
                Admins
              </a>
              <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" class="btn btn-outline-primary {{ request('role') === 'customer' ? 'active' : '' }}">
                Customers
              </a>
            </div>
          </div>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Orders</th>
                <th scope="col">Registered</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                <tr>
                  <td><strong>{{ $user->name }}</strong></td>
                  <td style="color:#858585;font-size:12px;">{{ $user->email }}</td>
                  <td>
                    <span class="badge {{ $user->is_admin ? 'bg-success' : 'bg-info' }}">
                      {{ $user->is_admin ? 'Admin' : 'Customer' }}
                    </span>
                  </td>
                  <td>{{ $user->orders()->count() }}</td>
                  <td style="color:#858585;font-size:12px;">{{ $user->created_at->format('M d, Y') }}</td>
                  <td>
                    @if($user->id !== auth()->id())
                      <form action="{{ route('admin.users.update-status', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ $user->is_admin ? 'Remove' : 'Grant' }} admin access for this user?');">
                        @csrf
                        <input type="hidden" name="is_admin" value="{{ $user->is_admin ? 0 : 1 }}">
                        <button type="submit" class="btn btn-sm {{ $user->is_admin ? 'btn-outline-danger' : 'btn-outline-success' }}">
                          <i class="bi bi-{{ $user->is_admin ? 'x-circle' : 'shield-check' }}"></i>
                          {{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}
                        </button>
                      </form>
                    @else
                      <span style="color:#858585;font-size:11px;">You</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4" style="color:#858585;">No users found</td>
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

