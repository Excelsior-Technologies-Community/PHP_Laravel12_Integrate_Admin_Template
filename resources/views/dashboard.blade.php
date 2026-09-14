@extends('theme.default')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container-fluid px-4">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">

        <div>
            <h1 class="mb-1">
                <i class="fas fa-tachometer-alt me-2"></i>
                Admin Dashboard
            </h1>

            <p class="text-muted mb-0">
                Laravel 12 + SB Admin Management Panel
            </p>
        </div>

        <div>
            <a href="{{ route('users.index') }}" class="btn btn-primary">
                <i class="fas fa-users me-1"></i>
                Manage Users
            </a>

            <a href="{{ route('activity.logs') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-1"></i>
                Activity Logs
            </a>
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- MAIN STATISTICS --}}
    {{-- ========================================================= --}}
    <div class="row">

        {{-- Total Users --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card bg-primary text-white shadow h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="small text-uppercase fw-bold">
                                Total Users
                            </div>

                            <div class="fs-2 fw-bold">
                                {{ number_format($totalUsers) }}
                            </div>
                        </div>

                        <div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>

                    </div>

                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">

                    <a
                        href="{{ route('users.index') }}"
                        class="small text-white text-decoration-none">
                        View Users
                    </a>

                    <i class="fas fa-angle-right"></i>

                </div>

            </div>

        </div>


        {{-- Verified Users --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card bg-success text-white shadow h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="small text-uppercase fw-bold">
                                Verified Users
                            </div>

                            <div class="fs-2 fw-bold">
                                {{ number_format($verifiedUsers) }}
                            </div>

                        </div>

                        <div>
                            <i class="fas fa-user-check fa-3x opacity-50"></i>
                        </div>

                    </div>

                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">

                    <a
                        href="{{ route('users.index', ['status' => 'verified']) }}"
                        class="small text-white text-decoration-none">
                        View Verified
                    </a>

                    <i class="fas fa-angle-right"></i>

                </div>

            </div>

        </div>


        {{-- Today's Users --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card bg-warning text-dark shadow h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="small text-uppercase fw-bold">
                                Today's Users
                            </div>

                            <div class="fs-2 fw-bold">
                                {{ number_format($todayUsers) }}
                            </div>

                        </div>

                        <div>
                            <i class="fas fa-user-plus fa-3x opacity-50"></i>
                        </div>

                    </div>

                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">

                    <a
                        href="{{ route('users.index', [
                            'from_date' => now()->format('Y-m-d'),
                            'to_date' => now()->format('Y-m-d')
                        ]) }}"
                        class="small text-dark text-decoration-none">
                        View Today's Users
                    </a>

                    <i class="fas fa-angle-right"></i>

                </div>

            </div>

        </div>


        {{-- Activity Logs --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card bg-dark text-white shadow h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="small text-uppercase fw-bold">
                                Activity Logs
                            </div>

                            <div class="fs-2 fw-bold">
                                {{ number_format($totalActivities) }}
                            </div>

                        </div>

                        <div>
                            <i class="fas fa-history fa-3x opacity-50"></i>
                        </div>

                    </div>

                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">

                    <a
                        href="{{ route('activity.logs') }}"
                        class="small text-white text-decoration-none">
                        View Activity Logs
                    </a>

                    <i class="fas fa-angle-right"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- USER SUMMARY --}}
    {{-- ========================================================= --}}
    <div class="row">

        <div class="col-xl-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-header">

                    <div class="d-flex align-items-center">

                        <i class="fas fa-chart-pie me-2"></i>

                        <strong>User Summary</strong>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-md-4">

                            <div class="border rounded p-3 mb-3">

                                <div class="text-primary">
                                    <i class="fas fa-calendar-alt fa-2x"></i>
                                </div>

                                <h4 class="mt-2 mb-0">
                                    {{ number_format($newUsersThisMonth) }}
                                </h4>

                                <small class="text-muted">
                                    This Month
                                </small>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="border rounded p-3 mb-3">

                                <div class="text-success">
                                    <i class="fas fa-user-check fa-2x"></i>
                                </div>

                                <h4 class="mt-2 mb-0">
                                    {{ number_format($verifiedUsers) }}
                                </h4>

                                <small class="text-muted">
                                    Verified
                                </small>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="border rounded p-3 mb-3">

                                <div class="text-warning">
                                    <i class="fas fa-user-clock fa-2x"></i>
                                </div>

                                <h4 class="mt-2 mb-0">
                                    {{ number_format($unverifiedUsers) }}
                                </h4>

                                <small class="text-muted">
                                    Unverified
                                </small>

                            </div>

                        </div>

                    </div>


                    {{-- Progress --}}
                    @php
                        $verificationPercentage = $totalUsers > 0
                            ? round(($verifiedUsers / $totalUsers) * 100)
                            : 0;
                    @endphp

                    <div class="mt-3">

                        <div class="d-flex justify-content-between mb-1">

                            <span class="small fw-bold">
                                Email Verification Rate
                            </span>

                            <span class="small fw-bold">
                                {{ $verificationPercentage }}%
                            </span>

                        </div>

                        <div class="progress" style="height: 10px;">

                            <div
                                class="progress-bar bg-success"
                                role="progressbar"
                                style="width: {{ $verificationPercentage }}%;">
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- SYSTEM STATUS --}}
        {{-- ===================================================== --}}
        <div class="col-xl-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-header">

                    <i class="fas fa-server me-2"></i>

                    <strong>System Status</strong>

                </div>

                <div class="card-body">

                    <div class="list-group list-group-flush">

                        <div class="list-group-item d-flex justify-content-between">

                            <span>
                                <i class="fab fa-laravel text-danger me-2"></i>
                                Laravel
                            </span>

                            <span class="badge bg-success">
                                {{ app()->version() }}
                            </span>

                        </div>


                        <div class="list-group-item d-flex justify-content-between">

                            <span>
                                <i class="fab fa-php text-primary me-2"></i>
                                PHP
                            </span>

                            <span class="badge bg-success">
                                {{ PHP_VERSION }}
                            </span>

                        </div>


                        <div class="list-group-item d-flex justify-content-between">

                            <span>
                                <i class="fas fa-database text-info me-2"></i>
                                Database
                            </span>

                            <span class="badge bg-success">
                                Connected
                            </span>

                        </div>


                        <div class="list-group-item d-flex justify-content-between">

                            <span>
                                <i class="fas fa-palette text-warning me-2"></i>
                                Admin Theme
                            </span>

                            <span class="badge bg-primary">
                                SB Admin
                            </span>

                        </div>


                        <div class="list-group-item d-flex justify-content-between">

                            <span>
                                <i class="fas fa-clock text-secondary me-2"></i>
                                Server Time
                            </span>

                            <span class="badge bg-dark">
                                {{ now()->format('Y-m-d H:i:s') }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- LAST 7 DAYS CHART --}}
    {{-- ========================================================= --}}
    <div class="row">

        <div class="col-xl-8 mb-4">

            <div class="card shadow h-100">

                <div class="card-header">

                    <i class="fas fa-chart-line me-2"></i>

                    <strong>User Registrations - Last 7 Days</strong>

                </div>

                <div class="card-body">

                    <div style="height: 320px;">

                        <canvas id="userRegistrationChart"></canvas>

                    </div>

                </div>

            </div>

        </div>


        {{-- Quick Actions --}}
        <div class="col-xl-4 mb-4">

            <div class="card shadow h-100">

                <div class="card-header">

                    <i class="fas fa-bolt me-2"></i>

                    <strong>Quick Actions</strong>

                </div>

                <div class="card-body">

                    <div class="d-grid gap-2">

                        <a
                            href="{{ route('users.index') }}"
                            class="btn btn-primary">

                            <i class="fas fa-users me-2"></i>
                            Manage Users

                        </a>


                        <a
                            href="{{ route('users.index', ['status' => 'verified']) }}"
                            class="btn btn-success">

                            <i class="fas fa-user-check me-2"></i>
                            Verified Users

                        </a>


                        <a
                            href="{{ route('users.index', ['status' => 'unverified']) }}"
                            class="btn btn-warning">

                            <i class="fas fa-user-clock me-2"></i>
                            Unverified Users

                        </a>


                        <a
                            href="{{ route('activity.logs') }}"
                            class="btn btn-dark">

                            <i class="fas fa-history me-2"></i>
                            Activity Logs

                        </a>


                        <a
                            href="{{ route('users.export') }}"
                            class="btn btn-outline-primary">

                            <i class="fas fa-file-csv me-2"></i>
                            Export Users CSV

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MONTHLY CHART --}}
    {{-- ========================================================= --}}
    <div class="row">

        <div class="col-xl-8 mb-4">

            <div class="card shadow h-100">

                <div class="card-header">

                    <i class="fas fa-chart-bar me-2"></i>

                    <strong>User Registrations - Last 6 Months</strong>

                </div>

                <div class="card-body">

                    <div style="height: 320px;">

                        <canvas id="monthlyUserChart"></canvas>

                    </div>

                </div>

            </div>

        </div>


        {{-- Activity Summary --}}
        <div class="col-xl-4 mb-4">

            <div class="card shadow h-100">

                <div class="card-header">

                    <i class="fas fa-info-circle me-2"></i>

                    <strong>Dashboard Information</strong>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <small class="text-muted">
                            Total Users
                        </small>

                        <h4>
                            {{ number_format($totalUsers) }}
                        </h4>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">
                            New This Month
                        </small>

                        <h4 class="text-primary">
                            {{ number_format($newUsersThisMonth) }}
                        </h4>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">
                            Total Activities
                        </small>

                        <h4 class="text-dark">
                            {{ number_format($totalActivities) }}
                        </h4>

                    </div>


                    <div>

                        <small class="text-muted">
                            Verification Rate
                        </small>

                        <h4 class="text-success">
                            {{ $verificationPercentage }}%
                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RECENT ACTIVITY --}}
    {{-- ========================================================= --}}
    <div class="card shadow mb-4">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <i class="fas fa-history me-2"></i>

                    <strong>Recent Admin Activity</strong>

                </div>

                <a
                    href="{{ route('activity.logs') }}"
                    class="btn btn-sm btn-outline-primary">

                    View All

                </a>

            </div>

        </div>


        <div class="card-body p-0">

            @if($recentActivities->count())

                <div class="table-responsive">

                    <table class="table table-hover table-striped mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>ID</th>

                                <th>Action</th>

                                <th>Description</th>

                                <th>IP Address</th>

                                <th>Date & Time</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($recentActivities as $activity)

                                <tr>

                                    <td>
                                        #{{ $activity->id }}
                                    </td>

                                    <td>

                                        @php
                                            $badgeClass = match($activity->action) {
                                                'Dashboard Viewed' => 'primary',
                                                'Users Viewed' => 'info',
                                                'User Viewed' => 'success',
                                                'User Verification Changed' => 'warning',
                                                'Users Exported' => 'dark',
                                                'Activity Logs Exported' => 'secondary',
                                                default => 'secondary',
                                            };
                                        @endphp

                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ $activity->action }}
                                        </span>

                                    </td>

                                    <td>
                                        {{ $activity->description }}
                                    </td>

                                    <td>
                                        <code>
                                            {{ $activity->ip_address ?? 'N/A' }}
                                        </code>
                                    </td>

                                    <td>

                                        <small>

                                            {{ $activity->created_at->format('d M Y') }}

                                            <br>

                                            <span class="text-muted">
                                                {{ $activity->created_at->format('h:i A') }}
                                            </span>

                                        </small>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center p-5">

                    <i class="fas fa-history fa-3x text-muted mb-3"></i>

                    <h5>No Activity Found</h5>

                    <p class="text-muted mb-0">
                        Admin activity will appear here.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection


