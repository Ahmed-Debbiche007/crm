<header class="navbar navbar-expand-md d-print-none ">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">

        </h1>
        <div class="navbar-nav flex-row order-md-last">

            <div class="d-flex">

                <button id="theme-toggle" class="nav-link px-0" title="Enable light mode" data-bs-toggle="tooltip"
                    data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path
                            d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                    </svg>
                </button>
                @php
                    $echeances = App\Models\Echeances::with('echance','echance.appart','echance.appart.client')->where(function ($query) {
                        $query->where('date', '<=', now()->addDays(2))->orWhere('date', '<=', now());
                    })
                        ->where('payed', '=', 0)
                        ->get();
                @endphp
                <x-notifications :$echeances />
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url({{ asset('static/1.jpg') }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>Admin</div>
                        <div class="mt-1 small text-muted">admin</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('logout.perform') }}" class="dropdown-item">Déconnecter</a>
                </div>
            </div>
        </div>
    </div>
</header>
