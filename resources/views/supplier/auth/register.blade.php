<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Supplier Application - Good Procurements</title>
  <link rel="icon" type="image/png" href="{{ asset('site/assets/images/gps fav.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;family=Nunito:wght@700;800&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/libs/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
  <style>
    body {
      background: #f2f6fa;
      min-height: 100vh;
      font-family: 'Roboto', sans-serif;
      color: #243746;
    }
    h1, h2, h3, h4, h5, h6, .brand-name { font-family: 'Nunito', sans-serif; }
    .page-shell {
      max-width: 1160px;
      margin: 38px auto 60px;
      padding: 0 20px;
    }
    .page-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      margin-bottom: 26px;
      flex-wrap: wrap;
    }
    .brand-lockup {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    .brand-lockup img {
      width: 72px;
      height: 72px;
      object-fit: contain;
    }
    .brand-name {
      font-size: 30px;
      font-weight: 900;
      line-height: 1.05;
      color: #2a4760;
    }
    .brand-subtitle {
      margin-top: 7px;
      color: #708395;
      font-size: 12px;
      letter-spacing: 2px;
      text-transform: uppercase;
      font-weight: 700;
    }
    .top-note {
      max-width: 430px;
      color: #607384;
      font-size: 14px;
      line-height: 1.7;
    }
    .app-shell {
      background: #ffffff;
      border: 1px solid #e3ebf2;
      border-radius: 24px;
      overflow: hidden;
    }
    .hero {
      padding: 30px 34px;
      border-bottom: 1px solid #e7eef4;
      background: linear-gradient(180deg, #ffffff 0%, #f8fbfd 100%);
    }
    .hero-title {
      font-size: 28px;
      font-weight: 900;
      color: #2d4356;
      margin-bottom: 10px;
    }
    .hero-copy {
      color: #6d8092;
      line-height: 1.8;
      max-width: 800px;
      margin: 0;
    }
    .hero-points {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      margin-top: 18px;
    }
    .hero-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      border-radius: 999px;
      border: 1px solid #dfe8ef;
      background: #ffffff;
      color: #547c31;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: .4px;
    }
    .form-body {
      padding: 30px 34px 36px;
    }
    .section-block + .section-block {
      margin-top: 30px;
    }
    .section-title {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 18px;
      padding-bottom: 10px;
      border-bottom: 1px solid #edf2f6;
    }
    .section-title h3 {
      margin: 0;
      font-size: 17px;
      font-weight: 800;
      color: #314556;
    }
    .section-title span {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 1.6px;
      color: #7aac56;
      font-weight: 800;
    }
    .grid-2 {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 18px;
    }
    .grid-1 {
      display: grid;
      gap: 18px;
    }
    .form-label {
      font-size: 13px;
      font-weight: 700;
      margin-bottom: 8px;
      color: #33485b;
    }
    .form-control,
    .form-select {
      border-radius: 12px;
      border: 1px solid #d8e4ec;
      padding: 12px 14px;
      font-size: 14px;
      box-shadow: none;
    }
    .form-control:focus,
    .form-select:focus {
      border-color: #78B547;
      box-shadow: 0 0 0 4px rgba(120, 181, 71, 0.12);
    }
    .hint {
      font-size: 12px;
      color: #7b8d9d;
      margin-top: 6px;
      line-height: 1.6;
    }
    .product-card {
      border: 1px solid #e3ebf2;
      border-radius: 20px;
      padding: 22px;
      background: #fbfdff;
    }
    .product-card + .product-card {
      margin-top: 18px;
    }
    .product-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 18px;
    }
    .product-title {
      font-size: 16px;
      font-weight: 800;
      color: #2e4659;
    }
    .spec-card {
      border: 1px dashed #d5e2ea;
      border-radius: 16px;
      padding: 16px;
      background: #ffffff;
    }
    .spec-card + .spec-card {
      margin-top: 12px;
    }
    .btn-soft,
    .btn-remove {
      border: 1px solid #d7e3ec;
      background: #ffffff;
      color: #46617c;
      border-radius: 12px;
      padding: 10px 14px;
      font-weight: 700;
      font-size: 13px;
    }
    .btn-soft:hover,
    .btn-remove:hover {
      background: #f7fafc;
      color: #2f4d67;
    }
    .btn-remove {
      color: #b42318;
      border-color: #f1d0cc;
    }
    .btn-remove:hover {
      background: #fff5f4;
      color: #912018;
    }
    .btn-submit {
      width: 100%;
      border: 0;
      border-radius: 14px;
      padding: 15px 18px;
      background: linear-gradient(120deg, #426693, #78B547);
      color: #fff;
      font-size: 15px;
      font-weight: 800;
      letter-spacing: .2px;
    }
    .btn-submit:hover {
      opacity: .95;
      color: #fff;
    }
    .footer-links {
      margin-top: 22px;
      display: flex;
      justify-content: space-between;
      gap: 10px;
      flex-wrap: wrap;
      color: #738697;
      font-size: 13px;
    }
    .footer-links a {
      color: #426693;
      font-weight: 700;
      text-decoration: none;
    }
    .footer-links a:hover {
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .grid-2 {
        grid-template-columns: 1fr;
      }
      .page-top,
      .product-head,
      .section-title,
      .footer-links {
        flex-direction: column;
        align-items: flex-start;
      }
      .hero,
      .form-body {
        padding: 22px 20px 24px;
      }
      .brand-lockup img {
        width: 62px;
        height: 62px;
      }
      .brand-name {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
<div class="page-shell">
  <div class="page-top">
    <div class="brand-lockup">
      <img src="{{ asset('site/assets/images/gps-shield-icon.png') }}" alt="Good Procurements">
      <div>
        <div class="brand-name">Good Procurements</div>
        <div class="brand-subtitle">Supplier Application Intake</div>
      </div>
    </div>
    <div class="top-note">
      Submit your organization profile and product catalog in one place. Your pricing remains supplier-submitted data until our team reviews and converts approved items into the live catalog.
    </div>
  </div>

  <div class="app-shell">
    <div class="hero">
      <div class="hero-title">Apply as a Supplier</div>
      <p class="hero-copy">
        Complete the company profile below, add the products you want us to review, include detailed specifications and multiple images, then submit once. Our admin team will review your organization and product data before creating live catalog products and product pages internally.
      </p>
      <div class="hero-points">
        <div class="hero-pill"><i class="fas fa-circle-check"></i> No password required</div>
        <div class="hero-pill"><i class="fas fa-circle-check"></i> Submit multiple products</div>
        <div class="hero-pill"><i class="fas fa-circle-check"></i> Specs and images included</div>
      </div>
    </div>

    <div class="form-body">
      @include('partials.flash', ['wrapClass' => 'mb-4'])

      @if($errors->any())
        <div class="alert alert-danger mb-4">
          <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('supplier.register') }}" enctype="multipart/form-data" id="supplierApplicationForm">
        @csrf

        <div class="section-block">
          <div class="section-title">
            <h3>Contact Information</h3>
            <span>Step 1</span>
          </div>
          <div class="grid-2">
            <div>
              <label class="form-label">Primary Contact Name *</label>
              <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror" value="{{ old('contact_name') }}" required>
            </div>
            <div>
              <label class="form-label">Primary Contact Email *</label>
              <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email') }}" required>
            </div>
            <div>
              <label class="form-label">Primary Contact Phone</label>
              <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}" placeholder="+234 800 000 0000">
            </div>
          </div>
        </div>

        <div class="section-block">
          <div class="section-title">
            <h3>Organization Profile</h3>
            <span>Step 2</span>
          </div>
          <div class="grid-2">
            <div>
              <label class="form-label">Organization Name *</label>
              <input type="text" name="organization_name" class="form-control" value="{{ old('organization_name') }}" required>
            </div>
            <div>
              <label class="form-label">Industry / Category</label>
              <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g. Industrial Machinery">
            </div>
            <div>
              <label class="form-label">Business Phone</label>
              <input type="text" name="business_phone" class="form-control" value="{{ old('business_phone') }}">
            </div>
            <div>
              <label class="form-label">Website</label>
              <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://yourcompany.com">
            </div>
            <div class="grid-1" style="grid-column: 1 / -1;">
              <div>
                <label class="form-label">Business Address</label>
                <textarea name="business_address" class="form-control" rows="2">{{ old('business_address') }}</textarea>
              </div>
              <div>
                <label class="form-label">Organization Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Tell us what your company supplies, industries served, and operational capacity.">{{ old('description') }}</textarea>
              </div>
              <div>
                <label class="form-label">Organization Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
              </div>
            </div>
          </div>
        </div>

        <div class="section-block">
          <div class="section-title">
            <h3>Products for Review</h3>
            <span>Step 3</span>
          </div>
          <div class="hint mb-3">Add every product you want the admin team to review. The prices here are treated as supplier-submitted prices.</div>
          <div id="productsContainer"></div>
          <button type="button" class="btn-soft mt-3" id="addProductBtn">
            <i class="fas fa-plus me-2"></i>Add Another Product
          </button>
        </div>

        <button type="submit" class="btn-submit mt-4">
          <i class="fas fa-paper-plane me-2"></i>Submit Supplier Application
        </button>
      </form>

      <div class="footer-links">
        <span>Need to speak with our team first? <a href="{{ url('/#contact') }}">Contact Good Procurements</a></span>
        <span>Staff sign-in: <a href="{{ route('staff.login') }}">Admin / Staff Login</a></span>
      </div>
    </div>
  </div>
