<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Application Submitted - Good Procurements</title>
  <link rel="icon" type="image/png" href="{{ asset('site/assets/images/gps fav.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;family=Nunito:wght@700;800&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      display: grid;
      place-items: center;
      background: #f2f6fa;
      font-family: 'Roboto', sans-serif;
      color: #2b4254;
      padding: 24px;
    }
    h1, h2, h3, h4, h5, h6 { font-family: 'Nunito', sans-serif; }
    .success-card {
      width: min(680px, 100%);
      background: #fff;
      border: 1px solid #e3ebf2;
      border-radius: 24px;
      padding: 34px;
      text-align: center;
    }
    .success-card img {
      width: 86px;
      height: 86px;
      object-fit: contain;
      margin-bottom: 18px;
    }
    .badge-ref {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 16px;
      border-radius: 999px;
      background: #eef6e7;
      color: #5f9a33;
      font-weight: 800;
      letter-spacing: .6px;
      margin: 14px 0 18px;
    }
    p {
      color: #708395;
      line-height: 1.8;
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <div class="success-card">
    <img src="{{ asset('site/assets/images/gps-shield-icon.png') }}" alt="Good Procurements">
    <h2 class="mb-2">Supplier Application Submitted</h2>
    <div class="badge-ref">Reference {{ $applicationNumber }}</div>
    <p>
      Thank you. Your organization and product submission have been received by Good Procurements.
      Our admin team will review the supplier profile, supplier-submitted pricing, specifications, and product images before creating internal product drafts and product pages.
    </p>
  </div>
</body>
</html>
