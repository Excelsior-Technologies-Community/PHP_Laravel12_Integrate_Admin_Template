<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    />

    <title>
        @yield('title', 'Dashboard - Laravel Admin')
    </title>


    {{-- Simple DataTables CSS --}}
    <link
        href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
        rel="stylesheet"
    />


    {{-- SB Admin CSS --}}
    <link
        href="{{ asset('theme/css/styles.css') }}"
        rel="stylesheet"
    />


    {{-- Font Awesome --}}
    <script
        src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
    ></script>

</head>


<body class="sb-nav-fixed">


{{-- Header --}}
@include('theme.header')


<div id="layoutSidenav">


    {{-- Sidebar --}}
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


{{-- Bootstrap --}}
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
></script>


{{-- SB Admin --}}
<script
    src="{{ asset('theme/js/scripts.js') }}"
></script>


{{-- Chart.js --}}
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
></script>


{{-- Simple DataTables --}}
<script
    src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
></script>


<script
    src="{{ asset('theme/js/datatables-simple-demo.js') }}"
></script>


{{-- Page-specific scripts --}}
@yield('scripts')


</body>

</html>