{{-- ============================================================= --}}
{{-- CHART SCRIPTS --}}
{{-- ============================================================= --}}

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Last 7 Days User Registration Chart
    |--------------------------------------------------------------------------
    */

    const sevenDaysCanvas = document.getElementById('userRegistrationChart');

    if (sevenDaysCanvas) {

        new Chart(sevenDaysCanvas, {

            type: 'line',

            data: {

                labels: @json($lastSevenDaysLabels),

                datasets: [{

                    label: 'New Users',

                    data: @json($lastSevenDaysData),

                    borderWidth: 2,

                    fill: false,

                    lineTension: 0.3,

                    pointRadius: 4

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    xAxes: [{

                        gridLines: {
                            display: false
                        }

                    }],

                    yAxes: [{

                        ticks: {

                            beginAtZero: true,

                            precision: 0

                        }

                    }]

                },

                legend: {

                    display: true

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Monthly User Registration Chart
    |--------------------------------------------------------------------------
    */

    const monthlyCanvas = document.getElementById('monthlyUserChart');

    if (monthlyCanvas) {

        new Chart(monthlyCanvas, {

            type: 'bar',

            data: {

                labels: @json($monthlyLabels),

                datasets: [{

                    label: 'New Users',

                    data: @json($monthlyData),

                    borderWidth: 1

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    xAxes: [{

                        gridLines: {
                            display: false
                        }

                    }],

                    yAxes: [{

                        ticks: {

                            beginAtZero: true,

                            precision: 0

                        }

                    }]

                },

                legend: {

                    display: true

                }

            }

        });

    }

});

</script>

@endsection