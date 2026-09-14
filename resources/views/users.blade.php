@extends('theme.default')

@section('title', 'User Management')

@section('content')

<div class="container-fluid px-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">

        <div>

            <h1 class="mb-1">
                <i class="fas fa-users me-2"></i>
                User Management
            </h1>

            <div class="text-muted">
                Search, filter, sort and export registered users
            </div>

        </div>

        <a
            href="{{ route('users.export', request()->query()) }}"
            class="btn btn-success"
        >
            <i class="fas fa-file-csv me-1"></i>
            Export CSV
        </a>

    </div>


    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card bg-primary text-white">

                <div class="card-body">

                    <div class="small">
                        Matching Users
                    </div>

                    <h3 class="mb-0">
                        {{ $users->total() }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card bg-success text-white">

                <div class="card-body">

                    <div class="small">
                        Current Page
                    </div>

                    <h3 class="mb-0">
                        {{ $users->count() }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card bg-info text-white">

                <div class="card-body">

                    <div class="small">
                        Per Page
                    </div>

                    <h3 class="mb-0">
                        {{ $perPage }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Filters --}}
    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-filter me-1"></i>

            Search & Filters

        </div>

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('users.index') }}"
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
                            placeholder="Name or email..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- Status --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                All
                            </option>

                            <option
                                value="verified"
                                {{ request('status') === 'verified' ? 'selected' : '' }}
                            >
                                Verified
                            </option>

                            <option
                                value="unverified"
                                {{ request('status') === 'unverified' ? 'selected' : '' }}
                            >
                                Unverified
                            </option>

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

                            @foreach([5, 10, 20, 30, 50] as $value)

                                <option
                                    value="{{ $value }}"
                                    {{ $perPage == $value ? 'selected' : '' }}
                                >
                                    {{ $value }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Sort --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Sort By
                        </label>

                        <select
                            name="sort"
                            class="form-select"
                        >

                            <option
                                value="created_at"
                                {{ $sort === 'created_at' ? 'selected' : '' }}
                            >
                                Created Date
                            </option>

                            <option
                                value="name"
                                {{ $sort === 'name' ? 'selected' : '' }}
                            >
                                Name
                            </option>

                            <option
                                value="email"
                                {{ $sort === 'email' ? 'selected' : '' }}
                            >
                                Email
                            </option>

                            <option
                                value="id"
                                {{ $sort === 'id' ? 'selected' : '' }}
                            >
                                ID
                            </option>

                        </select>

                    </div>


                    {{-- Direction --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Order
                        </label>

                        <select
                            name="direction"
                            class="form-select"
                        >

                            <option
                                value="desc"
                                {{ $direction === 'desc' ? 'selected' : '' }}
                            >
                                Descending
                            </option>

                            <option
                                value="asc"
                                {{ $direction === 'asc' ? 'selected' : '' }}
                            >
                                Ascending
                            </option>

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
                        href="{{ route('users.index') }}"
                        class="btn btn-secondary"
                    >
                        <i class="fas fa-sync me-1"></i>
                        Reset
                    </a>

                    <a
                        href="{{ route('users.export', request()->query()) }}"
                        class="btn btn-success"
                    >
                        <i class="fas fa-download me-1"></i>
                        Export Filtered
                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- Users Table --}}
    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-table me-1"></i>

            Users List

        </div>

        <div class="card-body">

            @if($users->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>
                                    #
                                </th>

                                <th>
                                    User
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Verification
                                </th>

                                <th>
                                    Registered
                                </th>

                                <th width="100">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($users as $user)

                                <tr>

                                    <td>
                                        #{{ $user->id }}
                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width:40px;height:40px;"
                                            >

                                                <strong>
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </strong>

                                            </div>

                                            <strong>
                                                {{ $user->name }}
                                            </strong>

                                        </div>

                                    </td>

                                    <td>
                                        {{ $user->email }}
                                    </td>

                                    <td>

                                        @if($user->email_verified_at)

                                            <span class="badge bg-success">

                                                <i class="fas fa-check-circle me-1"></i>

                                                Verified

                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark">

                                                <i class="fas fa-clock me-1"></i>

                                                Unverified

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ $user->created_at->format('d M Y') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $user->created_at->format('h:i A') }}

                                        </small>

                                    </td>

                                    <td>

                                        <a
                                            href="{{ route('users.show', $user) }}"
                                            class="btn btn-sm btn-primary"
                                        >

                                            <i class="fas fa-eye"></i>

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if($users->lastPage() > 1)

                    <div class="mt-4">

                        <div class="text-center mb-2">

                            <small class="text-muted">
                                Page {{ $users->currentPage() }}
                                of {{ $users->lastPage() }}
                            </small>

                        </div>

                        <div class="d-flex justify-content-center">

                            <div class="user-pagination">

                                @for(
                                    $page = 1;
                                    $page <= $users->lastPage();
                                    $page++
                                )

                                    <a
                                        href="{{ $users->url($page) }}"
                                        class="page-number {{ $page == $users->currentPage() ? 'active' : '' }}"
                                    >
                                        {{ $page }}
                                    </a>

                                @endfor

                            </div>

                        </div>

                    </div>

                @endif

            @else

                <div class="alert alert-info">

                    <i class="fas fa-info-circle me-1"></i>

                    No users found matching your filters.

                </div>

            @endif

        </div>

    </div>

</div>


<style>

.user-pagination {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    justify-content: center;
}

.page-number {
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

.page-number:hover,
.page-number.active {
    background: #0d6efd;
    color: #fff;
}

</style>

@endsection