</div>

<template id="productTemplate">
  <div class="product-card" data-product-index="__INDEX__">
    <div class="product-head">
      <div class="product-title">Product Submission <span class="product-number">#__NUMBER__</span></div>
      <button type="button" class="btn-remove remove-product">Remove Product</button>
    </div>

    <div class="grid-2">
      <div>
        <label class="form-label">Product Name *</label>
        <input type="text" name="products[__INDEX__][name]" class="form-control" required>
      </div>
      <div>
        <label class="form-label">Supplier SKU</label>
        <input type="text" name="products[__INDEX__][sku]" class="form-control">
      </div>
      <div>
        <label class="form-label">Category</label>
        <select name="products[__INDEX__][category_id]" class="form-select">
          <option value="">Select category</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="form-label">Service Group</label>
        <select name="products[__INDEX__][service_id]" class="form-select">
          <option value="">Select service</option>
          @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->title }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="form-label">Supplier Price</label>
        <input type="number" step="0.01" min="0" name="products[__INDEX__][price]" class="form-control" placeholder="0.00">
      </div>
      <div>
        <label class="form-label">Currency</label>
        <input type="text" name="products[__INDEX__][currency]" class="form-control" value="NGN" maxlength="3">
      </div>
      <div>
        <label class="form-label">Stock Status</label>
        <select name="products[__INDEX__][stock_status]" class="form-select">
          <option value="in_stock">In Stock</option>
          <option value="out_of_stock">Out of Stock</option>
          <option value="on_backorder">On Backorder</option>
        </select>
      </div>
      <div>
        <label class="form-label">Featured Product Image</label>
        <input type="file" name="products[__INDEX__][featured_image]" class="form-control" accept="image/*">
      </div>
      <div style="grid-column:1 / -1;">
        <label class="form-label">Short Description</label>
        <input type="text" name="products[__INDEX__][short_description]" class="form-control" maxlength="500">
      </div>
      <div style="grid-column:1 / -1;">
        <label class="form-label">Detailed Product Description</label>
        <textarea name="products[__INDEX__][description]" class="form-control" rows="4" placeholder="Detailed technical or commercial description of the product."></textarea>
      </div>
      <div style="grid-column:1 / -1;">
        <label class="form-label">Additional Product Images</label>
        <input type="file" name="products[__INDEX__][images][]" class="form-control" accept="image/*" multiple>
        <div class="hint">Upload multiple supporting product images here.</div>
      </div>
    </div>

    <div class="section-title mt-4">
      <h3>Specifications</h3>
      <span>Optional</span>
    </div>
    <div class="specs-container"></div>
    <button type="button" class="btn-soft mt-3 add-spec">Add Specification</button>
  </div>
