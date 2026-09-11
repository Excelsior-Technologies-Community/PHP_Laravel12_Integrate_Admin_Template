@extends('theme.default')

@section('title', 'User Details')

@section('content')

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">

        <div>

            <h1 class="mb-1">
                User Details
            </h1>

            <div class="text-muted">
                View complete user information
            </div>

        </div>

        <a
            href="{{ route('users.index') }}"
            class="btn btn-secondary"
        >
            <i class="fas fa-arrow-left me-1"></i>
            Back to Users
        </a>

    </div>


    <div class="row">

        {{-- User Profile --}}
        <div class="col-xl-4">

            <div class="card mb-4">

                <div class="card-header">

                    <i class="fas fa-user me-1"></i>

                    Profile

                </div>

                <div class="card-body text-center">

                    <div
                        class="bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width:100px;height:100px;font-size:40px;"
                    >

                        {{ strtoupper(substr($user->name, 0, 1)) }}

                    </div>

                    <h3>
                        {{ $user->name }}
                    </h3>

                    <p class="text-muted mb-3">
                        {{ $user->email }}
                    </p>

                    @if($user->email_verified_at)

                        <span class="badge bg-success fs-6">

                            <i class="fas fa-check-circle me-1"></i>

                            Verified Account

                        </span>

                    @else

                        <span class="badge bg-warning text-dark fs-6">

                            <i class="fas fa-clock me-1"></i>

                            Email Not Verified

                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- User Information --}}
        <div class="col-xl-8">

            <div class="card mb-4">

                <div class="card-header">

                    <i class="fas fa-info-circle me-1"></i>

                    Account Information

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>

                            <th width="30%">
                                User ID
                            </th>

                            <td>
                                #{{ $user->id }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Full Name
                            </th>

                            <td>
                                {{ $user->name }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Email
                            </th>

                            <td>
                                {{ $user->email }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Email Status
                            </th>

                            <td>

                                @if($user->email_verified_at)

                                    <span class="badge bg-success">
                                        Verified
                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark">
                                        Unverified
                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Registered At
                            </th>

                            <td>

                                {{ $user->created_at->format('d M Y, h:i A') }}

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Last Updated
                            </th>

                            <td>

                                {{ $user->updated_at->format('d M Y, h:i A') }}

                            </td>

                        </tr>

                        @if($user->email_verified_at)

                            <tr>

                                <th>
                                    Email Verified At
                                </th>

                                <td>

                                    {{ $user->email_verified_at->format('d M Y, h:i A') }}

                                </td>

                            </tr>

                        @endif

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection