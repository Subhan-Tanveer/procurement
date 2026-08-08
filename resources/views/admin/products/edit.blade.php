@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">Edit Product: {{ $product->name }}</h4>
        <p class="text-muted mb-0">Update product information and manage custom page</p>
      </div>
      <div class="btn-group">
        <a href="{{ route('admin.products.page.edit', $product) }}" class="btn btn-primary">
          <i class="fi fi-rr-layout-fluid me-2"></i> Page Builder
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
          <i class="fi fi-rr-arrow-left me-2"></i> Back
        </a>
      </div>
    </div>
  </div>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

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
                   value="{{ old('name', $product->name) }}"
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
                   value="{{ old('slug', $product->slug) }}">
            <small class="text-muted">Current URL: /products/{{ $product->slug }}</small>
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
                   value="{{ old('sku', $product->sku) }}">
            @error('sku')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Short Description -->
          <div class="mb-3">
            <label class="form-label">Short Description</label>
            <textarea name="short_description"
                      class="form-control @error('short_description') is-invalid @enderror"
                      rows="3">{{ old('short_description', $product->short_description) }}</textarea>
            @error('short_description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Full Description -->
          <div class="mb-3">
            <label class="form-label">Full Description</label>
            <textarea name="description"
                      class="form-control @error('description') is-invalid @enderror"
                      rows="6">{{ old('description', $product->description) }}</textarea>
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
                       value="{{ old('price', $product->price) }}"
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
                  <option value="NGN" {{ old('currency', $product->currency) == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                  <option value="USD" {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                  <option value="EUR" {{ old('currency', $product->currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
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
            <small class="text-muted">Upload a new image to replace the current one (max 5MB).</small>
            @error('featured_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="mt-3 {{ $product->featured_image ? '' : 'd-none' }}" id="featuredImagePreview">
              <img src="{{ $product->featured_image ? asset($product->featured_image) : '' }}"
                   alt="{{ $product->name }}"
                   class="img-thumbnail"
                   style="max-width: 240px;">
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
                   value="{{ old('meta_title', $product->meta_title) }}"
                   maxlength="60">
          </div>

          <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description"
                      class="form-control"
                      rows="3"
                      maxlength="160">{{ old('meta_description', $product->meta_description) }}</textarea>
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
                <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                <option value="{{ $service->id }}"
                        {{ old('service_id', $product->service_id) == $service->id ? 'selected' : '' }}>
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
              <option value="in_stock" {{ old('stock_status', $product->stock_status) == 'in_stock' ? 'selected' : '' }}>In Stock</option>
              <option value="out_of_stock" {{ old('stock_status', $product->stock_status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
              <option value="on_backorder" {{ old('stock_status', $product->stock_status) == 'on_backorder' ? 'selected' : '' }}>On Backorder</option>
            </select>
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input"
                     type="checkbox"
                     name="is_active"
                     id="isActive"
                     value="1"
                     {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
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
                     {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
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
                   value="{{ old('sort_order', $product->sort_order) }}"
                   min="0">
          </div>
        </div>
      </div>

      <!-- Product Page Status -->
      @if($product->productPage)
        <div class="card border-primary">
          <div class="card-header bg-primary bg-opacity-10">
            <h5 class="card-title mb-0 text-primary">
              <i class="fi fi-rr-layout-fluid me-2"></i> Product Page
            </h5>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span>Status:</span>
              <span class="badge bg-{{ $product->productPage->is_published ? 'success' : 'warning' }}">
                {{ $product->productPage->is_published ? 'Published' : 'Draft' }}
              </span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span>Blocks:</span>
              <span class="badge bg-info">{{ $product->productPage->blocks->count() }} blocks</span>
            </div>
            <a href="{{ route('admin.products.page.edit', $product) }}" class="btn btn-primary w-100 mb-2">
              <i class="fi fi-rr-layout-fluid me-2"></i> Edit Page
            </a>
            @if($product->productPage->is_published)
              <a href="{{ route('products.show', $product->productPage->slug) }}"
                 class="btn btn-outline-info w-100"
                 target="_blank">
                <i class="fi fi-rr-eye me-2"></i> View Live Page
              </a>
            @endif
          </div>
        </div>
      @else
        <div class="card border-warning">
          <div class="card-header bg-warning bg-opacity-10">
            <h5 class="card-title mb-0 text-warning">
              <i class="fi fi-rr-exclamation me-2"></i> No Custom Page
            </h5>
          </div>
          <div class="card-body">
            <p class="mb-3">This product doesn't have a custom page yet.</p>
            <a href="{{ route('admin.products.page.edit', $product) }}" class="btn btn-warning w-100">
              <i class="fi fi-rr-plus me-2"></i> Create Page
            </a>
          </div>
        </div>
      @endif

      <!-- Actions -->
      <div class="card">
        <div class="card-body">
          <button type="submit" class="btn btn-primary w-100 mb-2">
            <i class="fi fi-rr-check me-2"></i> Update Product
          </button>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100">
            Cancel
          </a>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
  const featuredInput = document.getElementById('featuredImageInput');
  const featuredPreview = document.getElementById('featuredImagePreview');
  const featuredPreviewImg = featuredPreview ? featuredPreview.querySelector('img') : null;

  if (featuredInput && featuredPreview && featuredPreviewImg) {
    featuredInput.addEventListener('change', () => {
      const file = featuredInput.files && featuredInput.files[0];
      if (!file) {
        if (!featuredPreviewImg.src) {
          featuredPreview.classList.add('d-none');
        }
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
