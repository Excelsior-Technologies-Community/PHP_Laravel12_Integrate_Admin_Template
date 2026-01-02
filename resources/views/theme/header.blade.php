{{-- Top navbar --}}
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    {{-- Logo --}}
    <a class="navbar-brand ps-3" href="/dashboard">SB Admin</a>

    {{-- Sidebar toggle --}}
    <button class="btn btn-link btn-sm" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    {{-- User dropdown --}}
    <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