</template>

<template id="specTemplate">
  <div class="spec-card" data-spec-index="__SPEC_INDEX__">
    <div class="grid-2">
      <div>
        <label class="form-label">Specification Name</label>
        <input type="text" name="products[__PRODUCT_INDEX__][specs][__SPEC_INDEX__][name]" class="form-control" placeholder="e.g. Power Rating">
      </div>
      <div>
        <label class="form-label">Value</label>
        <input type="text" name="products[__PRODUCT_INDEX__][specs][__SPEC_INDEX__][value]" class="form-control" placeholder="e.g. 5 kW">
      </div>
      <div>
        <label class="form-label">Unit</label>
        <input type="text" name="products[__PRODUCT_INDEX__][specs][__SPEC_INDEX__][unit]" class="form-control" placeholder="Optional">
      </div>
      <div style="display:flex;align-items:flex-end;justify-content:flex-end;">
        <button type="button" class="btn-remove remove-spec">Remove Specification</button>
      </div>
    </div>
  </div>
</template>

<script>
  const productsContainer = document.getElementById('productsContainer');
  const productTemplate = document.getElementById('productTemplate').innerHTML;
  const specTemplate = document.getElementById('specTemplate').innerHTML;
  const addProductBtn = document.getElementById('addProductBtn');

  let productIndex = 0;

  function addSpec(productCard) {
    const specContainer = productCard.querySelector('.specs-container');
    const productIdx = productCard.dataset.productIndex;
    const specIndex = specContainer.children.length;

    const specHtml = specTemplate
      .replaceAll('__PRODUCT_INDEX__', productIdx)
      .replaceAll('__SPEC_INDEX__', specIndex);

    specContainer.insertAdjacentHTML('beforeend', specHtml);
  }

  function addProduct() {
    const html = productTemplate
      .replaceAll('__INDEX__', productIndex)
      .replaceAll('__NUMBER__', productIndex + 1);

    productsContainer.insertAdjacentHTML('beforeend', html);
    const productCard = productsContainer.lastElementChild;
    addSpec(productCard);
    productIndex += 1;
  }

  addProductBtn.addEventListener('click', addProduct);

  productsContainer.addEventListener('click', function (event) {
    if (event.target.classList.contains('add-spec')) {
      addSpec(event.target.closest('.product-card'));
    }

    if (event.target.classList.contains('remove-spec')) {
      event.target.closest('.spec-card').remove();
    }

    if (event.target.classList.contains('remove-product')) {
      const cards = productsContainer.querySelectorAll('.product-card');
      if (cards.length === 1) {
        return;
      }
      event.target.closest('.product-card').remove();
    }
  });

  addProduct();
</script>
</body>
</html>
