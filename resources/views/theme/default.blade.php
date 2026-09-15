<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard - Laravel Admin')</title>

    {{-- Simple DataTables CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

    {{-- SB Admin CSS --}}
    <link href="{{ asset('theme/css/styles.css') }}" rel="stylesheet" />

    {{-- Font Awesome --}}
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    {{-- Custom Dark Mode & Polish Styling --}}
    <style>
        body.dark-mode {
            background-color: #121824 !important;
            color: #e2e8f0 !important;
        }
        body.dark-mode #layoutSidenav_content {
            background-color: #121824 !important;
        }
        body.dark-mode .card {
            background-color: #1a2234 !important;
            border-color: #2a3449 !important;
            color: #e2e8f0 !important;
        }
        body.dark-mode .card-header {
            background-color: #161e2e !important;
            border-color: #2a3449 !important;
            color: #f1f5f9 !important;
        }
        body.dark-mode .card-footer {
            background-color: #161e2e !important;
            border-color: #2a3449 !important;
        }
        body.dark-mode .table {
            color: #e2e8f0 !important;
            border-color: #2a3449 !important;
        }
        body.dark-mode .table-bordered {
            border-color: #2a3449 !important;
        }
        body.dark-mode .table > :not(caption) > * > * {
            background-color: transparent !important;
            border-bottom-color: #2a3449 !important;
            color: #e2e8f0 !important;
        }
        body.dark-mode .table-light {
            background-color: #1e293b !important;
            color: #f8fafc !important;
        }
        body.dark-mode .modal-content {
            background-color: #1a2234 !important;
            border-color: #2a3449 !important;
            color: #e2e8f0 !important;
        }
        body.dark-mode .modal-header, body.dark-mode .modal-footer {
            border-color: #2a3449 !important;
        }
        body.dark-mode .form-control, body.dark-mode .form-select {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        body.dark-mode .form-control:focus, body.dark-mode .form-select:focus {
            border-color: #0d6efd !important;
        }
        body.dark-mode footer.bg-light {
            background-color: #0f172a !important;
            border-top: 1px solid #1e293b;
        }
        body.dark-mode .list-group-item {
            background-color: #1a2234 !important;
            border-color: #2a3449 !important;
            color: #e2e8f0 !important;
        }
        .user-avatar-sm {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border-radius: 50%;
        }
        .user-avatar-lg {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body class="sb-nav-fixed">

{{-- Header --}}
@include('theme.header')

<div id="layoutSidenav">

    {{-- Sidebar --}}
    @include('theme.sidebar')

    <div id="layoutSidenav_content">

        {{-- Flash Messages --}}
        <div class="container-fluid px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="fw-bold"><i class="fas fa-exclamation-circle me-1"></i> Please resolve the following errors:</div>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        {{-- Main content --}}
        <main>
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('theme.footer')

    </div>

</div>

{{-- Bootstrap Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- SB Admin --}}
<script src="{{ asset('theme/js/scripts.js') }}"></script>

{{-- Chart.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

{{-- Simple DataTables --}}
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>

{{-- Theme Switcher & Global JS Helpers --}}
<script>
    // Initialize Theme Mode
    const currentTheme = localStorage.getItem('sb_admin_theme') || 'light';
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
    }

    function toggleThemeMode() {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('sb_admin_theme', isDark ? 'dark' : 'light');
        updateThemeIcons();
    }

    function updateThemeIcons() {
        const isDark = document.body.classList.contains('dark-mode');
        const icon = document.getElementById('themeToggleIcon');
        if (icon) {
            icon.className = isDark ? 'fas fa-sun text-warning fa-fw' : 'fas fa-moon text-light fa-fw';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateThemeIcons();
    });
</script>

{{-- Page-specific scripts --}}
@yield('scripts')

</body>
</html>