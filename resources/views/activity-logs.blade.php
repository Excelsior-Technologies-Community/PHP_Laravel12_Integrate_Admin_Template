@extends('theme.default')

@section('title', 'Admin Activity Logs')

@section('content')

<div class="container-fluid px-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">

        <div>

            <h1 class="mb-1">
                <i class="fas fa-history me-2"></i>
                Admin Activity Logs
            </h1>

            <div class="text-muted">
                Monitor administrator activity and system access
            </div>

        </div>

        <a
            href="{{ route('activity.logs.export', request()->query()) }}"
            class="btn btn-success"
        >

            <i class="fas fa-file-csv me-1"></i>

            Export CSV

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- STATISTICS --}}
    {{-- ========================================================= --}}

    <div class="row mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card bg-primary text-white mb-3">

                <div class="card-body">

                    <div class="small">
                        Total Activities
                    </div>

                    <h2 class="mb-0">
                        {{ $totalActivities }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card bg-success text-white mb-3">

                <div class="card-body">

                    <div class="small">
                        Today
                    </div>

                    <h2 class="mb-0">
                        {{ $todayActivities }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card bg-warning text-dark mb-3">

                <div class="card-body">

                    <div class="small">
                        This Week
                    </div>

                    <h2 class="mb-0">
                        {{ $thisWeekActivities }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card bg-danger text-white mb-3">

                <div class="card-body">

                    <div class="small">
                        This Month
                    </div>

                    <h2 class="mb-0">
                        {{ $thisMonthActivities }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    {{-- Top Action --}}
    @if($topAction)

        <div class="alert alert-light border mb-4">

            <i class="fas fa-chart-line me-1"></i>

            Most frequent action:

            <strong>
                {{ $topAction->action }}
            </strong>

            <span class="badge bg-primary">
                {{ $topAction->total }}
            </span>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- FILTERS --}}
    {{-- ========================================================= --}}

    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-filter me-1"></i>

            Activity Filters

        </div>

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('activity.logs') }}"
            >

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Action, description or IP..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- Action --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Action
                        </label>

                        <select
                            name="action"
                            class="form-select"
                        >

                            <option value="">
                                All Actions
                            </option>

                            @foreach($actions as $action)

                                <option
                                    value="{{ $action }}"
                                    {{ request('action') === $action ? 'selected' : '' }}
                                >
                                    {{ $action }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Date From --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Date From
                        </label>

                        <input
                            type="date"
                            name="date_from"
                            class="form-control"
                            value="{{ request('date_from') }}"
                        >

                    </div>


                    {{-- Date To --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Date To
                        </label>

                        <input
                            type="date"
                            name="date_to"
                            class="form-control"
                            value="{{ request('date_to') }}"
                        >

                    </div>


                    {{-- Per Page --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Per Page
                        </label>

                        <select
                            name="per_page"
                            class="form-select"
                        >

                            @foreach([5, 10, 15, 25, 50, 100] as $value)

                                <option
                                    value="{{ $value }}"
                                    {{ $perPage == $value ? 'selected' : '' }}
                                >
                                    {{ $value }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <div class="mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-search me-1"></i>

                        Apply Filters

                    </button>


                    <a
                        href="{{ route('activity.logs') }}"
                        class="btn btn-secondary"
                    >

                        <i class="fas fa-sync me-1"></i>

                        Reset

                    </a>


                    <a
                        href="{{ route('activity.logs.export', request()->query()) }}"
                        class="btn btn-success"
                    >

                        <i class="fas fa-download me-1"></i>

                        Export Filtered

                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CLEANUP --}}
    {{-- ========================================================= --}}

    <div class="card mb-4 border-danger">

        <div class="card-header text-danger">

            <i class="fas fa-trash-alt me-1"></i>

            Activity Log Cleanup

        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('activity.logs.cleanup') }}"
                onsubmit="return confirm('Are you sure you want to delete old activity logs?');"
            >

                @csrf
                @method('DELETE')

                <div class="row align-items-end">

                    <div class="col-md-4">

                        <label class="form-label">
                            Delete logs older than
                        </label>

                        <select
                            name="days"
                            class="form-select"
                        >

                            <option value="7">
                                7 days
                            </option>

                            <option value="15">
                                15 days
                            </option>

                            <option
                                value="30"
                                selected
                            >
                                30 days
                            </option>

                            <option value="60">
                                60 days
                            </option>

                            <option value="90">
                                90 days
                            </option>

                            <option value="180">
                                180 days
                            </option>

                            <option value="365">
                                365 days
                            </option>

                        </select>

                    </div>

                    <div class="col-md-3">

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >

                            <i class="fas fa-trash-alt me-1"></i>

                            Cleanup Logs

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle me-1"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- TABLE --}}
    {{-- ========================================================= --}}

    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-table me-1"></i>

            Activity History

        </div>

        <div class="card-body">

            @if($activities->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>
                                    #
                                </th>

                                <th>
                                    Action
                                </th>

                                <th>
                                    Description
                                </th>

                                <th>
                                    IP Address
                                </th>

                                <th>
                                    Date & Time
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($activities as $activity)

                                <tr>

                                    <td>
                                        #{{ $activity->id }}
                                    </td>

                                    <td>

                                        @php

                                            $badgeClass = match(
                                                $activity->action
                                            ) {

                                                'Dashboard Viewed'
                                                    => 'bg-primary',

                                                'Users Viewed'
                                                    => 'bg-info',

                                                'User Viewed'
                                                    => 'bg-success',

                                                default
                                                    => 'bg-secondary',

                                            };

                                        @endphp

                                        <span
                                            class="badge {{ $badgeClass }}"
                                        >

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

                                        {{ $activity->created_at->format('d M Y') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $activity->created_at->format('h:i:s A') }}

                                        </small>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Number-only pagination --}}
                @if($activities->lastPage() > 1)

                    <div class="mt-4">

                        <div class="text-center mb-2">

                            <small class="text-muted">

                                Page
                                {{ $activities->currentPage() }}
                                of
                                {{ $activities->lastPage() }}

                            </small>

                        </div>

                        <div class="activity-pagination">

                            @for(
                                $page = 1;
                                $page <= $activities->lastPage();
                                $page++
                            )

                                <a
                                    href="{{ $activities->url($page) }}"
                                    class="activity-page {{ $page == $activities->currentPage() ? 'active' : '' }}"
                                >
                                    {{ $page }}
                                </a>

                            @endfor

                        </div>

                    </div>

                @endif

            @else

                <div class="alert alert-info mb-0">

                    <i class="fas fa-info-circle me-1"></i>

                    No activity logs found.

                </div>

            @endif

        </div>

    </div>

</div>


<style>

.activity-pagination {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 6px;
}

.activity-page {
    width: 38px;
    height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 1px solid #dee2e6;
    border-radius: 6px;

    text-decoration: none;

    color: #0d6efd;
    background: #fff;
}

.activity-page:hover,
.activity-page.active {
    background: #0d6efd;
    color: #fff;
}

</style>

@endsection