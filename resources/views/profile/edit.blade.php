@extends('layouts.master')

@section('title', 'Edit Profile • Legacy Leather Works')

@section('content')
<div class="container" style="padding:34px 18px;">
  <div style="margin-bottom:24px;">
    <a href="{{ route('dashboard') }}" style="display:inline-flex;align-items:center;gap:8px;color:var(--brown);text-decoration:none;font-size:13px;margin-bottom:12px;">
      <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h1 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:28px;color:#2a1b14;">
      Edit Profile
    </h1>
    <p style="margin:8px 0 0;color:#666;font-size:14px;">Update your account information</p>
  </div>

  @if(session('status') === 'profile-updated')
    <div class="card" style="background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);margin-bottom:24px;padding:16px;border-radius:14px;">
      <div style="color:#22c55e;display:flex;align-items:center;gap:8px;">
        <i class="bi bi-check-circle"></i>
        <span>Profile updated successfully!</span>
      </div>
    </div>
  @endif

  @if(session('status') === 'password-updated')
    <div class="card" style="background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);margin-bottom:24px;padding:16px;border-radius:14px;">
      <div style="color:#22c55e;display:flex;align-items:center;gap:8px;">
        <i class="bi bi-check-circle"></i>
        <span>Password updated successfully!</span>
      </div>
    </div>
  @endif

  @if($errors->any())
    <div class="card" style="background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);margin-bottom:24px;padding:16px;border-radius:14px;">
      <div style="color:#ef4444;margin-bottom:8px;"><strong>Please fix the following errors:</strong></div>
      <ul style="margin:0;padding-left:20px;color:#ef4444;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid" style="grid-template-columns: 1fr; gap:24px;">
    {{-- Profile Information --}}
    <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;overflow:hidden;background:#fff;">
      <div style="padding:18px;border-bottom:1px solid rgba(0,0,0,.08);background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);">
        <h2 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:18px;color:#2a1b14;">
          Profile Information
        </h2>
        <p style="margin:4px 0 0;color:#666;font-size:12px;">Update your account's profile information and email address.</p>
      </div>
      <div style="padding:18px;">
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('patch')

          <div style="margin-bottom:16px;">
            <label style="display:block;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;font-weight:600;">
              Name
            </label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   style="width:100%;padding:12px;border:1px solid rgba(107,63,42,.22);border-radius:14px;font-size:14px;outline:none;background:#fff;color:#111;"
                   placeholder="Your name">
            @error('name')
              <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>
            @enderror
          </div>

          <div style="margin-bottom:16px;">
            <label style="display:block;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;font-weight:600;">
              Email
            </label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                   style="width:100%;padding:12px;border:1px solid rgba(107,63,42,.22);border-radius:14px;font-size:14px;outline:none;background:#fff;color:#111;"
                   placeholder="your.email@example.com">
            @error('email')
              <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>
            @enderror
            @if($user->email_verified_at)
              <div style="color:#22c55e;font-size:12px;margin-top:4px;display:flex;align-items:center;gap:4px;">
                <i class="bi bi-check-circle"></i>
                <span>Email verified</span>
              </div>
            @else
              <div style="color:#f59e0b;font-size:12px;margin-top:4px;display:flex;align-items:center;gap:4px;">
                <i class="bi bi-exclamation-circle"></i>
                <span>Email not verified</span>
              </div>
            @endif
          </div>

          <button type="submit" style="width:100%;padding:14px;border:none;border-radius:14px;background:var(--brown);color:#fff;font-size:12px;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;font-weight:600;margin-top:8px;">
            Save Changes
          </button>
        </form>
      </div>
    </div>

    {{-- Update Password --}}
    <div class="card" style="border:1px solid rgba(0,0,0,.10);border-radius:18px;overflow:hidden;background:#fff;">
      <div style="padding:18px;border-bottom:1px solid rgba(0,0,0,.08);background:linear-gradient(180deg,#fff 0%, #fbfaf8 100%);">
        <h2 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:18px;color:#2a1b14;">
          Update Password
        </h2>
        <p style="margin:4px 0 0;color:#666;font-size:12px;">Ensure your account is using a long, random password to stay secure.</p>
      </div>
      <div style="padding:18px;">
        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          @method('put')

          <div style="margin-bottom:16px;">
            <label style="display:block;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;font-weight:600;">
              Current Password
            </label>
            <input type="password" name="current_password" required
                   style="width:100%;padding:12px;border:1px solid rgba(107,63,42,.22);border-radius:14px;font-size:14px;outline:none;background:#fff;color:#111;"
                   placeholder="Enter your current password">
            @error('current_password', 'updatePassword')
              <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>
            @enderror
          </div>

          <div style="margin-bottom:16px;">
            <label style="display:block;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;font-weight:600;">
              New Password
            </label>
            <input type="password" name="password" required
                   style="width:100%;padding:12px;border:1px solid rgba(107,63,42,.22);border-radius:14px;font-size:14px;outline:none;background:#fff;color:#111;"
                   placeholder="Enter your new password">
            @error('password', 'updatePassword')
              <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>
            @enderror
          </div>

          <div style="margin-bottom:16px;">
            <label style="display:block;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;font-weight:600;">
              Confirm New Password
            </label>
            <input type="password" name="password_confirmation" required
                   style="width:100%;padding:12px;border:1px solid rgba(107,63,42,.22);border-radius:14px;font-size:14px;outline:none;background:#fff;color:#111;"
                   placeholder="Confirm your new password">
          </div>

          <button type="submit" style="width:100%;padding:14px;border:none;border-radius:14px;background:var(--brown);color:#fff;font-size:12px;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;font-weight:600;margin-top:8px;">
            <i class="bi bi-key"></i> Update Password
          </button>
        </form>
      </div>
    </div>

    {{-- Delete Account --}}
    <div class="card" style="border:1px solid rgba(239,68,68,.30);border-radius:18px;overflow:hidden;background:#fff;">
      <div style="padding:18px;border-bottom:1px solid rgba(239,68,68,.20);background:linear-gradient(180deg,#fff 0%, #fef2f2 100%);">
        <h2 style="margin:0;font-family:var(--serif);letter-spacing:.12em;text-transform:uppercase;font-size:18px;color:#dc2626;">
          Delete Account
        </h2>
        <p style="margin:4px 0 0;color:#666;font-size:12px;">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
      </div>
      <div style="padding:18px;">
        <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
          @csrf
          @method('delete')

          <div style="margin-bottom:16px;">
            <label style="display:block;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#666;margin-bottom:8px;font-weight:600;">
              Password
            </label>
            <input type="password" name="password" required
                   style="width:100%;padding:12px;border:1px solid rgba(239,68,68,.30);border-radius:14px;font-size:14px;outline:none;background:#fff;color:#111;"
                   placeholder="Enter your password to confirm">
            @error('password', 'userDeletion')
              <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')"
                  style="width:100%;padding:14px;border:none;border-radius:14px;background:#ef4444;color:#fff;font-size:12px;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;font-weight:600;">
            <i class="bi bi-trash"></i> Delete Account
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
@media(max-width:768px){
  .grid{grid-template-columns:1fr !important;}
}
</style>
@endsection

