{{-- Top navbar --}}
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    {{-- Logo --}}
    <a
        class="navbar-brand ps-3"
        href="{{ route('dashboard') }}"
    >
        Laravel Admin
    </a>


    {{-- Sidebar toggle --}}
    <button
        class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
        id="sidebarToggle"
    >

        <i class="fas fa-bars"></i>

    </button>


    {{-- Right navigation --}}
    <ul class="navbar-nav ms-auto me-3">

        {{-- Activity --}}
        <li class="nav-item">

            <a
                class="nav-link"
                href="{{ route('activity.logs') }}"
                title="Activity Logs"
            >

                <i class="fas fa-history"></i>

            </a>

        </li>


        {{-- User Dropdown --}}
        <li class="nav-item dropdown">

            <a
                class="nav-link dropdown-toggle"
                id="navbarDropdown"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                <i class="fas fa-user fa-fw"></i>

            </a>

            <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="navbarDropdown"
            >

                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('users.index') }}"
                    >

                        <i class="fas fa-users me-2"></i>

                        Users

                    </a>

                </li>

                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('activity.logs') }}"
                    >

                        <i class="fas fa-history me-2"></i>

                        Activity Logs

                    </a>

                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('dashboard') }}"
                    >

                        <i class="fas fa-tachometer-alt me-2"></i>

                        Dashboard

                    </a>

                </li>

            </ul>

        </li>

    </ul>

</nav>