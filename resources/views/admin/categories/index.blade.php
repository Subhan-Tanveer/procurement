@extends('admin.layouts.app')

@section('title', 'Product Categories')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <h4 class="page-title">Product Categories</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="resetForm()">
        <i class="fi fi-rr-plus me-2"></i> Add Category
      </button>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th style="width: 40px">#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Status</th>
                <th style="width: 140px">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $category)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <strong>{{ $category->name }}</strong>
                    @if($category->description)
                      <br><small class="text-muted">{{ Str::limit($category->description, 60) }}</small>
                    @endif
                  </td>
                  <td><code>{{ $category->slug }}</code></td>
                  <td><span class="badge bg-info">{{ $category->products_count }}</span></td>
                  <td>
                    <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                      {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <button class="btn btn-sm btn-light"
                            data-bs-toggle="modal"
                            data-bs-target="#categoryModal"
                            onclick="editCategory({{ json_encode($category) }})">
                      <i class="fi fi-rr-edit"></i>
                    </button>
                    @if($category->products_count === 0)
                      <form action="{{ route('admin.categories.destroy', $category) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fi fi-rr-trash"></i>
                        </button>
                      </form>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                    No categories yet. Click "Add Category" to create one.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div id="methodField"></div>
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="catName" class="form-control" required placeholder="e.g. Drilling Equipment">
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" id="catDescription" class="form-control" rows="3" placeholder="Brief description of this category"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" id="catParent" class="form-select">
              <option value="">None (Top Level)</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="catActive" value="1" checked>
            <label class="form-check-label" for="catActive">Active</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Save Category</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function resetForm() {
  document.getElementById('modalTitle').textContent = 'Add Category';
  document.getElementById('submitBtn').textContent = 'Save Category';
  document.getElementById('categoryForm').action = "{{ route('admin.categories.store') }}";
  document.getElementById('methodField').innerHTML = '';
  document.getElementById('catName').value = '';
  document.getElementById('catDescription').value = '';
  document.getElementById('catParent').value = '';
  document.getElementById('catActive').checked = true;
}

function editCategory(cat) {
  document.getElementById('modalTitle').textContent = 'Edit Category';
  document.getElementById('submitBtn').textContent = 'Update Category';
  document.getElementById('categoryForm').action = `/admin/categories/${cat.id}`;
  document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
  document.getElementById('catName').value = cat.name || '';
  document.getElementById('catDescription').value = cat.description || '';
  document.getElementById('catParent').value = cat.parent_id || '';
  document.getElementById('catActive').checked = cat.is_active;
}
</script>
@endpush
