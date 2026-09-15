@extends('theme.default')

@section('title', 'System Settings Hub - Admin Panel')

@section('content')
<div class="container-fluid px-4">
    <div class="mt-4 mb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bold d-flex align-items-center">
            <i class="fas fa-sliders-h me-2 text-primary"></i> System Settings Hub
        </h1>
        <p class="text-muted small mb-0">Configure application metadata, toggle maintenance mode, test SMTP email server, and manage database backups.</p>
    </div>

    {{-- Nav Tabs --}}
    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                <i class="fas fa-cog me-1"></i> General Settings
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" type="button" role="tab" aria-controls="maintenance" aria-selected="false">
                <i class="fas fa-tools me-1 text-warning"></i> Maintenance Mode
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="smtp-tab" data-bs-toggle="tab" data-bs-target="#smtp" type="button" role="tab" aria-controls="smtp" aria-selected="false">
                <i class="fas fa-envelope me-1 text-info"></i> SMTP & Email Tester
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="backup-tab" data-bs-toggle="tab" data-bs-target="#backup" type="button" role="tab" aria-controls="backup" aria-selected="false">
                <i class="fas fa-database me-1 text-success"></i> Database Backups
            </button>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content" id="settingsTabContent">

        {{-- 1. General Settings Tab --}}
        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Application Branding & Metadata</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.general') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Site Display Name *</label>
                                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name']) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Admin Notification Email *</label>
                                <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email', $settings['admin_email']) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Application Description</label>
                            <textarea name="site_description" rows="2" class="form-control">{{ old('site_description', $settings['site_description']) }}</textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Default Timezone *</label>
                                <select name="timezone" class="form-select">
                                    <option value="UTC" {{ $settings['timezone'] === 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="Asia/Kolkata" {{ $settings['timezone'] === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
                                    <option value="America/New_York" {{ $settings['timezone'] === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                                    <option value="Europe/London" {{ $settings['timezone'] === 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Header Logo (Optional)</label>
                                <input type="file" name="logo" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Browser Favicon (Optional)</label>
                                <input type="file" name="favicon" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                <i class="fas fa-save me-1"></i> Save General Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- 2. Maintenance Mode Tab --}}
        <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="maintenance-tab">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-warning d-flex align-items-center">
                        <i class="fas fa-tools me-2"></i> Maintenance Mode Control
                    </h6>
                    <span class="badge {{ $settings['maintenance_mode'] ? 'bg-danger' : 'bg-success' }} px-3 py-2">
                        Status: {{ $settings['maintenance_mode'] ? 'ENABLED (OFFLINE)' : 'DISABLED (ONLINE)' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="p-4 rounded border {{ $settings['maintenance_mode'] ? 'bg-danger bg-opacity-10 border-danger' : 'bg-light' }} mb-4">
                        <h5 class="fw-bold {{ $settings['maintenance_mode'] ? 'text-danger' : 'text-dark' }}">
                            {{ $settings['maintenance_mode'] ? 'Application is currently in Maintenance Mode' : 'Application is currently LIVE' }}
                        </h5>
                        <p class="text-muted small mb-0">
                            When maintenance mode is enabled, non-admin visitors will receive a friendly 503 maintenance page. You can toggle this state instantly with one click.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('settings.maintenance') }}">
                        @csrf
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn {{ $settings['maintenance_mode'] ? 'btn-success' : 'btn-danger' }} px-4 py-2 fw-bold" onclick="return confirm('Are you sure you want to change the maintenance mode status?')">
                                @if($settings['maintenance_mode'])
                                    <i class="fas fa-play me-1"></i> Disable Maintenance Mode (Go Live)
                                @else
                                    <i class="fas fa-power-off me-1"></i> Enable Maintenance Mode
                                @endif
                            </button>
                            <span class="text-muted small">Bypass Key: <code class="text-primary font-monospace">admin-bypass-key</code></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- 3. SMTP & Email Settings Tester Tab --}}
        <div class="tab-pane fade" id="smtp" role="tabpanel" aria-labelledby="smtp-tab">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-info"><i class="fas fa-envelope me-2"></i> Email Server Configuration & Real-Time Tester</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.email.test') }}">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">SMTP Host</label>
                                <input type="text" name="smtp_host" class="form-control" value="{{ old('smtp_host', $settings['smtp_host']) }}" placeholder="e.g. smtp.mailgun.org">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">SMTP Port</label>
                                <input type="number" name="smtp_port" class="form-control" value="{{ old('smtp_port', $settings['smtp_port']) }}" placeholder="587">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Encryption</label>
                                <select name="smtp_encryption" class="form-select">
                                    <option value="tls" {{ $settings['smtp_encryption'] === 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ $settings['smtp_encryption'] === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="null" {{ $settings['smtp_encryption'] === 'null' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">SMTP Username</label>
                                <input type="text" name="smtp_username" class="form-control" value="{{ old('smtp_username', $settings['smtp_username']) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">SMTP Password</label>
                                <input type="password" name="smtp_password" class="form-control" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded border mb-4">
                            <h6 class="fw-bold text-dark small mb-2"><i class="fas fa-paper-plane me-1 text-primary"></i> Send Real-time Test Email</h6>
                            <div class="row g-2 align-items-center">
                                <div class="col-md-8">
                                    <input type="email" name="test_recipient" class="form-control form-control-sm" placeholder="Enter recipient email (e.g. your-email@example.com)" required>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-info btn-sm text-white w-100 fw-bold">
                                        <i class="fas fa-paper-plane me-1"></i> Dispatch Test Mail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- 4. Database Backups Tab --}}
        <div class="tab-pane fade" id="backup" role="tabpanel" aria-labelledby="backup-tab">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-success"><i class="fas fa-database me-2"></i> Database Backup Snapshots</h6>
                    <form method="POST" action="{{ route('settings.backup.create') }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm d-flex align-items-center shadow-sm">
                            <i class="fas fa-plus-circle me-1"></i> Create New Backup Now
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light text-uppercase small text-muted">
                                <tr>
                                    <th>Backup Filename</th>
                                    <th>File Size</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th width="140" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backups as $b)
                                    <tr>
                                        <td><span class="font-monospace fw-bold text-dark"><i class="fas fa-file-code me-2 text-secondary"></i> {{ $b->filename }}</span></td>
                                        <td class="font-monospace small">{{ $b->formatted_size }}</td>
                                        <td class="small">{{ $b->created_by }}</td>
                                        <td class="small text-muted">{{ $b->created_at->format('d M Y, h:i A') }}</td>
                                        <td><span class="badge bg-success">Ready</span></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('settings.backup.download', $b->id) }}" class="btn btn-outline-primary" title="Download SQL Dump">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <form method="POST" action="{{ route('settings.backup.delete', $b->id) }}" class="d-inline" onsubmit="return confirm('Delete backup file {{ $b->filename }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Delete Backup">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-database fa-2x mb-2 d-block text-gray-300"></i>
                                            No database backup files found. Click "Create New Backup Now" to create a fresh snapshot.
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
</div>
@endsection
