@extends('theme.default')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container-fluid px-4">

    {{-- Page Heading --}}
    <h1 class="mt-4">
        Admin Dashboard
    </h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">
            Dashboard
        </li>
    </ol>

    {{-- ========================================================= --}}
    {{-- STATISTICS CARDS --}}
    {{-- ========================================================= --}}

    <div class="row">

        {{-- Total Users --}}
        <div class="col-xl-3 col-md-6">

            <div class="card bg-primary text-white mb-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="small">
                                Total Users
                            </div>

                            <h2 class="mb-0">
                                {{ $totalUsers }}
                            </h2>
                        </div>

                        <i class="fas fa-users fa-2x opacity-75"></i>

                    </div>

                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">

                    <a
                        class="small text-white stretched-link"
                        href="{{ route('users.index') }}"
                    >
                        View Users
                    </a>

                    <i class="fas fa-angle-right"></i>

                </div>

            </div>

        </div>

        {{-- Verified Users --}}
        <div class="col-xl-3 col-md-6">

            <div class="card bg-success text-white mb-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="small">
                                Verified Users
                            </div>

                            <h2 class="mb-0">
                                {{ $verifiedUsers }}
                            </h2>

                        </div>

                        <i class="fas fa-user-check fa-2x opacity-75"></i>

                    </div>

                </div>

                <div class="card-footer">

                    <span class="small">
                        Email verified accounts
                    </span>

                </div>

            </div>

        </div>

        {{-- Today's Users --}}
        <div class="col-xl-3 col-md-6">

            <div class="card bg-warning text-white mb-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="small">
                                Today's Users
                            </div>

                            <h2 class="mb-0">
                                {{ $todayUsers }}
                            </h2>

                        </div>

                        <i class="fas fa-user-plus fa-2x opacity-75"></i>

                    </div>

                </div>

                <div class="card-footer">

                    <span class="small">
                        Registered today
                    </span>

                </div>

            </div>

        </div>

        {{-- Activity Logs --}}
        <div class="col-xl-3 col-md-6">

            <div class="card bg-danger text-white mb-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="small">
                                Activity Logs
                            </div>

                            <h2 class="mb-0">
                                {{ $totalActivities }}
                            </h2>

                        </div>

                        <i class="fas fa-history fa-2x opacity-75"></i>

                    </div>

                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">

                    <a
                        class="small text-white stretched-link"
                        href="{{ route('activity.logs') }}"
                    >
                        View Activity
                    </a>

                    <i class="fas fa-angle-right"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- SECONDARY STATISTICS --}}
    {{-- ========================================================= --}}

    <div class="row">

        <div class="col-xl-6">

            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-user-clock me-1"></i>
                    User Registration Summary
                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-md-4">

                            <h4 class="text-primary">
                                {{ $newUsersThisMonth }}
                            </h4>

                            <small class="text-muted">
                                This Month
                            </small>

                        </div>

                        <div class="col-md-4">

                            <h4 class="text-success">
                                {{ $verifiedUsers }}
                            </h4>

                            <small class="text-muted">
                                Verified
                            </small>

                        </div>

                        <div class="col-md-4">

                            <h4 class="text-danger">
                                {{ $unverifiedUsers }}
                            </h4>

                            <small class="text-muted">
                                Unverified
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-6">

            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Admin Panel Status
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">
                        <span>Laravel</span>
                        <span class="badge bg-success">
                            12.x
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Admin Template</span>
                        <span class="badge bg-primary">
                            SB Admin
                        </span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Database</span>
                        <span class="badge bg-success">
                            Connected
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- USER REGISTRATION CHART --}}
    {{-- ========================================================= --}}

    <div class="row">

        <div class="col-xl-7">

            <div class="card mb-4">

                <div class="card-header">

                    <i class="fas fa-chart-area me-1"></i>

                    User Registrations - Last 7 Days

                </div>

                <div class="card-body">

                    <canvas
                        id="myAreaChart"
                        width="100%"
                        height="40"
                    ></canvas>

                </div>

            </div>

        </div>


        <div class="col-xl-5">

            <div class="card mb-4">

                <div class="card-header">

                    <i class="fas fa-chart-bar me-1"></i>

                    Monthly User Registrations

                </div>

                <div class="card-body">

                    <canvas
                        id="myBarChart"
                        width="100%"
                        height="40"
                    ></canvas>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RECENT ACTIVITY --}}
    {{-- ========================================================= --}}

    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-history me-1"></i>

            Recent Admin Activity

            <a
                href="{{ route('activity.logs') }}"
                class="btn btn-sm btn-primary float-end"
            >
                View All
            </a>

        </div>

        <div class="card-body">

            @if($recentActivities->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-light">

                            <tr>
                                <th>Action</th>
                                <th>Description</th>
                                <th>IP Address</th>
                                <th>Date</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($recentActivities as $activity)

                                <tr>

                                    <td>

                                        <span class="badge bg-primary">

                                            {{ $activity->action }}

                                        </span>

                                    </td>

                                    <td>
                                        {{ $activity->description }}
                                    </td>

                                    <td>
                                        {{ $activity->ip_address ?? 'N/A' }}
                                    </td>

                                    <td>

                                        {{ $activity->created_at->format('d M Y, h:i A') }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-info mb-0">
                    No admin activities found.
                </div>

            @endif

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Area Chart - Last 7 Days
    |--------------------------------------------------------------------------
    */

    const areaCanvas = document.getElementById('myAreaChart');

    if (areaCanvas) {

        new Chart(areaCanvas, {

            type: 'line',

            data: {

                labels: @json($lastSevenDaysLabels),

                datasets: [{

                    label: 'New Users',

                    lineTension: 0.3,

                    backgroundColor: 'rgba(2,117,216,0.2)',

                    borderColor: 'rgba(2,117,216,1)',

                    pointRadius: 5,

                    pointBackgroundColor: 'rgba(2,117,216,1)',

                    pointBorderColor: 'rgba(255,255,255,0.8)',

                    pointHoverRadius: 5,

                    pointHoverBackgroundColor: 'rgba(2,117,216,1)',

                    pointHitRadius: 50,

                    pointBorderWidth: 2,

                    data: @json($lastSevenDaysData)

                }]

            },

            options: {

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
                    display: false
                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Bar Chart - Monthly
    |--------------------------------------------------------------------------
    */

    const barCanvas = document.getElementById('myBarChart');

    if (barCanvas) {

        new Chart(barCanvas, {

            type: 'bar',

            data: {

                labels: @json($monthlyLabels),

                datasets: [{

                    label: 'New Users',

                    backgroundColor: 'rgba(40,167,69,0.8)',

                    borderColor: 'rgba(40,167,69,1)',

                    data: @json($monthlyData)

                }]

            },

            options: {

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
                    display: false
                }

            }

        });

    }

});

</script>

@endsection