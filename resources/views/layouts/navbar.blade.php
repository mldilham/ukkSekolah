<nav class="navbar navbar-expand-lg navbar-light bg-white premium-navbar shadow-sm sticky-top">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand font-weight-bold text-primary-custom" href="{{ url('/') }}">
            <i class="fas fa-store"></i> MarShop
        </a>

        <!-- Toggle Nav (Mobile) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- Center Nav Links -->
            <ul class="navbar-nav mx-auto">

                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link premium-link" href="{{ url('/') }}">Beranda</a>
                </li>

                <li class="nav-item {{ request()->is('produk*') ? 'active' : '' }}">
                    <a class="nav-link premium-link" href="{{ route('public.produks.index') }}">Produk</a>
                </li>

                <li class="nav-item {{ request()->is('toko*') ? 'active' : '' }}">
                    <a class="nav-link premium-link" href="{{ route('public.tokos.index') }}">Toko</a>
                </li>

            </ul>

            <!-- Search Bar -->
            <form action="{{ route('public.produks.index') }}" method="GET" class="search-box ml-lg-3">
                <div class="input-group">
                    <input class="form-control search-input" type="text" name="search"
                        placeholder="Cari produk..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn search-btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right User / Auth -->
            <ul class="navbar-nav ml-3">

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle premium-link" href="#" id="userDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle mr-1"
                                src="{{ asset('template/img/undraw_profile.svg') }}" width="32">
                            {{ auth()->user()->nama }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 rounded-lg">

                            @if(auth()->user()->role == 'admin')
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt mr-2 text-muted"></i> Dashboard Admin
                                </a>
                            @elseif(auth()->user()->role == 'member')
                                <a class="dropdown-item" href="{{ route('member.dashboard') }}">
                                    <i class="fas fa-tachometer-alt mr-2 text-muted"></i> Dashboard Member
                                </a>
                            @endif

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2 text-muted"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>
                    </li>

                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-primary-custom btn-sm mr-2" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-primary-custom btn-sm" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>
<style>
    /* THEME COLORS */
    :root {
        --primary: #6C63FF;
        --primary-dark: #5751d8;
        --soft-bg: #F4F3FF;
        --text-dark: #2B2B2B;
    }

    /* Brand Name */
    .text-primary-custom {
        color: var(--primary) !important;
        font-size: 1.45rem;
        font-weight: 700;
        letter-spacing: 0.4px;
    }

    /* Navbar background */
    .premium-navbar {
        padding: 12px 0;
        backdrop-filter: blur(6px);
    }

    /* Nav Link */
    .premium-link {
        font-weight: 500;
        padding: 8px 16px !important;
        color: #444 !important;
        position: relative;
        transition: 0.2s ease;
    }

    /* Underline Smooth */
    .premium-link::after {
        content: "";
        position: absolute;
        width: 0%;
        height: 2px;
        left: 0;
        bottom: 2px;
        background: var(--primary);
        transition: 0.25s;
    }
    .premium-link:hover::after,
    .nav-item.active .premium-link::after {
        width: 100%;
    }
    .nav-item.active .premium-link {
        color: var(--primary) !important;
        font-weight: 600;
    }

    /* Search Box */
    .search-box .search-input {
        border-radius: 20px 0 0 20px;
        border: 1px solid #ddd;
        background: #fafafa;
        padding-left: 15px;
    }
    .search-btn {
        background: var(--primary);
        border-radius: 0 20px 20px 0;
        color: white;
        padding: 8px 14px;
    }
    .search-btn:hover {
        background: var(--primary-dark);
    }

    /* Profile */
    .img-profile {
        border: 2px solid #eaeaea;
    }

    /* Buttons */
    .btn-primary-custom {
        background-color: var(--primary);
        color: white;
        border-radius: 20px;
        padding: 6px 14px;
        border: none;
    }
    .btn-primary-custom:hover {
        background-color: var(--primary-dark);
    }

    .btn-outline-primary-custom {
        border: 1.5px solid var(--primary);
        color: var(--primary);
        border-radius: 20px;
        padding: 6px 14px;
    }
    .btn-outline-primary-custom:hover {
        background: var(--primary);
        color: white;
    }
</style>
