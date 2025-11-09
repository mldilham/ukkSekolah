<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Manajemen Data
            </div>
            <!-- Nav Item - Users -->
            <li class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.users') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Pengguna</span></a>
            </li>
            <!-- Nav Item - Tokos -->
            <li class="nav-item {{ request()->routeIs('admin.tokos*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.tokos.index') }}">
                    <i class="fas fa-fw fa-store"></i>
                    <span>Toko</span></a>
            </li>
            <!-- Nav Item - Kategori -->
            <li class="nav-item {{ request()->routeIs('admin.kategoris*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.kategoris.index') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Kategori</span></a>
            </li>
            <!-- Nav Item - Produks -->
            <li class="nav-item {{ request()->routeIs('admin.produks*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.produks.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Produk</span></a>
            </li>
            <!-- Nav Item - Gambar Produks -->
            <li class="nav-item {{ request()->routeIs('admin.gambar_produks*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.gambar_produks.index') }}">
                    <i class="fas fa-fw fa-images"></i>
                    <span>Gambar Produk</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
