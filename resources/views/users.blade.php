@extends('theme.default')

@section('title', 'Users Management - Admin Panel')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Users Management</h1>
            <p class="text-muted small mb-0">Create, edit, manage user permissions, and track active statuses.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.trash') }}" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                <i class="fas fa-trash-alt me-1"></i> Recycle Bin
                @if($trashedCount > 0)
                    <span class="badge bg-danger ms-1">{{ $trashedCount }}</span>
                @endif
            </a>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center shadow-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fas fa-user-plus me-1"></i> Add New User
            </button>
        </div>
    </div>

    {{-- Top Summary Metric Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 border-start border-primary border-4 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Registered Users</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 border-start border-success border-4 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Active Accounts</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $activeCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 border-start border-warning border-4 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Inactive / Pending</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalUsers - $activeCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 border-start border-danger border-4 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">Deleted in Trash</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $trashedCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trash fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Users Table Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h6 class="m-0 fw-bold text-primary d-flex align-items-center">
                <i class="fas fa-table me-2"></i> All Users Directory
            </h6>

            {{-- Advanced Export Suite --}}
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary" onclick="exportTableToCSV('users-export.csv')">
                    <i class="fas fa-file-csv text-success me-1"></i> CSV
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="exportTableToExcel()">
                    <i class="fas fa-file-excel text-success me-1"></i> Excel
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                    <i class="fas fa-print text-primary me-1"></i> Print
                </button>
                <a href="{{ route('users.export') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-download text-info me-1"></i> Full DB Export
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Filter & Search Form --}}
            <form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-3">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, email, phone...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="editor" {{ request('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                    @if(request()->hasAny(['search', 'status', 'role']))
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filters"><i class="fas fa-times"></i></a>
                    @endif
                </div>
            </form>

            {{-- Bulk Actions Form --}}
            <form method="POST" action="{{ route('users.bulk') }}" id="bulkForm">
                @csrf
                <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-light rounded border">
                    <div class="form-check ms-1">
                        <input class="form-check-input" type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)">
                        <label class="form-check-label small fw-bold" for="selectAllCheckbox">Select All</label>
                    </div>
                    <span class="text-muted small">|</span>
                    <select name="bulk_action" class="form-select form-select-sm d-inline-block w-auto" required>
                        <option value="">-- Bulk Actions --</option>
                        <option value="status_active">Mark as Active</option>
                        <option value="status_inactive">Mark as Inactive</option>
                        <option value="status_banned">Mark as Banned</option>
                        <option value="delete">Move Selected to Trash</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Apply selected action to all checked users?')">Apply</button>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="usersTable">
                        <thead class="table-light text-uppercase small text-muted">
                            <tr>
                                <th width="30" class="text-center">#</th>
                                <th>User Profile</th>
                                <th>Contact Details</th>
                                <th>Role</th>
                                <th>Status (1-Click)</th>
                                <th>Created</th>
                                <th width="140" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="form-check-input user-checkbox">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar-sm me-2 border">
                                            <div>
                                                <a href="{{ route('users.show', $user) }}" class="fw-bold text-decoration-none text-dark">
                                                    {{ $user->name }}
                                                </a>
                                                <div class="text-muted small">ID: #{{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div><i class="fas fa-envelope me-1 text-muted small"></i> {{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-muted small"><i class="fas fa-phone me-1 text-muted"></i> {{ $user->phone }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border text-capitalize">{{ $user->role ?? 'User' }}</span>
                                    </td>
                                    <td>
                                        {{-- 1-Click Status Switch Form --}}
                                        <form method="POST" action="{{ route('users.toggle-status', $user->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 text-decoration-none" title="Click to cycle status (Active -> Inactive -> Banned)">
                                                {!! $user->status_badge !!}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="small text-muted">
                                        {{ $user->created_at->format('d M Y') }}
                                        <div class="text-xs">{{ $user->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            {{-- View --}}
                                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            {{-- Edit --}}
                                            <button type="button" class="btn btn-outline-primary" title="Edit User" 
                                                    data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            {{-- Soft Delete --}}
                                            <button type="button" class="btn btn-outline-danger" title="Move to Trash"
                                                    onclick="if(confirm('Move user {{ addslashes($user->name) }} to recycle bin?')) { document.getElementById('delete-form-{{ $user->id }}').submit(); }">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                        {{-- Hidden Delete Form --}}
                                        <form id="delete-form-{{ $user->id }}" method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>

                                {{-- Edit User Modal for this row --}}
                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="editUserModalLabel{{ $user->id }}">
                                                        <i class="fas fa-user-edit me-1 text-primary"></i> Edit User: {{ $user->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center mb-3">
                                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar-lg border shadow-sm">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Full Name *</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Email Address *</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                    </div>

                                                    <div class="row g-2 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Role</label>
                                                            <select name="role" class="form-select">
                                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                                <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                                                <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                                <option value="banned" {{ $user->status === 'banned' ? 'selected' : '' }}>Banned</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Phone Number</label>
                                                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="+1 234 567 890">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Update Avatar Photo</label>
                                                        <input type="file" name="avatar" class="form-control" accept="image/*">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Change Password (Leave empty to keep current)</label>
                                                        <input type="password" name="password" class="form-control" placeholder="Min. 6 characters">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block text-gray-300"></i>
                                        No users found matching your search criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Create New User Modal --}}
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="createUserModalLabel">
                        <i class="fas fa-user-plus me-1 text-primary"></i> Create New User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address *</label>
                        <input type="email" name="email" class="form-control" placeholder="user@example.com" required>
                    </div>

                    {{-- Password with Generator Button --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password *</label>
                        <div class="input-group">
                            <input type="text" name="password" id="createPasswordField" class="form-control" placeholder="Enter or generate password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="generateRandomPassword('createPasswordField')">
                                <i class="fas fa-key me-1"></i> Generate
                            </button>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Role *</label>
                            <select name="role" class="form-select" required>
                                <option value="user" selected>User</option>
                                <option value="editor">Editor</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status *</label>
                            <select name="status" class="form-select" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phone Number (Optional)</label>
                        <input type="text" name="phone" class="form-control" placeholder="+1 234 567 890">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Profile Avatar Photo (Optional)</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Password Generator
    function generateRandomPassword(elementId) {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
        let pass = "";
        for (let i = 0; i < 12; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById(elementId).value = pass;
    }

    // Toggle Select All Checkboxes
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    // Export HTML table to CSV
    function exportTableToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#usersTable tr");
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 1; j < cols.length - 1; j++) { // exclude checkbox and action cols
                row.push('"' + cols[j].innerText.replace(/"/g, '""').trim() + '"');
            }
            csv.push(row.join(","));
        }
        const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        const downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }

    // Export HTML table to Excel (.xls)
    function exportTableToExcel() {
        const table = document.getElementById("usersTable");
        const html = table.outerHTML;
        const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'users-export.xls';
        a.click();
    }
</script>
@endsection