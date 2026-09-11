{{-- Sidebar container --}}
<div id="layoutSidenav_nav">

    <nav class="sb-sidenav accordion sb-sidenav-dark">

        <div class="sb-sidenav-menu">

            <div class="nav">

                {{-- Dashboard --}}
                <a
                    class="nav-link"
                    href="{{ route('dashboard') }}"
                >

                    <div class="sb-nav-link-icon">

                        <i class="fas fa-tachometer-alt"></i>

                    </div>

                    Dashboard

                </a>


                {{-- Users --}}
                <a
                    class="nav-link"
                    href="{{ route('users.index') }}"
                >

                    <div class="sb-nav-link-icon">

                        <i class="fas fa-users"></i>

                    </div>

                    Users

                </a>


                {{-- Activity Logs --}}
                <a
                    class="nav-link"
                    href="{{ route('activity.logs') }}"
                >

                    <div class="sb-nav-link-icon">

                        <i class="fas fa-history"></i>

                    </div>

                    Activity Logs

                </a>


                {{-- Divider --}}
                <div class="sb-sidenav-menu-heading">
                    Administration
                </div>


                {{-- Analytics --}}
                <a
                    class="nav-link"
                    href="{{ route('dashboard') }}"
                >

                    <div class="sb-nav-link-icon">

                        <i class="fas fa-chart-line"></i>

                    </div>

                    Analytics

                </a>

            </div>

        </div>


        {{-- Sidebar footer --}}
        <div class="sb-sidenav-footer">

            <div class="small">
                Admin Panel
            </div>

            Laravel 12 + SB Admin

        </div>

    </nav>

</div>