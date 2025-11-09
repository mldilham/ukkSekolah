@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Member</h1>
        <a href="{{ route('logout') }}" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm text-white-50"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Toko Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Toko Saya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ auth()->user()->tokos->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Produk Saya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ auth()->user()->tokos->sum(function($toko) { return $toko->produks->count(); }) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Penjualan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Stok</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ auth()->user()->tokos->sum(function($toko) { return $toko->produks->sum('stok'); }) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cubes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Kategori Digunakan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ auth()->user()->tokos->flatMap->produks->pluck('id_kategori')->unique()->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Selamat Datang, {{ auth()->user()->nama }}!</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ asset('template/img/undraw_profile.svg') }}" alt="">
                    </div>
                    <p>Anda login sebagai <strong>Member</strong>. Di sini Anda dapat mengelola toko dan produk Anda.</p>
                    <p class="mb-0">Fitur yang tersedia:</p>
                    <ul>
                        <li>Mengelola Toko</li>
                        <li>Mengelola Produk</li>
                        <li>Melihat Statistik</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Menu Cepat</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-store mr-2"></i> Kelola Toko
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-box mr-2"></i> Kelola Produk
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-chart-bar mr-2"></i> Lihat Statistik
                        </a>
                        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
