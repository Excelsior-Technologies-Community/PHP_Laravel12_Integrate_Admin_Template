<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark shadow-sm">

    {{-- Brand --}}
    <a class="navbar-brand ps-3 fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">
        <i class="fas fa-layer-group me-2 text-primary"></i>
        <span>Admin Panel</span>
    </a>

    {{-- Sidebar Toggle --}}
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-white-50" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    {{-- Right Navigation Bar --}}
    <ul class="navbar-nav ms-auto me-3 me-lg-4 d-flex align-items-center">

        {{-- Dark / Light Mode Switcher --}}
        <li class="nav-item me-2">
            <button onclick="toggleThemeMode()" class="btn btn-link nav-link p-2" title="Toggle Dark/Light Mode" type="button">
                <i id="themeToggleIcon" class="fas fa-moon text-light fa-fw"></i>
            </button>
        </li>

        {{-- Settings Quick Link --}}
        <li class="nav-item me-2">
            <a class="nav-link p-2" href="{{ route('settings.index') }}" title="System Settings">
                <i class="fas fa-cog fa-fw"></i>
            </a>
        </li>

        {{-- Activity Logs Link --}}
        <li class="nav-item me-2">
            <a class="nav-link p-2 position-relative" href="{{ route('activity.logs') }}" title="Activity Logs">
                <i class="fas fa-history fa-fw"></i>
            </a>
        </li>

        {{-- User Profile Dropdown --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center p-1" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=0d6efd&color=fff&size=64" alt="Admin" class="rounded-circle me-2" style="width: 28px; height: 28px;">
                <span class="d-none d-md-inline small text-light fw-semibold">Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown">
                <li class="dropdown-header text-muted small">Account Management</li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}">
                        <i class="fas fa-user-circle me-2 text-primary"></i> My Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('settings.index') }}">
                        <i class="fas fa-sliders-h me-2 text-secondary"></i> System Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('dashboard') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Log Out
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</nav>