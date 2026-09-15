@extends('theme.default')

@section('title', 'My Profile & Account Settings')

@section('content')
<div class="container-fluid px-4">
    <div class="mt-4 mb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Admin Profile & Security</h1>
        <p class="text-muted small mb-0">Manage your administrator credentials, profile avatar, and account security.</p>
    </div>

    <div class="row g-4">
        {{-- Profile Details Card --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary d-flex align-items-center">
                        <i class="fas fa-user-circle me-2"></i> Profile Information
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Avatar Preview --}}
                        <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded border">
                            <img src="{{ $adminUser->avatar_url }}" alt="{{ $adminUser->name }}" class="user-avatar-lg border shadow-sm">
                            <div>
                                <label class="form-label small fw-bold mb-1">Update Profile Picture</label>
                                <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*">
                                <div class="text-muted text-xs mt-1">Allowed: PNG, JPG, JPEG, WEBP (Max 2MB)</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $adminUser->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $adminUser->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $adminUser->phone) }}" placeholder="+1 234 567 890">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Role Assignment</label>
                            <input type="text" class="form-control bg-light" value="{{ strtoupper($adminUser->role ?? 'ADMIN') }}" readonly>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                <i class="fas fa-save me-1"></i> Save Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Change Password & Security Card --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-danger d-flex align-items-center">
                        <i class="fas fa-lock me-2"></i> Change Password
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Current Password *</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">New Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Confirm New Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password" required>
                        </div>

                        <div class="p-3 bg-light rounded border mb-4">
                            <div class="small fw-bold text-muted mb-1"><i class="fas fa-shield-alt me-1 text-success"></i> Password Guidelines:</div>
                            <ul class="text-xs text-muted mb-0 ps-3">
                                <li>Minimum 8 characters length</li>
                                <li>Include numbers and special symbols for high security</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger btn-sm px-4">
                                <i class="fas fa-key me-1"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Recent Admin Activity Logs --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary d-flex align-items-center">
                        <i class="fas fa-history me-2"></i> Recent Activity Logs for this Account
                    </h6>
                    <a href="{{ route('activity.logs') }}" class="btn btn-outline-secondary btn-sm">View All Logs</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light small text-muted">
                                <tr>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $act)
                                    <tr>
                                        <td><span class="badge bg-primary">{{ $act->action }}</span></td>
                                        <td class="small">{{ $act->description }}</td>
                                        <td class="small font-monospace">{{ $act->ip_address }}</td>
                                        <td class="small text-muted">{{ $act->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted">No activity records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
