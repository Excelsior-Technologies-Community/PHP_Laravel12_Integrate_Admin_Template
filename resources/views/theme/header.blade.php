<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    {{-- ========================================================= --}}
    {{-- BRAND --}}
    {{-- ========================================================= --}}

    <a
        class="navbar-brand ps-3"
        href="{{ route('dashboard') }}">

        <i class="fas fa-shield-alt me-2"></i>

        Laravel Admin

    </a>


    {{-- ========================================================= --}}
    {{-- SIDEBAR TOGGLE --}}
    {{-- ========================================================= --}}

    <button
        class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
        id="sidebarToggle"
        href="#!">

        <i class="fas fa-bars"></i>

    </button>


    {{-- ========================================================= --}}
    {{-- RIGHT NAVIGATION --}}
    {{-- ========================================================= --}}

    <ul class="navbar-nav ms-auto me-3 me-lg-4">


        {{-- ===================================================== --}}
        {{-- ACTIVITY LOG --}}
        {{-- ===================================================== --}}

        <li class="nav-item">

            <a
                class="nav-link position-relative"
                href="{{ route('activity.logs') }}"
                title="Activity Logs">

                <i class="fas fa-history fa-fw"></i>

            </a>

        </li>


        {{-- ===================================================== --}}
        {{-- USERS --}}
        {{-- ===================================================== --}}

        <li class="nav-item">

            <a
                class="nav-link"
                href="{{ route('users.index') }}"
                title="Users">

                <i class="fas fa-users fa-fw"></i>

            </a>

        </li>


        {{-- ===================================================== --}}
        {{-- EXPORT --}}
        {{-- ===================================================== --}}

        <li class="nav-item dropdown">

            <a
                class="nav-link dropdown-toggle"
                id="exportDropdown"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                <i class="fas fa-download fa-fw"></i>

            </a>


            <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="exportDropdown">

                <li>

                    <h6 class="dropdown-header">
                        Export Data
                    </h6>

                </li>


                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('users.export') }}">

                        <i class="fas fa-users me-2"></i>

                        Users CSV

                    </a>

                </li>


                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('activity.logs.export') }}">

                        <i class="fas fa-history me-2"></i>

                        Activity Logs CSV

                    </a>

                </li>

            </ul>

        </li>


        {{-- ===================================================== --}}
        {{-- USER MENU --}}
        {{-- ===================================================== --}}

        <li class="nav-item dropdown">

            <a
                class="nav-link dropdown-toggle"
                id="navbarDropdown"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                <i class="fas fa-user fa-fw"></i>

            </a>


            <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="navbarDropdown">


                {{-- User Menu Header --}}
                <li>

                    <h6 class="dropdown-header">

                        <i class="fas fa-user-shield me-2"></i>

                        Administrator

                    </h6>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                {{-- Dashboard --}}
                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('dashboard') }}">

                        <i class="fas fa-tachometer-alt me-2"></i>

                        Dashboard

                    </a>

                </li>


                {{-- Users --}}
                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('users.index') }}">

                        <i class="fas fa-users me-2"></i>

                        Users

                    </a>

                </li>


                {{-- Verified Users --}}
                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('users.index', ['status' => 'verified']) }}">

                        <i class="fas fa-user-check me-2"></i>

                        Verified Users

                    </a>

                </li>


                {{-- Unverified Users --}}
                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('users.index', ['status' => 'unverified']) }}">

                        <i class="fas fa-user-clock me-2"></i>

                        Unverified Users

                    </a>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                {{-- Activity --}}
                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('activity.logs') }}">

                        <i class="fas fa-history me-2"></i>

                        Activity Logs

                    </a>

                </li>


                {{-- Export Users --}}
                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('users.export') }}">

                        <i class="fas fa-file-csv me-2"></i>

                        Export Users

                    </a>

                </li>


                {{-- Export Activities --}}
                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('activity.logs.export') }}">

                        <i class="fas fa-file-export me-2"></i>

                        Export Activities

                    </a>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                {{-- System Information --}}
                <li>

                    <span class="dropdown-item-text">

                        <small class="text-muted">

                            <i class="fas fa-code-branch me-1"></i>

                            Laravel {{ app()->version() }}

                        </small>

                    </span>

                </li>

            </ul>

        </li>

    </ul>

</nav>