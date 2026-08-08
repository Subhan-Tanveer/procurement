@extends('supplier.layouts.app')
@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@push('styles')
<style>
  .specs-row { display: grid; grid-template-columns: 1fr 1fr auto; gap: 8px; align-items: center; margin-bottom: 8px; }
  .image-preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); gap: 8px; margin-top: 10px; }
  .image-preview-item { border-radius: 8px; overflow: hidden; aspect-ratio: 1; background: #f3f4f6; }
  .image-preview-item img { width: 100%; height: 100%; object-fit: cover; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <a href="{{ route('supplier.products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">
    <i class="fas fa-arrow-left me-1"></i> Back
  </a>
</div>

@if($product->approval_status === 'rejected' && $product->approval_notes)
  <div class="alert alert-warning mb-4">
    <i class="fas fa-exclamation-triangle me-1"></i>
    <strong>Rejection reason:</strong> {{ $product->approval_notes }}
    <br><small>Address the feedback below and resubmit.</small>
  </div>
@endif

<form method="POST" action="{{ route('supplier.products.update', $product->id) }}" enctype="multipart/form-data">
  @csrf @method('PUT')

  @if($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">Product Information</div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-600">Product Name *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $product->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-600">Category</label>
              <select name="category_id" class="form-select">
                <option value="">— Select Category —</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-600">Price</label>
              <input type="number" name="price" class="form-control" step="0.01" min="0"
                     value="{{ old('price', $product->price) }}">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-600">Currency</label>
              <select name="currency" class="form-select">
                @foreach(['NGN','USD','EUR','GBP'] as $c)
                  <option value="{{ $c }}" {{ old('currency', $product->currency) === $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-600">Short Description</label>
            <input type="text" name="short_description" class="form-control"
                   value="{{ old('short_description', $product->short_description) }}" maxlength="500">
          </div>
          <div class="mb-3">
            <label class="form-label fw-600">Full Description</label>
            <textarea name="description" class="form-control" rows="6">{{ old('description', $product->description) }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-600">Stock Status</label>
            <select name="stock_status" class="form-select" style="max-width:220px;">
              @foreach(['in_stock' => 'In Stock', 'out_of_stock' => 'Out of Stock', 'on_backorder' => 'On Backorder'] as $val => $label)
                <option value="{{ $val }}" {{ old('stock_status', $product->stock_status) === $val ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Specifications</span>
          <button type="button" class="btn btn-sm btn-outline-secondary" id="addSpec">
            <i class="fas fa-plus me-1"></i> Add Row
          </button>
        </div>
        <div class="card-body">
          <div id="specsContainer">
            @if(old('specs'))
              @foreach(old('specs') as $i => $spec)
              <div class="specs-row">
                <input type="text" name="specs[{{ $i }}][label]" class="form-control form-control-sm" value="{{ $spec['label'] }}" placeholder="Label">
                <input type="text" name="specs[{{ $i }}][value]" class="form-control form-control-sm" value="{{ $spec['value'] }}" placeholder="Value">
                <button type="button" class="btn btn-sm btn-outline-danger remove-spec"><i class="fas fa-trash"></i></button>
              </div>
              @endforeach
            @else
              @foreach($product->specifications as $i => $spec)
              <div class="specs-row">
                <input type="text" name="specs[{{ $i }}][label]" class="form-control form-control-sm" value="{{ $spec->label }}" placeholder="Label">
                <input type="text" name="specs[{{ $i }}][value]" class="form-control form-control-sm" value="{{ $spec->value }}" placeholder="Value">
                <button type="button" class="btn btn-sm btn-outline-danger remove-spec"><i class="fas fa-trash"></i></button>
              </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header">SEO</div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-600">Meta Title</label>
            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}">
          </div>
          <div class="mb-3">
            <label class="form-label fw-600">Meta Description</label>
            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $product->meta_description) }}</textarea>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">Featured Image</div>
        <div class="card-body">
          @if($product->featured_image)
            <img src="{{ asset($product->featured_image) }}" alt="" class="w-100 rounded mb-2" style="max-height:180px;object-fit:cover;">
          @endif
          <div id="newFeaturedPreview" class="mb-2" style="display:none;">
            <img id="newFeaturedImg" src="" alt="" class="w-100 rounded" style="max-height:180px;object-fit:cover;">
          </div>
          <label class="btn btn-outline-secondary btn-sm w-100">
            <i class="fas fa-image me-1"></i> Replace Image
            <input type="file" name="featured_image" id="featuredInput" accept="image/*" hidden>
          </label>
        </div>
      </div>

      @if($product->images->isNotEmpty())
      <div class="card mt-3">
        <div class="card-header">Existing Gallery</div>
        <div class="card-body">
          <div class="image-preview-grid">
            @foreach($product->images as $img)
              <div class="image-preview-item">
                <img src="{{ asset($img->image_path) }}" alt="">
              </div>
            @endforeach
          </div>
        </div>
      </div>
      @endif

      <div class="card mt-3">
        <div class="card-header">Add More Images</div>
        <div class="card-body">
          <label class="btn btn-outline-secondary btn-sm w-100">
            <i class="fas fa-images me-1"></i> Choose Images
            <input type="file" name="images[]" id="galleryInput" accept="image/*" multiple hidden>
          </label>
          <div id="galleryPreviews" class="image-preview-grid"></div>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-header">Resubmit</div>
        <div class="card-body">
          <div class="alert alert-info p-2" style="font-size:12px;">
            Saving will reset status to <strong>Pending</strong> and trigger a new review.
          </div>
          <button type="submit" class="btn btn-gps-green w-100">
            <i class="fas fa-paper-plane me-1"></i> Save & Resubmit
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
let specIndex = {{ $product->specifications->count() }};

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

document.getElementById('specsContainer').addEventListener('click', (e) => {
  if (e.target.closest('.remove-spec')) e.target.closest('.specs-row').remove();
});

document.getElementById('featuredInput').addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = (ev) => {
    document.getElementById('newFeaturedImg').src = ev.target.result;
    document.getElementById('newFeaturedPreview').style.display = 'block';
  };
  reader.readAsDataURL(file);
});

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
