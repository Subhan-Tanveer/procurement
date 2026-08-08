<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="theme-color" content="#78B547">
  <meta name="robots" content="noindex, nofollow">
  <meta name="author" content="Good Procurement Service Ltd">
  <meta name="format-detection" content="telephone=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - Good Procurement Service Ltd</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('site/assets/images/gps fav.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&amp;family=Nunito:wght@800&amp;display=swap" rel="stylesheet">

  <!-- Required Stylesheets -->
  <link rel="stylesheet" href="{{ asset('admin/libs/flaticon/css/all/all.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/lucide/lucide.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/simplebar/simplebar.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/node-waves/waves.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap-select/css/bootstrap-select.min.css') }}">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">

  <!-- Custom GPS Colors -->
  <style>
    :root {
      --bs-primary: #78B547 !important;
      --bs-primary-rgb: 120, 181, 71 !important;
      --bs-secondary: #426693 !important;
      --bs-secondary-rgb: 66, 102, 147 !important;
    }
    .btn-primary {
      background-color: #78B547 !important;
      border-color: #78B547 !important;
    }
    .btn-primary:hover {
      background-color: #6ba03e !important;
      border-color: #6ba03e !important;
    }
  </style>
</head>

<body>
  <div class="page-layout">

    <div class="auth-wrapper min-vh-100 px-2">
      <div class="row g-0 min-vh-100">
        <div class="col-xl-5 col-lg-6 ms-auto px-sm-4 align-self-center py-4 d-none d-lg-block">
          <img src="{{ asset('admin/assets/images/auth/vector2.svg') }}" alt="" class="img-fluid">
        </div>
        <div class="col-xl-5 col-lg-6 ms-auto px-sm-4 align-self-center py-4">
          <div class="card card-body p-4 p-sm-5 maxw-450px m-auto rounded-4">
            <div class="mb-4 text-center">
              <a href="{{ route('home') }}" aria-label="Good Procurement Service Ltd logo" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="{{ asset('site/assets/images/gps-shield-icon.png') }}" alt="" style="max-height: 46px; width: auto;">
                <span style="display: flex; flex-direction: column; line-height: 1; font-family: 'Nunito', sans-serif; font-weight: 700;">
                  <span style="color: #426693; font-size: 20px;">GOOD</span>
                  <span style="color: #78B547; font-size: 12px; letter-spacing: 0.16em; text-transform: uppercase; margin-top: 3px;">Procurement</span>
                </span>
              </a>
            </div>
            <div class="text-center mb-4">
              <h5 class="mb-1">Welcome to Good Procurement Service Ltd</h5>
              <p>Sign in to access your secure staff dashboard.</p>
            </div>

            @include('partials.flash', ['wrapClass' => 'gps-alert-wrap mb-3'])

            <form method="POST" action="{{ route('staff.login.submit') }}">
              @csrf

              <div class="mb-4">
                <label class="form-label" for="loginEmail">Email Address</label>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="loginEmail"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="info@example.com"
                       required
                       autofocus>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-4">
                <label class="form-label" for="loginPassword">Password</label>
                <div class="password-wrapper">
                  <input type="password"
                         class="form-control password-input @error('password') is-invalid @enderror"
                         id="loginPassword"
                         name="password"
                         placeholder="********"
                         required>
                  <button type="button" id="togglePassword" class="toggle-password" aria-pressed="false" aria-label="Show password" title="Show password">
                    <i class="close fi fi-rr-eye-crossed" aria-hidden="true"></i>
                    <i class="open fi fi-rr-eye" aria-hidden="true"></i>
                  </button>
                </div>
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-4">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                    <label class="form-check-label" for="rememberMe"> Remember Me </label>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <button type="submit" value="Submit" class="btn btn-primary waves-effect waves-light w-100">Login</button>
              </div>

              <p class="mb-5 text-center">Staff accounts are created internally by an authorized administrator.</p>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Scripts -->
  <script src="{{ asset('admin/libs/global/global.min.js') }}"></script>
  <script src="{{ asset('admin/js/appSettings.js') }}"></script>
  <script src="{{ asset('admin/js/main.js') }}"></script>
</body>
</html>
