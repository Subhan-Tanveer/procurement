@extends('admin.layouts.app')

@section('title', 'Add Service')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <h4 class="page-title">Add Service</h4>
      <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
        <i class="fi fi-rr-arrow-left me-2"></i> Back
      </a>
    </div>
  </div>
</div>

<form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Service Details</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Service Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="e.g. Oil & Gas Procurement">
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Short Description</label>
            <input type="text" name="short_description" class="form-control" value="{{ old('short_description') }}" placeholder="Brief one-line summary" maxlength="500">
            @error('short_description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Full Description</label>
            <textarea name="description" class="form-control" rows="5" placeholder="Detailed description of this service">{{ old('description') }}</textarea>
            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      <!-- Service Offerings -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Service Offerings</h5>
          <button type="button" class="btn btn-sm btn-primary" onclick="addDetail()">
            <i class="fi fi-rr-plus me-1"></i> Add Item
          </button>
        </div>
        <div class="card-body">
          <p class="text-muted small mb-3">Add features, benefits, or specifications that describe what this service offers.</p>
          <div id="detailsContainer">
            @if(old('details'))
              @foreach(old('details') as $index => $detail)
                <div class="detail-row border rounded p-3 mb-3 position-relative">
                  <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top: 8px; right: 8px;" onclick="this.closest('.detail-row').remove()">
                    <i class="fi fi-rr-trash"></i>
                  </button>
                  <div class="row g-3">
                    <div class="col-md-8">
                      <label class="form-label">Title</label>
                      <input type="text" name="details[{{ $index }}][title]" class="form-control" required value="{{ $detail['title'] ?? '' }}">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Type</label>
                      <select name="details[{{ $index }}][type]" class="form-select" required>
                        <option value="feature" {{ ($detail['type'] ?? '') === 'feature' ? 'selected' : '' }}>Feature</option>
                        <option value="benefit" {{ ($detail['type'] ?? '') === 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="pricing" {{ ($detail['type'] ?? '') === 'pricing' ? 'selected' : '' }}>Pricing</option>
                        <option value="specification" {{ ($detail['type'] ?? '') === 'specification' ? 'selected' : '' }}>Specification</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Content</label>
                      <textarea name="details[{{ $index }}][content]" class="form-control" rows="2" required>{{ $detail['content'] ?? '' }}</textarea>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>

      <!-- Why Choose Section -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Why Choose Section</h5>
          <button type="button" class="btn btn-sm btn-primary" onclick="addWhyChooseFeature()">
            <i class="fi fi-rr-plus me-1"></i> Add Feature
          </button>
        </div>
        <div class="card-body">
          <p class="text-muted small mb-3">Add up to 4 features with title, paragraph, list items, and image.</p>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Section Title</label>
              <input type="text"
                     name="why_choose_title"
                     class="form-control"
                     value="{{ old('why_choose_title') }}"
                     placeholder="Why choose our quality assurance service">
            </div>
            <div class="col-md-6">
              <label class="form-label">Background Theme</label>
              <select name="why_choose_theme" class="form-select">
                <option value="dark" {{ old('why_choose_theme', 'dark') === 'dark' ? 'selected' : '' }}>Dark (default)</option>
                <option value="light" {{ old('why_choose_theme') === 'light' ? 'selected' : '' }}>Light</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Intro Paragraph</label>
              <textarea name="why_choose_intro"
                        class="form-control"
                        rows="3"
                        placeholder="Short intro about the service benefits">{{ old('why_choose_intro') }}</textarea>
            </div>
          </div>

          @php
            $whyChoose = old('why_choose_features', []);
          @endphp
          <div id="whyChooseContainer">
            @foreach($whyChoose as $index => $feature)
              <div class="why-choose-row border rounded p-3 mb-3 position-relative">
                <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top: 8px; right: 8px;" onclick="this.closest('.why-choose-row').remove()">
                  <i class="fi fi-rr-trash"></i>
                </button>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Feature Title</label>
                    <input type="text" name="why_choose_features[{{ $index }}][title]" class="form-control" required value="{{ $feature['title'] ?? '' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Feature Image</label>
                    <input type="file" name="why_choose_features[{{ $index }}][image]" class="form-control why-choose-image-input" accept="image/*">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Paragraph</label>
                    <textarea name="why_choose_features[{{ $index }}][description]" class="form-control" rows="2">{{ $feature['description'] ?? '' }}</textarea>
                  </div>
                  <div class="col-12">
                    <label class="form-label">List Items (one per line)</label>
                    <textarea name="why_choose_features[{{ $index }}][items]" class="form-control" rows="3">{{ $feature['items'] ?? '' }}</textarea>
                  </div>
                  <div class="col-12 d-none why-choose-preview">
                    <img src="" alt="Preview" class="img-thumbnail" style="max-width: 240px;">
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Settings</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Service Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Max 5MB. JPG, PNG, or WebP.</small>
            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Icon Class</label>
            <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="e.g. fi fi-rr-oil-can">
            <small class="text-muted">Flaticon or FontAwesome class name.</small>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="isActive">Active</label>
          </div>

          <hr>

          <div class="mb-3">
            <label class="form-label">Meta Title</label>
            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="SEO Title">
          </div>

          <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description" class="form-control" rows="2" placeholder="SEO Description">{{ old('meta_description') }}</textarea>
          </div>
        </div>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="fi fi-rr-check me-2"></i> Create Service
        </button>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
let detailIndex = {{ old('details') ? count(old('details')) : 0 }};
let whyChooseIndex = {{ $whyChoose ? count($whyChoose) : 0 }};

function addDetail() {
  const container = document.getElementById('detailsContainer');
  const html = `
    <div class="detail-row border rounded p-3 mb-3 position-relative">
      <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top: 8px; right: 8px;" onclick="this.closest('.detail-row').remove()">
        <i class="fi fi-rr-trash"></i>
      </button>
      <div class="row g-3">
        <div class="col-md-8">
          <label class="form-label">Title</label>
          <input type="text" name="details[${detailIndex}][title]" class="form-control" required placeholder="e.g. Equipment Sourcing">
        </div>
        <div class="col-md-4">
          <label class="form-label">Type</label>
          <select name="details[${detailIndex}][type]" class="form-select" required>
            <option value="feature">Feature</option>
            <option value="benefit">Benefit</option>
            <option value="pricing">Pricing</option>
            <option value="specification">Specification</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label">Content</label>
          <textarea name="details[${detailIndex}][content]" class="form-control" rows="2" required placeholder="Describe this offering..."></textarea>
        </div>
      </div>
    </div>
  `;
  container.insertAdjacentHTML('beforeend', html);
  detailIndex++;
}

function addWhyChooseFeature() {
  const container = document.getElementById('whyChooseContainer');
  if (!container) return;

  const currentCount = container.querySelectorAll('.why-choose-row').length;
  if (currentCount >= 4) {
    alert('You can add up to 4 features.');
    return;
  }

  const html = `
    <div class="why-choose-row border rounded p-3 mb-3 position-relative">
      <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top: 8px; right: 8px;" onclick="this.closest('.why-choose-row').remove()">
        <i class="fi fi-rr-trash"></i>
      </button>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Feature Title</label>
          <input type="text" name="why_choose_features[${whyChooseIndex}][title]" class="form-control" required placeholder="e.g. Verified suppliers">
        </div>
        <div class="col-md-6">
          <label class="form-label">Feature Image</label>
          <input type="file" name="why_choose_features[${whyChooseIndex}][image]" class="form-control why-choose-image-input" accept="image/*">
        </div>
        <div class="col-12">
          <label class="form-label">Paragraph</label>
          <textarea name="why_choose_features[${whyChooseIndex}][description]" class="form-control" rows="2" placeholder="Short description"></textarea>
        </div>
        <div class="col-12">
          <label class="form-label">List Items (one per line)</label>
          <textarea name="why_choose_features[${whyChooseIndex}][items]" class="form-control" rows="3" placeholder="Item 1\nItem 2"></textarea>
        </div>
        <div class="col-12 d-none why-choose-preview">
          <img src="" alt="Preview" class="img-thumbnail" style="max-width: 240px;">
        </div>
      </div>
    </div>
  `;
  container.insertAdjacentHTML('beforeend', html);
  bindWhyChooseImagePreviews(container);
  whyChooseIndex++;
}

function bindWhyChooseImagePreviews(scope = document) {
  scope.querySelectorAll('.why-choose-image-input').forEach(input => {
    if (input.dataset.bound === '1') return;
    input.dataset.bound = '1';

    input.addEventListener('change', () => {
      const file = input.files && input.files[0];
      const row = input.closest('.why-choose-row');
      const previewWrap = row ? row.querySelector('.why-choose-preview') : null;
      const previewImg = previewWrap ? previewWrap.querySelector('img') : null;
      if (!previewWrap || !previewImg) return;

      if (!file) {
        previewWrap.classList.add('d-none');
        previewImg.src = '';
        return;
      }
      const reader = new FileReader();
      reader.onload = (event) => {
        previewImg.src = event.target.result;
        previewWrap.classList.remove('d-none');
      };
      reader.readAsDataURL(file);
    });
  });
}

bindWhyChooseImagePreviews();
</script>
@endpush
