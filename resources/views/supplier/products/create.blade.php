@extends('supplier.layouts.app')
@section('title', 'Submit Product')
@section('page-title', 'Submit New Product')

@push('styles')
<style>
  .specs-row { display: grid; grid-template-columns: 1fr 1fr auto; gap: 8px; align-items: center; margin-bottom: 8px; }
  .image-preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 10px; }
  .image-preview-item { position: relative; border-radius: 8px; overflow: hidden; aspect-ratio: 1; background: #f3f4f6; }
  .image-preview-item img { width: 100%; height: 100%; object-fit: cover; }
  .image-preview-item .remove-img { position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,.5); color: #fff; border: none; border-radius: 50%; width: 22px; height: 22px; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
  .section-divider { border-top: 2px solid #f0f0f0; margin: 28px 0 20px; padding-top: 20px; }
  .section-title { font-size: 13px; font-weight: 700; color: #78B547; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 16px; }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
  <div class="col-xl-10">
    <form method="POST" action="{{ route('supplier.products.store') }}" enctype="multipart/form-data" id="productForm">
      @csrf

      @if($errors->any())
        <div class="alert alert-danger mb-4">
          <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif

      <div class="row g-4">
        {{-- Main column --}}
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header">Product Information</div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label fw-600">Product Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required placeholder="Enter product name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-600">Category</label>
                  <select name="category_id" class="form-select">
                    <option value="">— Select Category —</option>
                    @foreach($categories as $cat)
                      <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-600">Price</label>
                  <input type="number" name="price" class="form-control" step="0.01" min="0"
                         value="{{ old('price') }}" placeholder="0.00">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-600">Currency</label>
                  <select name="currency" class="form-select">
                    <option value="NGN" {{ old('currency', 'NGN') === 'NGN' ? 'selected' : '' }}>NGN</option>
                    <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD</option>
                    <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR</option>
                    <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-600">Short Description</label>
                <input type="text" name="short_description" class="form-control"
                       value="{{ old('short_description') }}" maxlength="500"
                       placeholder="One-line summary of the product">
              </div>

              <div class="mb-3">
                <label class="form-label fw-600">Full Description</label>
                <textarea name="description" class="form-control" rows="6"
                          placeholder="Detailed product description, use cases, features...">{{ old('description') }}</textarea>
              </div>

              <div class="mb-3">
                <label class="form-label fw-600">Stock Status</label>
                <select name="stock_status" class="form-select" style="max-width:220px;">
                  <option value="in_stock">In Stock</option>
                  <option value="out_of_stock">Out of Stock</option>
                  <option value="on_backorder">On Backorder</option>
                </select>
              </div>
            </div>
          </div>

          {{-- Specifications --}}
          <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span>Technical Specifications</span>
              <button type="button" class="btn btn-sm btn-outline-secondary" id="addSpec">
                <i class="fas fa-plus me-1"></i> Add Row
              </button>
            </div>
            <div class="card-body">
              <div id="specsContainer">
                @if(old('specs'))
                  @foreach(old('specs') as $i => $spec)
                  <div class="specs-row">
                    <input type="text" name="specs[{{ $i }}][label]" class="form-control form-control-sm"
                           value="{{ $spec['label'] }}" placeholder="Label (e.g. Weight)">
                    <input type="text" name="specs[{{ $i }}][value]" class="form-control form-control-sm"
                           value="{{ $spec['value'] }}" placeholder="Value (e.g. 5kg)">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-spec">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                  @endforeach
                @else
                  <div class="specs-row">
                    <input type="text" name="specs[0][label]" class="form-control form-control-sm" placeholder="Label (e.g. Weight)">
                    <input type="text" name="specs[0][value]" class="form-control form-control-sm" placeholder="Value (e.g. 5kg)">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-spec">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                @endif
              </div>
              <small class="text-muted mt-2 d-block">Leave blank rows — they'll be ignored on save.</small>
            </div>
          </div>

          {{-- SEO --}}
          <div class="card mt-4">
            <div class="card-header">SEO (optional)</div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label fw-600">Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" maxlength="255">
              </div>
              <div class="mb-3">
                <label class="form-label fw-600">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="2" maxlength="500">{{ old('meta_description') }}</textarea>
              </div>
            </div>
          </div>
        </div>

        {{-- Side column --}}
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">Featured Image</div>
            <div class="card-body">
              <div id="featuredPreview" class="mb-2" style="display:none;">
                <img id="featuredPreviewImg" src="" alt=""
                     style="width:100%;border-radius:8px;max-height:200px;object-fit:cover;">
              </div>
              <label class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-image me-1"></i> Choose Image
                <input type="file" name="featured_image" id="featuredInput" accept="image/*" hidden>
              </label>
              <small class="text-muted d-block mt-1">Max 5MB. JPG, PNG, WebP.</small>
            </div>
          </div>

          <div class="card mt-3">
            <div class="card-header">Product Gallery</div>
            <div class="card-body">
              <label class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-images me-1"></i> Choose Images (up to 10)
                <input type="file" name="images[]" id="galleryInput" accept="image/*" multiple hidden>
              </label>
              <div id="galleryPreviews" class="image-preview-grid"></div>
              <small class="text-muted d-block mt-2">Each image max 5MB.</small>
            </div>
          </div>

          <div class="card mt-3">
            <div class="card-header">Submission</div>
            <div class="card-body">
              <div class="alert alert-info p-3" style="font-size:13px;">
                <i class="fas fa-info-circle me-1"></i>
                Your product will be reviewed by our team before going live. This usually takes 1–2 business days.
              </div>
              <button type="submit" class="btn btn-gps-green w-100">
                <i class="fas fa-paper-plane me-1"></i> Submit for Approval
              </button>
              <a href="{{ route('supplier.products.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                Cancel
              </a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
let specIndex = {{ old('specs') ? count(old('specs')) : 1 }};

// Add spec row
document.getElementById('addSpec').addEventListener('click', () => {
  const container = document.getElementById('specsContainer');
  const row = document.createElement('div');
  row.className = 'specs-row';
  row.innerHTML = `
    <input type="text" name="specs[${specIndex}][label]" class="form-control form-control-sm" placeholder="Label">
    <input type="text" name="specs[${specIndex}][value]" class="form-control form-control-sm" placeholder="Value">
    <button type="button" class="btn btn-sm btn-outline-danger remove-spec"><i class="fas fa-trash"></i></button>
  `;
  container.appendChild(row);
  specIndex++;
});

// Remove spec row
document.getElementById('specsContainer').addEventListener('click', (e) => {
  if (e.target.closest('.remove-spec')) {
    e.target.closest('.specs-row').remove();
  }
});

// Featured image preview
document.getElementById('featuredInput').addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = (ev) => {
    document.getElementById('featuredPreviewImg').src = ev.target.result;
    document.getElementById('featuredPreview').style.display = 'block';
  };
  reader.readAsDataURL(file);
});

// Gallery previews
document.getElementById('galleryInput').addEventListener('change', (e) => {
  const container = document.getElementById('galleryPreviews');
  container.innerHTML = '';
  Array.from(e.target.files).slice(0, 10).forEach(file => {
    const reader = new FileReader();
    reader.onload = (ev) => {
      const item = document.createElement('div');
      item.className = 'image-preview-item';
      item.innerHTML = `<img src="${ev.target.result}" alt="">`;
      container.appendChild(item);
    };
    reader.readAsDataURL(file);
  });
});
</script>
@endpush
