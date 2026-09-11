@extends('theme.default')

@section('title', 'User Management')

@section('content')

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">

        <div>

            <h1 class="mb-1">
                User Management
            </h1>

            <div class="text-muted">
                Search, filter and manage registered users
            </div>

        </div>

        <span class="badge bg-primary fs-6">
            {{ $users->total() }} Users
        </span>

    </div>


    {{-- ========================================================= --}}
    {{-- SEARCH & FILTER --}}
    {{-- ========================================================= --}}

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
                    <div class="col-md-5">

                        <label class="form-label">
                            Search User
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search by name or email..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Verification Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                All Users
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


                    {{-- Sort --}}
                    <div class="col-md-2">

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
                    <div class="col-md-2">

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

                </div>

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- USERS TABLE --}}
    {{-- ========================================================= --}}

    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-users me-1"></i>

            Users List

        </div>

        <div class="card-body">

            @if($users->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>
                                    ID
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

                                <th width="120">
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

                                            <div>

                                                <strong>
                                                    {{ $user->name }}
                                                </strong>

                                            </div>

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

                                            View

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}

                <div class="d-flex justify-content-between align-items-center mt-3">

                    <div class="text-muted">

                        Showing
                        {{ $users->firstItem() }}
                        to
                        {{ $users->lastItem() }}
                        of
                        {{ $users->total() }}
                        users

                    </div>

                    <div>

                        {{ $users->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            @else

                <div class="alert alert-info">

                    <i class="fas fa-info-circle me-1"></i>

                    No users found matching your search/filter.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection