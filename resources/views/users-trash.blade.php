@extends('theme.default')

@section('title', 'Recycle Bin (Trash) - Users')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold d-flex align-items-center">
                <i class="fas fa-trash-alt me-2 text-danger"></i> Users Recycle Bin
            </h1>
            <p class="text-muted small mb-0">Recover soft-deleted users or permanently purge them from the database.</p>
        </div>
        <div>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to All Users
            </a>
        </div>
    </div>

    {{-- Main Trash Table Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-danger d-flex align-items-center">
                <i class="fas fa-trash me-2"></i> Soft-Deleted Users ({{ $trashedCount }})
            </h6>
        </div>

        <div class="card-body">
            {{-- Filter & Search Form --}}
            <form method="GET" action="{{ route('users.trash') }}" class="row g-2 mb-3">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search deleted users by name or email...">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>

            {{-- Bulk Actions Form --}}
            <form method="POST" action="{{ route('users.bulk') }}">
                @csrf
                <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-light rounded border">
                    <div class="form-check ms-1">
                        <input class="form-check-input" type="checkbox" id="selectAllTrashCheckbox" onclick="toggleSelectAll(this)">
                        <label class="form-check-label small fw-bold" for="selectAllTrashCheckbox">Select All</label>
                    </div>
                    <span class="text-muted small">|</span>
                    <select name="bulk_action" class="form-select form-select-sm d-inline-block w-auto" required>
                        <option value="">-- Bulk Actions --</option>
                        <option value="restore">Restore Selected Users</option>
                        <option value="force_delete">Permanently Delete Selected</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Execute selected bulk action on checked trash items?')">Apply</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-uppercase small text-muted">
                            <tr>
                                <th width="30" class="text-center">#</th>
                                <th>User Profile</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Deleted At</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trashedUsers as $user)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="form-check-input user-checkbox">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar-sm me-2 border opacity-75">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                <div class="text-muted small">ID: #{{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ ucfirst($user->role ?? 'User') }}</span></td>
                                    <td class="small text-danger">
                                        <i class="fas fa-clock me-1"></i> {{ $user->deleted_at->format('d M Y, h:i A') }}
                                        <div class="text-muted text-xs">{{ $user->deleted_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="text-center">
                                        {{-- 1-Click Restore --}}
                                        <form method="POST" action="{{ route('users.restore', $user->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Restore User">
                                                <i class="fas fa-undo me-1"></i> Restore
                                            </button>
                                        </form>

                                        {{-- Permanent Delete --}}
                                        <form method="POST" action="{{ route('users.force-delete', $user->id) }}" class="d-inline" onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }}? This cannot be undone!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Permanently Delete">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                                        The Recycle Bin is empty. No deleted users.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            @if($trashedUsers->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="small text-muted">Showing {{ $trashedUsers->firstItem() }} to {{ $trashedUsers->lastItem() }} of {{ $trashedUsers->total() }} deleted users</div>
                    <div>{{ $trashedUsers->links('pagination::bootstrap-5') }}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }
</script>
@endsection
