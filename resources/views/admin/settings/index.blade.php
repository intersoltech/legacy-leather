@extends('admin.layout')
@section('title','Site Settings')

@section('content')
<div class="topbar">
  <div>
    <h1 class="h1">Site Settings</h1>
    <p class="sub">Manage website configuration</p>
  </div>
</div>

@if(session('success'))
  <div class="card" style="background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.3);margin-top:16px;">
    <div style="color:#22c55e;">{{ session('success') }}</div>
  </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" style="margin-top:16px;">
  @csrf @method('PUT')
  
  @foreach($settings as $group => $groupSettings)
    <div class="card" style="margin-bottom:16px;">
      <h3 style="margin:0 0 16px;text-transform:capitalize;">{{ $group }} Settings</h3>
      @foreach($groupSettings as $setting)
        <div style="margin-bottom:16px;">
          <label style="display:block;margin-bottom:8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);">
            {{ str_replace('_', ' ', ucwords($setting->key, '_')) }}
          </label>
          @if(strlen($setting->value) > 100)
            <textarea name="{{ $setting->key }}" class="input" rows="3">{{ old($setting->key, $setting->value) }}</textarea>
          @else
            <input type="text" name="{{ $setting->key }}" class="input" value="{{ old($setting->key, $setting->value) }}">
          @endif
        </div>
      @endforeach
    </div>
  @endforeach

  <div class="actions">
    <button type="submit" class="btn">Save Settings</button>
  </div>
</form>
@endsection

