@extends('theme.default')

@section('title', 'Admin Dashboard - Overview & Analytics')

@section('content')
<div class="container-fluid px-4">
    {{-- Top Header with Dynamic Date Filter --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 mb-3 gap-3">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Admin Dashboard Overview</h1>
            <p class="text-muted small mb-0">Real-time statistics, registrations, user activity metrics, and analytics.</p>
        </div>

        {{-- Dynamic Date Filter Form --}}
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex flex-wrap align-items-center gap-2" id="dateFilterForm">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-primary"></i></span>
                <select name="date_filter" class="form-select form-select-sm fw-semibold" onchange="toggleCustomDateInputs(this.value); if(this.value !== 'custom') this.form.submit();">
                    <option value="today" {{ $dateFilter === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="7_days" {{ $dateFilter === '7_days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30_days" {{ $dateFilter === '30_days' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="this_month" {{ $dateFilter === 'this_month' ? 'selected' : '' }}>This Month</option>
                    <option value="custom" {{ $dateFilter === 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                </select>
            </div>

            <div id="customDateContainer" class="d-flex gap-1 {{ $dateFilter === 'custom' ? '' : 'd-none' }}">
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control form-control-sm">
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control form-control-sm">
                <button type="submit" class="btn btn-sm btn-primary">Apply</button>
            </div>
        </form>
    </div>

    {{-- Metric Cards Row --}}
    <div class="row g-3 mb-4">
        {{-- Total Users --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 border-start border-primary border-4 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ $totalUsers }}</div>
                            <div class="text-xs text-muted mt-1">Total registered accounts</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Users --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 border-start border-success border-4 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Active Accounts</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ $activeUsers }}</div>
                            <div class="text-xs text-success mt-1 fw-semibold">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 100 }}% of total</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-success opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtered Registrations --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 border-start border-info border-4 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Period Registrations</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ $filteredUsersCount }}</div>
                            <div class="text-xs text-muted mt-1">In selected time frame</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-info opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Activity Logs --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 border-start border-warning border-4 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Audit Events</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ $totalActivities }}</div>
                            <div class="text-xs text-muted mt-1">Logged admin actions</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-history fa-2x text-warning opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row g-4 mb-4">
        {{-- Area Chart --}}
        <div class="col-xl-8">
            <div class="card shadow-sm border-0 mb-4 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-chart-area me-2"></i> User Registration Trend (Selected Range)</h6>
                    <span class="badge bg-light text-dark border">{{ strtoupper(str_replace('_', ' ', $dateFilter)) }}</span>
                </div>
                <div class="card-body">
                    <canvas id="userTrendChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="col-xl-4">
            <div class="card shadow-sm border-0 mb-4 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-success"><i class="fas fa-chart-bar me-2"></i> Monthly Growth Breakdown</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlyGrowthChart" width="100%" height="70"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Tables Row --}}
    <div class="row g-4 mb-4">
        {{-- Recent Users --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-users me-2"></i> Recently Registered Users</h6>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small text-muted text-uppercase">
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $u)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="user-avatar-sm me-2 border">
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $u->name }}</div>
                                                    <div class="small text-muted">{{ $u->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ ucfirst($u->role ?? 'User') }}</span></td>
                                        <td>{!! $u->status_badge !!}</td>
                                        <td class="small text-muted">{{ $u->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity Stream --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-warning"><i class="fas fa-history me-2"></i> Recent Audit Log Stream</h6>
                    <a href="{{ route('activity.logs') }}" class="btn btn-sm btn-outline-warning">View All Logs</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small text-muted text-uppercase">
                                <tr>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $act)
                                    <tr>
                                        <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $act->action }}</span></td>
                                        <td class="small text-dark">{{ $act->description }}</td>
                                        <td class="small text-muted">{{ $act->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted">No audit activity logged.</td>
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

@section('scripts')
<script>
    function toggleCustomDateInputs(val) {
        const container = document.getElementById('customDateContainer');
        if (val === 'custom') {
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // User Registration Trend Area Chart
        const ctxArea = document.getElementById("userTrendChart");
        if (ctxArea) {
            new Chart(ctxArea, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: "New Registrations",
                        lineTension: 0.3,
                        backgroundColor: "rgba(13, 110, 253, 0.08)",
                        borderColor: "rgba(13, 110, 253, 1)",
                        pointRadius: 4,
                        pointBackgroundColor: "rgba(13, 110, 253, 1)",
                        pointBorderColor: "#fff",
                        pointHoverRadius: 5,
                        data: {!! json_encode($chartData) !!},
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{ gridLines: { display: false } }],
                        yAxes: [{ ticks: { min: 0, precision: 0 }, gridLines: { color: "rgba(0, 0, 0, .05)" } }],
                    },
                    legend: { display: false }
                }
            });
        }

        // Monthly Breakdown Bar Chart
        const ctxBar = document.getElementById("monthlyGrowthChart");
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyLabels) !!},
                    datasets: [{
                        label: "Registrations",
                        backgroundColor: "rgba(25, 135, 84, 0.8)",
                        borderColor: "rgba(25, 135, 84, 1)",
                        data: {!! json_encode($monthlyData) !!},
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{ gridLines: { display: false } }],
                        yAxes: [{ ticks: { min: 0, precision: 0 }, gridLines: { color: "rgba(0, 0, 0, .05)" } }],
                    },
                    legend: { display: false }
                }
            });
        }
    });
</script>
@endsection