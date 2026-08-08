@extends('admin.layouts.app')

@php
  $pageTitle = $product?->name ?? $page->title ?? 'Standalone Page';
@endphp

@section('title', 'Page Builder - ' . $pageTitle)

@push('styles')
<style>
  .pb-sidebar { max-height: calc(100vh - 200px); overflow-y: auto; }
  .pb-block-item { cursor: pointer; transition: all 0.2s; border: 1px solid transparent; }
  .pb-block-item:hover { transform: translateY(-1px); border-color: #78B547; background: rgba(120,181,71,0.04); }
  .pb-canvas { min-height: 400px; border: 2px dashed #dee2e6; border-radius: 12px; background: #f8fafb; }
  .pb-canvas-block { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 10px; transition: border-color 0.2s, box-shadow 0.2s; }
  .pb-canvas-block:hover { border-color: #78B547; box-shadow: 0 2px 8px rgba(120,181,71,0.15); }
  .pb-canvas-block.sortable-ghost { opacity: 0.3; }
  .pb-canvas-block .drag-handle { cursor: grab; color: #94a3b8; }
  .pb-canvas-block .drag-handle:hover { color: #64748b; }
  .pb-modal-form .form-label { font-weight: 600; font-size: 0.85rem; margin-bottom: 4px; }
  .pb-modal-form .form-hint { font-size: 0.75rem; color: #94a3b8; }
  .pb-modal-form .pb-repeater-item { border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 12px; background: #fafbfc; }
  .pb-modal-form .pb-repeater-item:hover { border-color: #cbd5e1; }
  .pb-modal-form .image-preview { border: 1px dashed #d1d5db; border-radius: 10px; padding: 8px; background: #f9fafb; }
  .pb-modal-form .image-preview img { max-height: 140px; border-radius: 8px; object-fit: cover; }
  .pb-section-divider { display: flex; align-items: center; gap: 12px; margin: 8px 0; }
  .pb-section-divider::before, .pb-section-divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
  .pb-section-divider span { font-size: 0.75rem; font-weight: 600; color: #78B547; text-transform: uppercase; letter-spacing: 0.5px; }
  .pb-canvas-block--just-added { border-color: #78B547 !important; box-shadow: 0 0 0 2px rgba(120,181,71,0.3); }
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h4 class="page-title mb-2">Page Builder: {{ $pageTitle }}</h4>
        <div class="d-flex align-items-center gap-2 mt-1 mb-2">
          @if($page->exists)
            @if($page->is_published)
              <span class="badge bg-success" id="statusBadge"><i class="fi fi-rr-check-circle me-1"></i> Published</span>
            @else
              <span class="badge bg-warning text-dark" id="statusBadge"><i class="fi fi-rr-time-fast me-1"></i> Draft</span>
            @endif
          @else
            <span class="badge bg-secondary" id="statusBadge"><i class="fi fi-rr-document me-1"></i> New Page</span>
          @endif
          @if($page->product)
            <span class="badge bg-primary-subtle text-primary"><i class="fi fi-rr-link me-1"></i> {{ $page->product->name }}</span>
          @else
            <span class="badge bg-secondary-subtle text-secondary"><i class="fi fi-rr-minus-circle me-1"></i> Standalone</span>
          @endif
          <span class="text-muted small">Drag & drop blocks, click to edit content</span>
        </div>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <button type="button" class="btn btn-outline-info" id="previewLiveBtn"
                data-url="{{ route('admin.product-pages.preview-live', $page) }}">
          <i class="fi fi-rr-eye me-2"></i> Preview
        </button>
        @if($page->exists)
          <button type="button"
                  class="btn {{ $page->is_published ? 'btn-warning' : 'btn-success' }}"
                  id="publishBtn"
                  data-url="{{ route('admin.product-pages.toggle-publish', $page) }}"
                  data-published="{{ $page->is_published ? '1' : '0' }}">
            <i class="fi fi-rr-{{ $page->is_published ? 'lock' : 'rocket' }} me-2" id="publishIcon"></i>
            <span id="publishBtnText">{{ $page->is_published ? 'Unpublish' : 'Publish' }}</span>
          </button>
        @endif
        @if($page->exists && $page->is_published)
          <a href="{{ route('products.show', $page->slug) }}" class="btn btn-primary" target="_blank" id="viewLiveBtn">
            <i class="fi fi-rr-globe me-2"></i> View Live
          </a>
        @endif
        @if($page->product)
          <a href="{{ route('admin.products.edit', $page->product) }}" class="btn btn-outline-secondary">
            <i class="fi fi-rr-arrow-left me-2"></i> Back
          </a>
        @else
          <a href="{{ route('admin.product-pages.index') }}" class="btn btn-outline-secondary">
            <i class="fi fi-rr-arrow-left me-2"></i> Back
          </a>
        @endif
      </div>
    </div>
  </div>
</div>

<form id="pageBuilderForm" action="{{ route('admin.product-pages.update', $page) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="row">
    {{-- Block Library Sidebar --}}
    <div class="col-lg-3">
      <div class="card">
        <div class="card-header" style="background: rgba(120,181,71,0.08);">
          <h5 class="card-title mb-0" style="color: #426693;">
            <i class="fi fi-rr-apps me-2"></i> Block Library
          </h5>
        </div>
        <div class="card-body p-0">
          <div class="p-3 border-bottom">
            <input type="text" class="form-control form-control-sm" id="blockSearch" placeholder="Search blocks...">
          </div>
          <div class="pb-sidebar p-3" id="blockLibrary">
            @foreach($blockTypes as $category => $types)
              <div class="pb-category-group mb-3">
                <h6 class="text-uppercase text-muted mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">{{ ucfirst($category) }}</h6>
                @foreach($types as $type)
                  <div class="pb-block-item rounded-2 p-2 mb-1"
                       data-type-id="{{ $type->id }}"
                       data-type-name="{{ $type->name }}"
                       data-type-component="{{ $type->component_name }}"
                       data-type-category="{{ $type->category }}">
                    <div class="d-flex align-items-center">
                      <i class="fi fi-rr-plus-small me-2" style="color: #78B547;"></i>
                      <div>
                        <div class="fw-semibold" style="font-size: 0.85rem;">{{ $type->name }}</div>
                        @if($type->description)
                          <small class="text-muted" style="font-size: 0.7rem;">{{ Str::limit($type->description, 50) }}</small>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endforeach
            <div class="text-muted small text-center d-none py-3" id="noBlockResults">No blocks match your search.</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Canvas --}}
    <div class="col-lg-9">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0"><i class="fi fi-rr-layout-fluid me-2"></i> Page Canvas</h5>
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-info"><span id="blockCount">{{ $existingBlocks->count() }}</span> blocks</span>
            <span id="autoSaveStatus" class="text-muted small d-none">
              <i class="fi fi-rr-check-circle text-success me-1"></i> Saved
            </span>
          </div>
        </div>
        <div class="card-body">
          {{-- Page Settings --}}
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label">Page Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', $page->title ?? $pageTitle) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Page Slug</label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Linked Product (optional)</label>
              <select name="product_id" class="form-select">
                <option value="">Standalone page</option>
                @foreach($products ?? [] as $productOption)
                  <option value="{{ $productOption->id }}" @selected(old('product_id', $page->product_id) == $productOption->id)>{{ $productOption->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Meta Title</label>
              <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}" placeholder="SEO title (optional)">
            </div>
            <div class="col-md-6">
              <label class="form-label">Meta Description</label>
              <input type="text" name="meta_description" class="form-control" value="{{ old('meta_description', $page->meta_description) }}" placeholder="SEO description (optional)">
            </div>
          </div>

          <hr>

          <div class="mb-3">
            <label class="form-label fw-bold">Page Blocks</label>
            <p class="text-muted small mb-0">Click blocks from the sidebar to add. Click the edit button to configure content. Drag to reorder.</p>
          </div>

          <div id="blocksCanvas" class="pb-canvas p-3">
            @if($existingBlocks->count() > 0)
              @foreach($existingBlocks as $block)
                <div class="pb-canvas-block"
                     data-block-type-id="{{ $block->block_type_id }}"
                     data-block-name="{{ $block->blockType->name }}"
                     data-block-component="{{ $block->blockType->component_name }}"
                     data-block-category="{{ $block->blockType->category }}"
                     data-block-content="{{ json_encode($block->content) }}"
                     data-block-settings="{{ json_encode($block->settings) }}">
                  <div class="d-flex align-items-center p-3">
                    <i class="fi fi-rr-menu-burger drag-handle me-3"></i>
                    <div class="flex-grow-1">
                      <h6 class="mb-0" style="font-size: 0.9rem;">{{ $block->blockType->name }}</h6>
                      <small class="text-muted">{{ $block->blockType->component_name }}</small>
                    </div>
                    <span class="badge bg-{{ $block->blockType->category === 'hero' ? 'primary' : ($block->blockType->category === 'card' ? 'success' : 'secondary') }} me-2" style="font-size: 0.7rem;">
                      {{ $block->blockType->category }}
                    </span>
                    <button type="button" class="btn btn-sm btn-light me-1 edit-block-btn"><i class="fi fi-rr-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-block-btn"><i class="fi fi-rr-trash"></i></button>
                  </div>
                </div>
              @endforeach
            @else
              <div class="text-center text-muted py-5" id="emptyState">
                <i class="fi fi-rr-apps" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
                <p class="mb-0">No blocks yet. Click a block from the sidebar to add it.</p>
              </div>
            @endif
          </div>

          <input type="hidden" name="blocks" id="blocksData" value="">
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="fi fi-rr-disk me-2"></i> Save Page
              </button>
              <button type="button" class="btn btn-outline-info btn-lg" id="previewLiveBtnFooter"
                      data-url="{{ route('admin.product-pages.preview-live', $page) }}">
                <i class="fi fi-rr-eye me-2"></i> Preview
              </button>
            </div>
            @if($page->exists)
              <small class="text-muted">Last updated: {{ $page->updated_at->diffForHumans() }}</small>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

{{-- Block Edit Modal --}}
<div class="modal fade" id="blockEditModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background: rgba(120,181,71,0.06);">
        <h5 class="modal-title" id="modalTitle">Edit Block</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pb-modal-form" id="blockEditForm"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveBlockContent">
          <i class="fi fi-rr-check me-2"></i> Save Content
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
(function() {
  'use strict';

  /* ── Registry & Config ── */
  @php
    $registry = $blockTypes->flatten(1)->keyBy('id')->map(fn($t) => [
      'schema' => $t->schema,
      'default_data' => $t->default_data,
      'component_name' => $t->component_name,
      'name' => $t->name,
      'category' => $t->category,
    ]);
  @endphp
  const REGISTRY = @json($registry);
  const UPLOAD_URL = @json(route('admin.products.page.upload-image'));
  const AUTOSAVE_URL = @json(route('admin.product-pages.auto-save', $page));
  const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
  const ASSET_BASE = @json(asset(''));

  let currentBlock = null;
  const canvas = document.getElementById('blocksCanvas');
  const modalEl = document.getElementById('blockEditModal');
  const bsModal = new bootstrap.Modal(modalEl);

  /* ── Helpers ── */
  const esc = v => String(v ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  const label = k => k.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

  function resolveImg(v) {
    if (!v) return '';
    const s = String(v);
    if (/^(https?:)?\/\//i.test(s) || s.startsWith('data:') || s.startsWith('blob:')) return s;
    if (s.startsWith('/')) return s;
    return ASSET_BASE + s.replace(/^\/+/, '');
  }

  function parseJson(v, fallback) {
    if (!v) return fallback;
    try { const p = JSON.parse(v); return p ?? fallback; } catch { return fallback; }
  }

  /* ── Sortable ── */
  new Sortable(canvas, {
    animation: 150,
    handle: '.drag-handle',
    ghostClass: 'sortable-ghost',
    onEnd() {
      updateCount();
      autoSaveBlocks();
    },
  });

  /* ── Auto-Save ── */
  let autoSaveTimer = null;
  const statusEl = document.getElementById('autoSaveStatus');

  function showSaveStatus(text, type) {
    if (!statusEl) return;
    statusEl.classList.remove('d-none');
    if (type === 'saving') {
      statusEl.innerHTML = '<span class="spinner-border spinner-border-sm me-1" style="width: 12px; height: 12px;"></span> Saving...';
    } else if (type === 'saved') {
      statusEl.innerHTML = '<i class="fi fi-rr-check-circle text-success me-1"></i> Saved';
      setTimeout(() => { statusEl.classList.add('d-none'); }, 3000);
    } else if (type === 'error') {
      statusEl.innerHTML = '<i class="fi fi-rr-exclamation text-danger me-1"></i> ' + text;
    }
  }

  function autoSaveBlocks() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(doAutoSave, 300);
  }

  function doAutoSave() {
    const blocks = [];
    canvas.querySelectorAll('.pb-canvas-block').forEach((block, i) => {
      blocks.push({
        type_id: block.dataset.blockTypeId,
        content: parseJson(block.dataset.blockContent, {}),
        settings: parseJson(block.dataset.blockSettings, {}),
        sort_order: i,
      });
    });

    showSaveStatus('', 'saving');

    fetch(AUTOSAVE_URL, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      credentials: 'same-origin',
      body: JSON.stringify({ blocks }),
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        showSaveStatus('', 'saved');
      } else {
        showSaveStatus('Save failed', 'error');
      }
    })
    .catch(() => {
      showSaveStatus('Save failed', 'error');
    });
  }

  /* ── Block Search ── */
  const searchInput = document.getElementById('blockSearch');
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const q = this.value.toLowerCase().trim();
      let total = 0;
      document.querySelectorAll('.pb-category-group').forEach(group => {
        let groupHits = 0;
        group.querySelectorAll('.pb-block-item').forEach(item => {
          const match = !q || (item.dataset.typeName || '').toLowerCase().includes(q) || (item.dataset.typeComponent || '').toLowerCase().includes(q);
          item.classList.toggle('d-none', !match);
          if (match) groupHits++;
        });
        group.classList.toggle('d-none', groupHits === 0);
        total += groupHits;
      });
      document.getElementById('noBlockResults')?.classList.toggle('d-none', total > 0);
    });
  }

  /* ── Add Block ── */
  document.querySelectorAll('.pb-block-item').forEach(item => {
    item.addEventListener('click', () => addBlock(item));
  });

  function addBlock(item) {
    const typeId = item.dataset.typeId;
    const reg = REGISTRY[typeId] || {};
    const defaults = (reg.default_data && typeof reg.default_data === 'object') ? reg.default_data : {};

    document.getElementById('emptyState')?.remove();

    const block = document.createElement('div');
    block.className = 'pb-canvas-block pb-canvas-block--just-added';
    block.dataset.blockTypeId = typeId;
    block.dataset.blockName = item.dataset.typeName;
    block.dataset.blockComponent = item.dataset.typeComponent;
    block.dataset.blockCategory = item.dataset.typeCategory;
    block.dataset.blockContent = JSON.stringify(defaults);
    block.dataset.blockSettings = '{}';

    block.innerHTML = `
      <div class="d-flex align-items-center p-3">
        <i class="fi fi-rr-menu-burger drag-handle me-3"></i>
        <div class="flex-grow-1">
          <h6 class="mb-0" style="font-size: 0.9rem;">${esc(item.dataset.typeName)}</h6>
          <small class="text-muted">${esc(item.dataset.typeComponent)}</small>
        </div>
        <span class="badge bg-secondary me-2" style="font-size: 0.7rem;">${esc(item.dataset.typeCategory)}</span>
        <button type="button" class="btn btn-sm btn-light me-1 edit-block-btn"><i class="fi fi-rr-edit"></i></button>
        <button type="button" class="btn btn-sm btn-outline-danger remove-block-btn"><i class="fi fi-rr-trash"></i></button>
      </div>
    `;

    canvas.appendChild(block);
    attachBlockEvents(block);
    updateCount();

    // Remove highlight after a moment
    setTimeout(() => block.classList.remove('pb-canvas-block--just-added'), 2000);

    // Auto-save immediately — block is persisted right away
    autoSaveBlocks();

    // Open edit modal so user can customize content
    setTimeout(() => openEditModal(block), 150);
  }

  /* ── Block Events ── */
  function attachBlockEvents(block) {
    block.querySelector('.edit-block-btn').addEventListener('click', () => openEditModal(block));
    block.querySelector('.remove-block-btn').addEventListener('click', () => {
      if (!confirm('Remove this block?')) return;
      block.remove();
      updateCount();
      if (!canvas.querySelector('.pb-canvas-block')) {
        canvas.innerHTML = `<div class="text-center text-muted py-5" id="emptyState">
          <i class="fi fi-rr-apps" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
          <p class="mb-0">No blocks yet. Click a block from the sidebar to add it.</p>
        </div>`;
      }
      // Auto-save after deleting block
      autoSaveBlocks();
    });
  }

  // Attach events to existing blocks
  canvas.querySelectorAll('.pb-canvas-block').forEach(attachBlockEvents);

  function updateCount() {
    document.getElementById('blockCount').textContent = canvas.querySelectorAll('.pb-canvas-block').length;
  }

  /* ── Edit Modal ── */
  function openEditModal(block) {
    currentBlock = block;
    const typeId = block.dataset.blockTypeId;
    const reg = REGISTRY[typeId] || {};
    const schema = reg.schema || {};
    const defaults = reg.default_data || {};
    const content = parseJson(block.dataset.blockContent, {});

    document.getElementById('modalTitle').textContent = 'Edit: ' + (block.dataset.blockName || 'Block');
    const mount = document.getElementById('blockEditForm');
    mount.innerHTML = '';

    const schemaKeys = Object.keys(schema);
    const allKeys = schemaKeys.length ? schemaKeys : Object.keys(content);

    if (!allKeys.length) {
      mount.innerHTML = '<div class="alert alert-warning">This block has no editable fields.</div>';
      bsModal.show();
      return;
    }

    const wrapper = document.createElement('div');
    wrapper.className = 'row g-3';

    for (const key of allKeys) {
      const fieldSchema = schema[key] || {};
      const fieldType = fieldSchema.type || 'text';
      const savedValue = content[key];          // What user previously saved
      const defaultValue = defaults[key];        // Used as placeholder only
      const hasValue = savedValue !== undefined && savedValue !== null && savedValue !== '';

      if (fieldType === 'repeater') {
        wrapper.innerHTML += renderRepeaterShell(key, fieldSchema);
      } else {
        wrapper.innerHTML += renderField(key, fieldType, hasValue ? savedValue : '', defaultValue, fieldSchema);
      }
    }

    mount.appendChild(wrapper);

    // Initialize repeater items
    for (const key of allKeys) {
      const fieldSchema = schema[key] || {};
      if (fieldSchema.type === 'repeater') {
        initRepeater(key, fieldSchema, Array.isArray(content[key]) ? content[key] : []);
      }
    }

    // Init image previews and uploads
    initImagePreviews(mount);
    initImageUploads(mount);

    bsModal.show();
  }

  /* ── Field Renderers ── */
  function renderField(key, type, value, placeholder, schema) {
    const lbl = label(key);
    const req = schema?.required ? '<span class="text-danger">*</span>' : '';
    const hint = schema?.hint ? `<div class="form-hint">${esc(schema.hint)}</div>` : '';
    const ph = placeholder != null ? esc(String(placeholder)) : '';
    const val = esc(value);

    if (type === 'textarea' || type === 'wysiwyg') {
      return `<div class="col-12">
        <label class="form-label">${lbl} ${req}</label>
        <textarea class="form-control block-field" data-field="${key}" data-type="${type}" rows="4" placeholder="${ph}">${val}</textarea>
        ${type === 'wysiwyg' ? '<div class="form-hint">HTML supported.</div>' : ''}${hint}
      </div>`;
    }

    if (type === 'image') {
      const imgUrl = resolveImg(value);
      return `<div class="col-12 image-field">
        <label class="form-label">${lbl} ${req}</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fi fi-rr-picture"></i></span>
          <input type="text" class="form-control block-field" data-field="${key}" data-type="image" placeholder="${ph || 'Upload or paste image path'}" value="${val}">
        </div>
        <div class="image-preview mt-2 ${imgUrl ? '' : 'd-none'}">
          <img src="${esc(imgUrl)}" alt="Preview">
        </div>
        <input type="file" class="form-control mt-2 image-upload-input" data-target-field="${key}" accept="image/*">
        <div class="form-hint">Upload an image or paste a path/URL.</div>${hint}
      </div>`;
    }

    if (type === 'icon') {
      return renderIconField(key, value, lbl, req, hint);
    }

    if (type === 'select') {
      const opts = Array.isArray(schema?.options) ? schema.options : [];
      const optHtml = opts.map(o => `<option value="${esc(o)}" ${o === value ? 'selected' : ''}>${esc(label(o))}</option>`).join('');
      return `<div class="col-md-6">
        <label class="form-label">${lbl} ${req}</label>
        <select class="form-select block-field" data-field="${key}" data-type="select">${optHtml}</select>${hint}
      </div>`;
    }

    if (type === 'number') {
      return `<div class="col-md-4">
        <label class="form-label">${lbl} ${req}</label>
        <input type="number" class="form-control block-field" data-field="${key}" data-type="number" value="${val}" placeholder="${ph}">${hint}
      </div>`;
    }

    // Default: text
    return `<div class="col-md-6">
      <label class="form-label">${lbl} ${req}</label>
      <input type="text" class="form-control block-field" data-field="${key}" data-type="text" value="${val}" placeholder="${ph}">${hint}
    </div>`;
  }

  /* ── Repeater ── */
  function renderRepeaterShell(key, schema) {
    return `<div class="col-12">
      <div class="pb-section-divider"><span>${label(key)}</span></div>
      <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label mb-0">${label(key)} ${schema?.required ? '<span class="text-danger">*</span>' : ''}</label>
        <button type="button" class="btn btn-sm btn-outline-primary add-repeater-btn" data-repeater-key="${key}">
          <i class="fi fi-rr-plus me-1"></i> Add Item
        </button>
      </div>
      <div class="repeater-container" data-repeater-key="${key}"></div>
      <div class="form-hint">Add and configure items for this section.</div>
    </div>`;
  }

  function initRepeater(key, schema, items) {
    const container = document.querySelector(`.repeater-container[data-repeater-key="${key}"]`);
    const addBtn = document.querySelector(`.add-repeater-btn[data-repeater-key="${key}"]`);
    if (!container) return;

    const subFields = schema.fields || {};

    // Render existing items
    items.forEach(itemData => {
      container.appendChild(buildRepeaterItem(key, subFields, itemData));
    });

    // Add button
    addBtn?.addEventListener('click', () => {
      container.appendChild(buildRepeaterItem(key, subFields, {}));
    });
  }

  function buildRepeaterItem(parentKey, subFields, data) {
    const item = document.createElement('div');
    item.className = 'pb-repeater-item';

    let fieldsHtml = '';
    for (const [subKey, subSchema] of Object.entries(subFields)) {
      const subType = subSchema.type || 'text';
      const val = data[subKey] ?? '';
      fieldsHtml += renderRepeaterSubField(parentKey, subKey, subType, val, subSchema);
    }

    item.innerHTML = `
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="fw-semibold text-muted" style="font-size: 0.8rem;">${label(parentKey)} Item</span>
        <button type="button" class="btn btn-sm btn-outline-danger remove-repeater-btn"><i class="fi fi-rr-trash"></i></button>
      </div>
      <div class="row g-3">${fieldsHtml}</div>
    `;

    item.querySelector('.remove-repeater-btn').addEventListener('click', () => item.remove());
    initImagePreviews(item);
    initImageUploads(item);

    return item;
  }

  function renderRepeaterSubField(parentKey, subKey, type, value, schema) {
    const lbl = label(subKey);
    const val = esc(value);

    if (type === 'textarea' || type === 'wysiwyg') {
      return `<div class="col-12">
        <label class="form-label">${lbl}</label>
        <textarea class="form-control block-repeater-field" data-field="${parentKey}" data-subfield="${subKey}" data-type="${type}" rows="3" placeholder="Enter ${lbl.toLowerCase()}...">${val}</textarea>
      </div>`;
    }

    if (type === 'image') {
      const imgUrl = resolveImg(value);
      return `<div class="col-12 image-field">
        <label class="form-label">${lbl}</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fi fi-rr-picture"></i></span>
          <input type="text" class="form-control block-repeater-field" data-field="${parentKey}" data-subfield="${subKey}" data-type="image" placeholder="Upload or paste image path" value="${val}">
        </div>
        <div class="image-preview mt-2 ${imgUrl ? '' : 'd-none'}"><img src="${esc(imgUrl)}" alt="Preview"></div>
        <input type="file" class="form-control mt-2 image-upload-input" data-target-field="${parentKey}" data-target-subfield="${subKey}" accept="image/*">
      </div>`;
    }

    if (type === 'icon') {
      return renderIconField(subKey, value, lbl, '', schema?.hint ? `<div class="form-hint">${esc(schema.hint)}</div>` : '', parentKey);
    }

    if (type === 'select') {
      const opts = Array.isArray(schema?.options) ? schema.options : [];
      const optHtml = opts.map(o => `<option value="${esc(o)}" ${o === value ? 'selected' : ''}>${esc(label(o))}</option>`).join('');
      return `<div class="col-md-6">
        <label class="form-label">${lbl}</label>
        <select class="form-select block-repeater-field" data-field="${parentKey}" data-subfield="${subKey}" data-type="select">${optHtml}</select>
      </div>`;
    }

    if (type === 'number') {
      return `<div class="col-md-4">
        <label class="form-label">${lbl}</label>
        <input type="number" class="form-control block-repeater-field" data-field="${parentKey}" data-subfield="${subKey}" data-type="number" value="${val}" placeholder="0">
      </div>`;
    }

    return `<div class="col-md-6">
      <label class="form-label">${lbl}</label>
      <input type="text" class="form-control block-repeater-field" data-field="${parentKey}" data-subfield="${subKey}" data-type="text" value="${val}" placeholder="Enter ${lbl.toLowerCase()}...">
    </div>`;
  }

  /* ── Icon Picker ── */
  const FA_ICONS = [
    { v: '', l: '— No Icon —' },
    { g: 'Business', icons: [
      'fa-solid fa-briefcase', 'fa-solid fa-building', 'fa-solid fa-industry', 'fa-solid fa-landmark',
      'fa-solid fa-city', 'fa-solid fa-store', 'fa-solid fa-shop', 'fa-solid fa-warehouse',
      'fa-solid fa-handshake', 'fa-solid fa-chart-line', 'fa-solid fa-chart-pie', 'fa-solid fa-chart-bar',
      'fa-solid fa-coins', 'fa-solid fa-money-bill-wave', 'fa-solid fa-sack-dollar', 'fa-solid fa-wallet',
      'fa-solid fa-receipt', 'fa-solid fa-file-invoice-dollar', 'fa-solid fa-calculator',
    ]},
    { g: 'Logistics', icons: [
      'fa-solid fa-truck', 'fa-solid fa-truck-fast', 'fa-solid fa-ship', 'fa-solid fa-plane',
      'fa-solid fa-box', 'fa-solid fa-boxes-stacked', 'fa-solid fa-dolly', 'fa-solid fa-pallet',
      'fa-solid fa-container-storage', 'fa-solid fa-route', 'fa-solid fa-map-location-dot',
      'fa-solid fa-location-dot', 'fa-solid fa-globe', 'fa-solid fa-earth-americas',
    ]},
    { g: 'Industry', icons: [
      'fa-solid fa-oil-well', 'fa-solid fa-gas-pump', 'fa-solid fa-helmet-safety', 'fa-solid fa-hard-hat',
      'fa-solid fa-gears', 'fa-solid fa-gear', 'fa-solid fa-wrench', 'fa-solid fa-screwdriver-wrench',
      'fa-solid fa-hammer', 'fa-solid fa-bolt', 'fa-solid fa-plug', 'fa-solid fa-fire',
      'fa-solid fa-tower-broadcast', 'fa-solid fa-solar-panel', 'fa-solid fa-wind',
    ]},
    { g: 'General', icons: [
      'fa-solid fa-star', 'fa-solid fa-heart', 'fa-solid fa-shield-halved', 'fa-solid fa-lock',
      'fa-solid fa-check-circle', 'fa-solid fa-award', 'fa-solid fa-trophy', 'fa-solid fa-medal',
      'fa-solid fa-certificate', 'fa-solid fa-crown', 'fa-solid fa-gem', 'fa-solid fa-bullseye',
      'fa-solid fa-rocket', 'fa-solid fa-lightbulb', 'fa-solid fa-puzzle-piece', 'fa-solid fa-cube',
    ]},
    { g: 'Communication', icons: [
      'fa-solid fa-phone', 'fa-solid fa-envelope', 'fa-solid fa-comments', 'fa-solid fa-headset',
      'fa-solid fa-bell', 'fa-solid fa-bullhorn', 'fa-solid fa-paper-plane', 'fa-solid fa-at',
    ]},
    { g: 'People & Users', icons: [
      'fa-solid fa-users', 'fa-solid fa-user-tie', 'fa-solid fa-people-group', 'fa-solid fa-user-shield',
      'fa-solid fa-user-gear', 'fa-solid fa-person-digging', 'fa-solid fa-people-carry-box',
    ]},
    { g: 'Technology', icons: [
      'fa-solid fa-laptop', 'fa-solid fa-desktop', 'fa-solid fa-server', 'fa-solid fa-database',
      'fa-solid fa-cloud', 'fa-solid fa-wifi', 'fa-solid fa-microchip', 'fa-solid fa-code',
      'fa-solid fa-robot', 'fa-solid fa-satellite-dish',
    ]},
    { g: 'Nature & Time', icons: [
      'fa-solid fa-leaf', 'fa-solid fa-seedling', 'fa-solid fa-tree', 'fa-solid fa-water',
      'fa-solid fa-mountain-sun', 'fa-solid fa-clock', 'fa-solid fa-calendar', 'fa-solid fa-hourglass-half',
    ]},
    { g: 'Arrows & Actions', icons: [
      'fa-solid fa-arrow-right', 'fa-solid fa-arrows-rotate', 'fa-solid fa-circle-arrow-right',
      'fa-solid fa-right-left', 'fa-solid fa-download', 'fa-solid fa-upload', 'fa-solid fa-expand',
      'fa-solid fa-maximize', 'fa-solid fa-layer-group', 'fa-solid fa-list-check',
    ]},
  ];

  function renderIconField(key, value, lbl, req, hint, parentKey) {
    const uid = 'icon_' + Math.random().toString(36).substr(2, 8);
    const isRepeater = !!parentKey;
    const fieldClass = isRepeater ? 'block-repeater-field' : 'block-field';
    const dataAttrs = isRepeater
      ? `data-field="${parentKey}" data-subfield="${key}"`
      : `data-field="${key}"`;

    let optionsHtml = `<option value="">— No Icon —</option>`;
    for (const group of FA_ICONS) {
      if (group.g) {
        optionsHtml += `<optgroup label="${esc(group.g)}">`;
        for (const icon of group.icons) {
          const iconLabel = icon.replace('fa-solid fa-', '').replace(/-/g, ' ');
          const selected = icon === value ? ' selected' : '';
          optionsHtml += `<option value="${esc(icon)}"${selected}>${esc(iconLabel)}</option>`;
        }
        optionsHtml += `</optgroup>`;
      }
    }

    const previewIcon = value ? `<i class="${esc(value)}" style="font-size: 24px; color: var(--accent-color, #78B547);"></i>` : '<span class="text-muted" style="font-size: 0.8rem;">No icon</span>';

    return `<div class="col-md-6 icon-picker-field">
      <label class="form-label">${lbl} ${req}</label>
      <div class="d-flex align-items-center gap-3">
        <div class="icon-picker-preview d-flex align-items-center justify-content-center" id="${uid}_preview"
             style="width: 48px; height: 48px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafb; flex-shrink: 0;">
          ${previewIcon}
        </div>
        <div class="flex-grow-1">
          <select class="form-select ${fieldClass}" ${dataAttrs} data-type="icon" id="${uid}"
                  onchange="updateIconPreview('${uid}', this.value)">
            ${optionsHtml}
          </select>
        </div>
      </div>
      ${hint}
    </div>`;
  }

  function updateIconPreview(uid, value) {
    const preview = document.getElementById(uid + '_preview');
    if (!preview) return;
    preview.innerHTML = value
      ? `<i class="${value.replace(/"/g, '')}" style="font-size: 24px; color: var(--accent-color, #78B547);"></i>`
      : '<span class="text-muted" style="font-size: 0.8rem;">No icon</span>';
  }

  /* ── Image Previews ── */
  function initImagePreviews(scope) {
    scope.querySelectorAll('input[data-type="image"]').forEach(input => {
      const container = input.closest('.image-field');
      if (!container) return;
      const previewWrap = container.querySelector('.image-preview');
      const previewImg = previewWrap?.querySelector('img');
      const update = () => {
        const v = input.value.trim();
        if (!v) { previewWrap?.classList.add('d-none'); return; }
        if (previewImg) previewImg.src = resolveImg(v);
        previewWrap?.classList.remove('d-none');
      };
      input.addEventListener('input', update);
    });
  }

  /* ── Image Uploads ── */
  function initImageUploads(scope) {
    scope.querySelectorAll('.image-upload-input').forEach(input => {
      if (input.dataset.bound) return;
      input.dataset.bound = '1';

      input.addEventListener('change', async () => {
        const file = input.files?.[0];
        if (!file) return;

        const container = input.closest('.image-field');
        const textInput = container?.querySelector('input[data-type="image"]');

        const fd = new FormData();
        fd.append('image', file);
        input.disabled = true;

        try {
          const res = await fetch(UPLOAD_URL, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            credentials: 'same-origin',
            body: fd,
          });
          const ct = res.headers.get('content-type') || '';
          if (!ct.includes('application/json')) throw new Error('Server error');
          const data = await res.json();
          if (!data?.success) throw new Error(data?.message || 'Upload failed');

          if (textInput) {
            textInput.value = data.path || '';
            textInput.dispatchEvent(new Event('input'));
          }
        } catch (e) {
          alert('Image upload failed: ' + e.message);
        } finally {
          input.disabled = false;
          input.value = '';
        }
      });
    });
  }

  /* ── Save Block Content ── */
  document.getElementById('saveBlockContent').addEventListener('click', () => {
    if (!currentBlock) return;

    const content = {};

    // Collect top-level fields
    document.querySelectorAll('#blockEditForm .block-field').forEach(field => {
      const key = field.dataset.field;
      const type = field.dataset.type;
      let val = field.value;
      if (type === 'number') val = val === '' ? '' : Number(val);
      content[key] = val;
    });

    // Collect repeater items
    document.querySelectorAll('#blockEditForm .repeater-container').forEach(container => {
      const key = container.dataset.repeaterKey;
      const items = [];
      container.querySelectorAll('.pb-repeater-item').forEach(item => {
        const itemData = {};
        item.querySelectorAll('.block-repeater-field').forEach(field => {
          const subKey = field.dataset.subfield;
          const type = field.dataset.type;
          let val = field.value;
          if (type === 'number') val = val === '' ? '' : Number(val);
          itemData[subKey] = val;
        });
        if (Object.keys(itemData).length) items.push(itemData);
      });
      content[key] = items;
    });

    currentBlock.dataset.blockContent = JSON.stringify(content);

    // Visual feedback - briefly flash the block green
    currentBlock.style.borderColor = '#78B547';
    currentBlock.style.boxShadow = '0 0 0 2px rgba(120,181,71,0.3)';
    setTimeout(() => {
      currentBlock.style.borderColor = '';
      currentBlock.style.boxShadow = '';
    }, 1500);

    bsModal.hide();
    currentBlock = null;

    // Auto-save to server
    autoSaveBlocks();
  });

  /* ── Modal dismiss: just clear reference ── */
  modalEl.addEventListener('hidden.bs.modal', () => {
    currentBlock = null;
  });

  /* ── Serialize & Submit ── */
  function serializeBlocks() {
    const blocks = [];
    canvas.querySelectorAll('.pb-canvas-block').forEach((block, i) => {
      blocks.push({
        type_id: block.dataset.blockTypeId,
        content: parseJson(block.dataset.blockContent, {}),
        settings: parseJson(block.dataset.blockSettings, {}),
        sort_order: i,
      });
    });
    return blocks;
  }

  document.getElementById('pageBuilderForm').addEventListener('submit', (e) => {
    if (modalEl.classList.contains('show')) {
      bsModal.hide();
    }
    document.getElementById('blocksData').value = JSON.stringify(serializeBlocks());
  });

  /* ── Preview ── */
  function openPreview(url) {
    document.getElementById('blocksData').value = JSON.stringify(serializeBlocks());
    const form = document.getElementById('pageBuilderForm');
    const fd = new FormData(form);
    fd.delete('_method');

    fetch(url, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'text/html' },
      credentials: 'same-origin',
      body: fd,
    })
    .then(r => r.text())
    .then(html => {
      const w = window.open('', '_blank');
      if (!w) { alert('Popup blocked. Please allow popups.'); return; }
      w.document.open();
      w.document.write(html);
      w.document.close();
    })
    .catch(() => alert('Preview failed.'));
  }

  document.getElementById('previewLiveBtn')?.addEventListener('click', function() { openPreview(this.dataset.url); });
  document.getElementById('previewLiveBtnFooter')?.addEventListener('click', function() { openPreview(this.dataset.url); });

  /* ── Publish Toggle ── */
  const publishBtn = document.getElementById('publishBtn');
  if (publishBtn) {
    publishBtn.addEventListener('click', function() {
      const url = this.dataset.url;
      const isPublished = this.dataset.published === '1';
      if (!confirm(`Are you sure you want to ${isPublished ? 'unpublish' : 'publish'} this page?`)) return;

      this.disabled = true;
      this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';

      fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json' },
      })
      .then(r => r.json())
      .then(data => {
        if (!data.success) throw new Error('Failed');
        const pub = data.is_published;
        this.dataset.published = pub ? '1' : '0';
        this.className = pub ? 'btn btn-warning' : 'btn btn-success';
        this.innerHTML = pub ? '<i class="fi fi-rr-lock me-2"></i><span>Unpublish</span>' : '<i class="fi fi-rr-rocket me-2"></i><span>Publish</span>';
        this.disabled = false;

        const badge = document.getElementById('statusBadge');
        if (badge) {
          badge.className = pub ? 'badge bg-success' : 'badge bg-warning text-dark';
          badge.innerHTML = pub ? '<i class="fi fi-rr-check-circle me-1"></i> Published' : '<i class="fi fi-rr-time-fast me-1"></i> Draft';
        }

        const liveBtn = document.getElementById('viewLiveBtn');
        if (liveBtn) liveBtn.style.display = pub ? '' : 'none';
      })
      .catch(() => {
        alert('Failed to update publish status.');
        this.disabled = false;
        this.innerHTML = isPublished ? '<i class="fi fi-rr-lock me-2"></i><span>Unpublish</span>' : '<i class="fi fi-rr-rocket me-2"></i><span>Publish</span>';
      });
    });
  }

})();
</script>
@endpush
