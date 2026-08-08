@php
  $wrapClass = $wrapClass ?? 'gps-alert-wrap';
@endphp

@if(session('success') || session('error') || ($errors ?? null)?->any())
  <div class="{{ $wrapClass }}">
    @if(session('success'))
      <div class="alert gps-alert gps-alert-success alert-dismissible fade show" role="alert">
        <div class="gps-alert-icon"><i class="fa-solid fa-circle-check"></i></div>
        <div class="gps-alert-body">
          <div class="gps-alert-title">Success</div>
          <div class="gps-alert-text">{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close gps-alert-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert gps-alert gps-alert-danger alert-dismissible fade show" role="alert">
        <div class="gps-alert-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
        <div class="gps-alert-body">
          <div class="gps-alert-title">Something went wrong</div>
          <div class="gps-alert-text">{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close gps-alert-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(($errors ?? null)?->any())
      <div class="alert gps-alert gps-alert-danger alert-dismissible fade show" role="alert">
        <div class="gps-alert-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div class="gps-alert-body">
          <div class="gps-alert-title">Please fix the following</div>
          <ul class="gps-alert-list">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        <button type="button" class="btn-close gps-alert-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
  </div>
@endif
