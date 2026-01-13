@extends('admin.layout')
@section('title','Site Settings')

@section('content')
<div class="pagetitle">
  <h1>Site Settings</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Settings</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf @method('PUT')
        
        @foreach($settings as $group => $groupSettings)
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title" style="text-transform:capitalize;margin-bottom:20px;">{{ $group }} Settings</h5>
              
              @foreach($groupSettings as $setting)
                <div class="row mb-3">
                  <label for="{{ $setting->key }}" class="col-sm-2 col-form-label">
                    {{ str_replace('_', ' ', ucwords($setting->key, '_')) }}
                  </label>
                  <div class="col-sm-10">
                    @if(strlen($setting->value) > 100)
                      <textarea class="form-control" name="{{ $setting->key }}" id="{{ $setting->key }}" rows="3">{{ old($setting->key, $setting->value) }}</textarea>
                    @else
                      <input type="text" class="form-control" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}">
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach

        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i> Save Settings
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection

