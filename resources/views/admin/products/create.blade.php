@extends('admin.layouts.app')

@section('title', 'Add New Product')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
<li class="breadcrumb-item active" aria-current="page">Add New</li>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">Add New Product</h4>
        <p class="text-muted mb-0">Create a new product and build its custom page</p>
      </div>
      <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
        <i class="fi fi-rr-arrow-left me-2"></i> Back to Products
      </a>
    </div>
  </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="row">
    <!-- Main Product Information -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Product Information</h5>
        </div>
        <div class="card-body">
          <!-- Product Name -->
          <div class="mb-3">
            <label class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}"
                   required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Slug -->
          <div class="mb-3">
            <label class="form-label">Slug (URL)</label>
            <input type="text"
                   name="slug"
                   class="form-control @error('slug') is-invalid @enderror"
                   value="{{ old('slug') }}"
                   placeholder="Leave empty to auto-generate">
            <small class="text-muted">URL-friendly version of name. Leave empty for auto-generation.</small>
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- SKU -->
          <div class="mb-3">
            <label class="form-label">SKU (Stock Keeping Unit)</label>
            <input type="text"
                   name="sku"
                   class="form-control @error('sku') is-invalid @enderror"
                   value="{{ old('sku') }}">
            @error('sku')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Short Description -->
          <div class="mb-3">
            <label class="form-label">Short Description</label>
            <textarea name="short_description"
                      class="form-control @error('short_description') is-invalid @enderror"
                      rows="3">{{ old('short_description') }}</textarea>
            <small class="text-muted">Brief description shown in product listings</small>
            @error('short_description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Full Description -->
          <div class="mb-3">
            <label class="form-label">Full Description</label>
            <textarea name="description"
                      class="form-control @error('description') is-invalid @enderror"
                      rows="6">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Price -->
          <div class="row">
            <div class="col-md-8">
              <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number"
                       name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', 0) }}"
                       step="0.01"
                       min="0">
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Currency</label>
                <select name="currency" class="form-select">
                  <option value="NGN" {{ old('currency', 'NGN') == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                  <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                  <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Featured Image -->
          <div class="mb-3">
            <label class="form-label">Featured Image</label>
            <input type="file"
                   name="featured_image"
                   class="form-control @error('featured_image') is-invalid @enderror"
                   accept="image/*"
                   id="featuredImageInput">
            <small class="text-muted">Upload a clear product image (max 5MB).</small>
            @error('featured_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="mt-3 d-none" id="featuredImagePreview">
              <img src="" alt="Featured preview" class="img-thumbnail" style="max-width: 240px;">
            </div>
          </div>
        </div>
      </div>

      <!-- SEO Section -->
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">SEO Information</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Meta Title</label>
            <input type="text"
                   name="meta_title"
                   class="form-control"
                   value="{{ old('meta_title') }}"
                   maxlength="60">
            <small class="text-muted">Recommended: 50-60 characters</small>
          </div>

          <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description"
                      class="form-control"
                      rows="3"
                      maxlength="160">{{ old('meta_description') }}</textarea>
            <small class="text-muted">Recommended: 150-160 characters</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <!-- Category & Service -->
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Organization</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
              <option value="">Select Category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Service</label>
            <select name="service_id" class="form-select">
              <option value="">Select Service</option>
              @foreach($services as $service)
                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                  {{ $service->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <!-- Status -->
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Status & Visibility</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Stock Status</label>
            <select name="stock_status" class="form-select">
              <option value="in_stock" {{ old('stock_status', 'in_stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
              <option value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
              <option value="on_backorder" {{ old('stock_status') == 'on_backorder' ? 'selected' : '' }}>On Backorder</option>
            </select>
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input"
                     type="checkbox"
                     name="is_active"
                     id="isActive"
                     value="1"
                     {{ old('is_active', true) ? 'checked' : '' }}>
              <label class="form-check-label" for="isActive">
                Active (Visible on site)
              </label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input"
                     type="checkbox"
                     name="is_featured"
                     id="isFeatured"
                     value="1"
                     {{ old('is_featured') ? 'checked' : '' }}>
              <label class="form-check-label" for="isFeatured">
                Featured Product
              </label>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number"
                   name="sort_order"
                   class="form-control"
                   value="{{ old('sort_order', 0) }}"
                   min="0">
            <small class="text-muted">Lower numbers appear first</small>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="card">
        <div class="card-body">
          <button type="submit" class="btn btn-primary w-100 mb-2">
            <i class="fi fi-rr-check me-2"></i> Create Product
          </button>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100">
            Cancel
          </a>
          <hr>
          <small class="text-muted">
            <i class="fi fi-rr-info me-1"></i> After creating, you can build a custom page using the Page Builder
          </small>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
  // Auto-generate slug from product name
  document.querySelector('input[name="name"]').addEventListener('input', function(e) {
    const slugInput = document.querySelector('input[name="slug"]');
    if (!slugInput.value || slugInput.value === '') {
      const slug = e.target.value
        .toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
      slugInput.value = slug;
    }
  });

  // Featured image preview
  const featuredInput = document.getElementById('featuredImageInput');
  const featuredPreview = document.getElementById('featuredImagePreview');
  const featuredPreviewImg = featuredPreview ? featuredPreview.querySelector('img') : null;

  if (featuredInput && featuredPreview && featuredPreviewImg) {
    featuredInput.addEventListener('change', () => {
      const file = featuredInput.files && featuredInput.files[0];
      if (!file) {
        featuredPreview.classList.add('d-none');
        featuredPreviewImg.src = '';
        return;
      }
      const reader = new FileReader();
      reader.onload = (event) => {
        featuredPreviewImg.src = event.target.result;
        featuredPreview.classList.remove('d-none');
      };
      reader.readAsDataURL(file);
    });
  }
</script>
@endpush
