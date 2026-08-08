<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account Under Review - Good Procurement Service Ltd</title>
  <link rel="icon" type="image/png" href="{{ asset('site/assets/images/gps fav.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;family=Nunito:wght@700;800&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/libs/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
  <style>
    body { background: #f0f4f8; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: 'Roboto', sans-serif; }
    h2 { font-family: 'Nunito', sans-serif; }
    .pending-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(66,102,147,.12); max-width: 520px; width: 100%; padding: 48px; text-align: center; }
    .icon-wrap { width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 32px; }
    .icon-pending  { background: #fff8e1; color: #f59e0b; }
    .icon-rejected { background: #fce4ec; color: #c62828; }
    .icon-suspended { background: #ede7f6; color: #7c4dff; }
    h2 { font-size: 24px; font-weight: 700; color: #243746; margin-bottom: 12px; }
    p { color: #6b7280; line-height: 1.6; }
    .org-name { font-weight: 700; color: #426693; }
    .notes-box { background: #fff3e0; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 16px; text-align: left; margin: 24px 0; font-size: 14px; color: #5f4200; }
    .rejected-box { background: #fce4ec; border-left: 4px solid #c62828; }
  </style>
</head>
<body>
<div class="pending-card">
  @if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
  @endif

  @php
    $status = $profile?->status ?? 'pending_review';
  @endphp

  @if($status === 'rejected')
    <div class="icon-wrap icon-rejected"><i class="fas fa-times-circle"></i></div>
    <h2>Application Not Approved</h2>
    <p>Your supplier application for <span class="org-name">{{ $profile?->organization_name }}</span> was not approved at this time.</p>
    @if($profile?->review_notes)
      <div class="notes-box rejected-box">
        <strong>Admin Notes:</strong><br>{{ $profile->review_notes }}
      </div>
    @endif
    <p class="mt-3">If you believe this is an error or would like to reapply, please <a href="mailto:hello@goodprocurement.com.ng">contact us</a>.</p>
  @elseif($status === 'suspended')
    <div class="icon-wrap icon-suspended"><i class="fas fa-ban"></i></div>
    <h2>Account Suspended</h2>
    <p>Your supplier account for <span class="org-name">{{ $profile?->organization_name }}</span> has been suspended.</p>
    @if($profile?->review_notes)
      <div class="notes-box">
        <strong>Reason:</strong><br>{{ $profile->review_notes }}
      </div>
    @endif
    <p>Please <a href="mailto:hello@goodprocurement.com.ng">contact support</a> for assistance.</p>
  @else
    <div class="icon-wrap icon-pending"><i class="fas fa-hourglass-half"></i></div>
    <h2>Application Under Review</h2>
    <p>Thank you for registering as a supplier! Your profile for <span class="org-name">{{ $profile?->organization_name }}</span> is currently under review by our team.</p>
    <div class="notes-box">
      <strong><i class="fas fa-clock me-1"></i> What happens next?</strong><br>
      Our team will review your application within 1–2 business days. You will receive an email notification once a decision is made.
    </div>
    <p>In the meantime, feel free to <a href="{{ route('home') }}">browse our marketplace</a> or <a href="mailto:hello@goodprocurement.com.ng">contact us</a> with any questions.</p>
  @endif

  <form method="POST" action="{{ route('logout') }}" class="mt-4">
    @csrf
    <button type="submit" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-sign-out-alt me-1"></i> Logout
    </button>
  </form>
</div>
<script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
