<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand font-weight-bold text-success" href="{{ url('/') }}">
            <i class="fas fa-store"></i> MarShop
        </a>

        <!-- Toggle untuk mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Isi Navbar -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Menu Navigasi -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="nav-item {{ request()->is('produk*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('public.produks.index') }}">Produk</a>
                </li>
                <li class="nav-item {{ request()->is('toko*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('public.tokos.index') }}">Toko</a>
                </li>
                <li class="nav-item {{ request()->is('transaksi*') ? 'active' : '' }}">
                    <a class="nav-link" href="#">Transaksi</a>
                </li>
            </ul>

            <!-- Pencarian Produk -->
            <form action="{{ route('public.produks.index') }}" method="GET" class="form-inline my-2 my-lg-0 mr-lg-2">
                <div class="input-group">
                    <input class="form-control bg-light border-0 small" type="text" name="search"
                        placeholder="Cari produk..." aria-label="Search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- User Menu -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-gray-800" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle mr-1"
                                src="{{ asset('template/img/undraw_profile.svg') }}" width="30">
                            {{ auth()->user()->nama }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow">
                            @if(auth()->user()->role == 'admin')
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt mr-2 text-gray-400"></i> Dashboard Admin
                                </a>
                            @elseif(auth()->user()->role == 'member')
                                <a class="dropdown-item" href="{{ route('member.dashboard') }}">
                                    <i class="fas fa-tachometer-alt mr-2 text-gray-400"></i> Dashboard Member
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-success btn-sm mr-2" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success btn-sm" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-brand {
    font-size: 1.4rem;
    letter-spacing: 0.5px;
}

.nav-link {
    color: #333 !important;
    font-weight: 500;
}

.nav-link.active {
    color: #28a745 !important;
}

.img-profile {
    border: 2px solid #e0e0e0;
}

.btn-outline-success:hover {
    background-color: #28a745;
    color: white;
}

</style>
