<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- CORE SECTION --}}
                <div class="sb-sidenav-menu-heading text-uppercase text-muted small fw-bold">Core</div>

                {{-- Dashboard --}}
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-primary"></i></div>
                    Dashboard
                </a>

                {{-- USER MANAGEMENT SECTION --}}
                <div class="sb-sidenav-menu-heading text-uppercase text-muted small fw-bold">Management</div>

                {{-- Users Parent Menu --}}
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}" aria-controls="collapseUsers">
                    <div class="sb-nav-link-icon"><i class="fas fa-users text-info"></i></div>
                    Users Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('users.*') ? 'show' : '' }}" id="collapseUsers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('users.index') ? 'active text-primary' : '' }}" href="{{ route('users.index') }}">
                            <i class="fas fa-list me-2 small"></i> All Users
                        </a>
                        <a class="nav-link {{ request()->routeIs('users.trash') ? 'active text-danger' : '' }}" href="{{ route('users.trash') }}">
                            <i class="fas fa-trash-alt me-2 small text-danger"></i> Recycle Bin (Trash)
                        </a>
                    </nav>
                </div>

                {{-- Activity Logs --}}
                <a class="nav-link {{ request()->routeIs('activity.logs*') ? 'active' : '' }}" href="{{ route('activity.logs') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-history text-warning"></i></div>
                    Activity Logs
                </a>

                {{-- SYSTEM CONFIG SECTION --}}
                <div class="sb-sidenav-menu-heading text-uppercase text-muted small fw-bold">System</div>

                {{-- Settings Hub --}}
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-sliders-h text-success"></i></div>
                    System Settings
                </a>

                {{-- Profile --}}
                <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle text-secondary"></i></div>
                    My Profile
                </a>

            </div>
        </div>

        {{-- Footer --}}
        <div class="sb-sidenav-footer bg-dark border-top border-secondary">
            <div class="small text-muted">Logged in as:</div>
            <div class="fw-bold text-light">System Administrator</div>
        </div>
    </nav>
</div>