@extends('theme.default')

@section('title', 'Admin Activity Logs')

@section('content')

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">

        <div>

            <h1 class="mb-1">
                Admin Activity Logs
            </h1>

            <div class="text-muted">
                Monitor administrator activity and system access
            </div>

        </div>

        <span class="badge bg-primary fs-6">
            {{ $activities->total() }} Activities
        </span>

    </div>


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
                    <div class="col-md-5">

                        <label class="form-label">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search action, description or IP..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- Action --}}
                    <div class="col-md-3">

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


                    {{-- Date --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            class="form-control"
                            value="{{ request('date') }}"
                        >

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-2 d-flex align-items-end">

                        <div>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="fas fa-search"></i>

                            </button>

                            <a
                                href="{{ route('activity.logs') }}"
                                class="btn btn-secondary"
                            >

                                <i class="fas fa-sync"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ACTIVITY TABLE --}}
    {{-- ========================================================= --}}

    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-history me-1"></i>

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
                                        {{ $activity->id }}
                                    </td>

                                    <td>

                                        @php

                                            $badgeClass = match($activity->action) {

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

                                        <span class="badge {{ $badgeClass }}">

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


                {{-- Pagination --}}

                <div class="d-flex justify-content-end mt-3">

                    {{ $activities->links('pagination::bootstrap-5') }}

                </div>

            @else

                <div class="alert alert-info mb-0">

                    <i class="fas fa-info-circle me-1"></i>

                    No activity logs found.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection