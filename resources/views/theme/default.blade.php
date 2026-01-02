<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    {{-- Responsive viewport --}}
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- Page title --}}
    <title>@yield('title', 'Dashboard - SB Admin')</title>

    {{-- DataTables CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

    {{-- SB Admin CSS --}}
    <link href="{{ asset('theme/css/styles.css') }}" rel="stylesheet" />

    {{-- Font Awesome icons --}}
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body class="sb-nav-fixed">

{{-- Top navigation bar --}}
@include('theme.header')

<div id="layoutSidenav">

    {{-- Sidebar navigation --}}
    @include('theme.sidebar')

    <div id="layoutSidenav_content">

        {{-- Main content --}}
        <main>
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('theme.footer')

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- SB Admin JS --}}
<script src="{{ asset('theme/js/scripts.js') }}"></script>

{{-- Chart JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

{{-- Chart demo files --}}
<script src="{{ asset('theme/assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('theme/assets/demo/chart-bar-demo.js') }}"></script>

{{-- DataTables JS --}}
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
<script src="{{ asset('theme/js/datatables-simple-demo.js') }}"></script>

</body>
</html>
