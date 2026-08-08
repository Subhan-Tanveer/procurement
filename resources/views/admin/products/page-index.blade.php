@extends('admin.layouts.app')

@section('title', 'Page Builder')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h4 class="page-title mb-1">Page Builder</h4>
        <p class="text-muted mb-0">Create standalone pages or link a page to a product.</p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Create New Page</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.product-pages.store') }}" method="POST" class="row g-3">
          @csrf
          <div class="col-md-5">
            <label class="form-label">Link to Product (optional)</label>
            <select name="product_id" class="form-select">
              <option value="">Standalone page</option>
              @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
              @endforeach
            </select>
            <div class="form-text">Choose a product to link, or leave empty for standalone.</div>
          </div>
          <div class="col-md-4">
            <label class="form-label">Page Title (optional)</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Procurement Overview">
          </div>
          <div class="col-md-3">
            <label class="form-label">Custom Slug (optional)</label>
            <input type="text" name="slug" class="form-control" placeholder="e.g. procurement-overview">
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">
              <i class="fi fi-rr-plus me-2"></i> Create Page
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="card-title mb-0">Existing Pages</h5>
        <span class="text-muted small">{{ $pages->total() }} total</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped mb-0">
            <thead class="table-light">
              <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Linked Product</th>
                <th>Status</th>
                <th>Updated</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pages as $page)
                <tr>
                  <td>
                    <div class="fw-semibold">
                      <a href="{{ route('admin.product-pages.edit', $page) }}" class="text-decoration-none">
                        {{ $page->title }}
                      </a>
                    </div>
                  </td>
                  <td><code>{{ $page->slug }}</code></td>
                  <td>
                    @if($page->product)
                      <span class="badge bg-primary-subtle text-primary">{{ $page->product->name }}</span>
                    @else
                      <span class="badge bg-secondary-subtle text-secondary">Standalone</span>
                    @endif
                  </td>
                  <td>
                    @if($page->is_published)
                      <span class="badge bg-success">Published</span>
                    @else
                      <span class="badge bg-warning text-dark">Draft</span>
                    @endif
                  </td>
                  <td>{{ $page->updated_at?->diffForHumans() }}</td>
                  <td class="text-end">
                    <a href="{{ route('admin.product-pages.edit', $page) }}" class="btn btn-sm btn-primary">
                      Open Builder
                    </a>
                    <a href="{{ route('admin.product-pages.preview', $page) }}" class="btn btn-sm btn-outline-info" target="_blank">
                      Preview
                    </a>
                    @if($page->is_published)
                      <a href="{{ route('products.show', $page->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                        View Live
                      </a>
                    @endif
                    <form action="{{ route('admin.product-pages.destroy', $page) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Delete this page? This cannot be undone.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">No pages created yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if($pages->hasPages())
        <div class="card-footer">
          {{ $pages->links('pagination::bootstrap-5') }}
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
