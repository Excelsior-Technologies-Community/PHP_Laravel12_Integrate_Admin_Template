<footer class="py-4 bg-light mt-auto">

    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center small">

            <div class="text-muted">

                © {{ date('Y') }} Laravel Admin Panel

            </div>

            <div>

                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>

                <span class="mx-2">
                    ·
                </span>

                <a href="{{ route('activity.logs') }}">
                    Activity Logs
                </a>

            </div>

        </div>

    </div>

</footer>