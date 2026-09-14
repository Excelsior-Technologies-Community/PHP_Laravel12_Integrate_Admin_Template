<div id="layoutSidenav_nav">

    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        {{-- ===================================================== --}}
        {{-- SIDEBAR MENU --}}
        {{-- ===================================================== --}}

        <div class="sb-sidenav-menu">

            <div class="nav">

                {{-- ================================================= --}}
                {{-- CORE --}}
                {{-- ================================================= --}}

                <div class="sb-sidenav-menu-heading">
                    Core
                </div>


                {{-- Dashboard --}}
                <a
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>

                    Dashboard

                </a>


                {{-- ================================================= --}}
                {{-- USER MANAGEMENT --}}
                {{-- ================================================= --}}

                <div class="sb-sidenav-menu-heading">
                    User Management
                </div>


                {{-- All Users --}}
                <a
                    class="nav-link {{ request()->routeIs('users.index') && !request()->has('status') ? 'active' : '' }}"
                    href="{{ route('users.index') }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-users"></i>
                    </div>

                    All Users

                </a>


                {{-- Verified Users --}}
                <a
                    class="nav-link {{ request()->routeIs('users.index') && request('status') === 'verified' ? 'active' : '' }}"
                    href="{{ route('users.index', ['status' => 'verified']) }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-user-check"></i>
                    </div>

                    Verified Users

                </a>


                {{-- Unverified Users --}}
                <a
                    class="nav-link {{ request()->routeIs('users.index') && request('status') === 'unverified' ? 'active' : '' }}"
                    href="{{ route('users.index', ['status' => 'unverified']) }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-user-clock"></i>
                    </div>

                    Unverified Users

                </a>


                {{-- Export Users --}}
                <a
                    class="nav-link"
                    href="{{ route('users.export') }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-file-csv"></i>
                    </div>

                    Export Users

                </a>


                {{-- ================================================= --}}
                {{-- ADMINISTRATION --}}
                {{-- ================================================= --}}

                <div class="sb-sidenav-menu-heading">
                    Administration
                </div>


                {{-- Activity Logs --}}
                <a
                    class="nav-link {{ request()->routeIs('activity.logs') ? 'active' : '' }}"
                    href="{{ route('activity.logs') }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-history"></i>
                    </div>

                    Activity Logs

                </a>


                {{-- Export Activity Logs --}}
                <a
                    class="nav-link"
                    href="{{ route('activity.logs.export') }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-file-export"></i>
                    </div>

                    Export Activity Logs

                </a>


                {{-- ================================================= --}}
                {{-- ANALYTICS --}}
                {{-- ================================================= --}}

                <div class="sb-sidenav-menu-heading">
                    Analytics
                </div>


                {{-- Dashboard Analytics --}}
                <a
                    class="nav-link"
                    href="{{ route('dashboard') }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    User Analytics

                </a>


                {{-- Registration Statistics --}}
                <a
                    class="nav-link"
                    href="{{ route('dashboard') }}#registration-statistics">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>

                    Registration Stats

                </a>


                {{-- ================================================= --}}
                {{-- QUICK ACTIONS --}}
                {{-- ================================================= --}}

                <div class="sb-sidenav-menu-heading">
                    Quick Actions
                </div>


                <a
                    class="nav-link"
                    href="{{ route('users.index') }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>

                    Manage Users

                </a>


                <a
                    class="nav-link"
                    href="{{ route('activity.logs') }}">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-search"></i>
                    </div>

                    Search Activities

                </a>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- SIDEBAR FOOTER --}}
        {{-- ===================================================== --}}

        <div class="sb-sidenav-footer">

            <div class="small">
                Logged in as:
            </div>

            <strong>
                Administrator
            </strong>

            <div class="small text-muted mt-1">
                Laravel {{ app()->version() }}
            </div>

        </div>

    </nav>

</div>