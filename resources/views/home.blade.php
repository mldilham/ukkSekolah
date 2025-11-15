@extends('layouts.app')

@section('content')

{{-- ============================= --}}
{{--         HERO CAROUSEL         --}}
{{-- ============================= --}}
@if($produks->count() > 0)
<div class="d-flex justify-content-center mt-4">
    <div class="carousel-container">
        <div id="heroCarousel" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators">
                @foreach($produks->take(3) as $index => $produk)
                    <li data-target="#heroCarousel"
                        data-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}">
                    </li>
                @endforeach
            </ol>

            <div class="carousel-inner rounded-xl shadow-sm">
                @foreach($produks->take(3) as $index => $produk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        @if($produk->gambarProduks->isNotEmpty())
                            <img class="d-block w-100 hero-img"
                                src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                                alt="{{ $produk->nama }}">
                        @else
                            <img class="d-block w-100 hero-img"
                                src="{{ asset('template/img/undraw_posting_photo.svg') }}"
                                alt="Default">
                        @endif
                    </div>
                @endforeach
            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
                <span class="carousel-arrow">&#10094;</span>
            </a>
            <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
                <span class="carousel-arrow">&#10095;</span>
            </a>

        </div>
    </div>
</div>
@else
<div class="d-flex justify-content-center mt-4">
    <div class="empty-state-card">
        <div class="empty-state-content">
            <i class="fas fa-shopping-bag fa-4x text-muted mb-4"></i>
            <h3 class="empty-state-title">Belum Ada Produk</h3>
            <p class="empty-state-text">Produk-produk menarik akan segera hadir di marketplace ini.</p>
            <a href="{{ route('public.produks.index') }}" class="btn btn-market">
                <i class="fas fa-search"></i> Jelajahi Produk
            </a>
        </div>
    </div>
</div>
@endif

<style>
    /* =======================================
        ELEGANT PREMIUM THEME
    ======================================== */
    :root {
        --primary: #6C63FF;          /* Elegant Soft Purple */
        --primary-dark: #5852d6;
        --primary-soft: #F4F3FF;
        --text-dark: #2B2B2B;
        --text-light: #6D6D6D;
    }

    /* Global font & layout */
    body {
        font-family: 'Poppins', sans-serif;
    }

    .section-title {
        color: var(--text-dark);
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
    }

    /* Carousel */
    .carousel-container {
        max-width: 1050px;
        width: 100%;
        border-radius: 18px;
        overflow: hidden;
    }
    .hero-img {
        height: 380px;
        object-fit: cover;
    }
    .carousel-indicators li {
        background-color: var(--primary);
    }
    .carousel-arrow {
        font-size: 2rem;
        color: var(--primary);
        font-weight: bold;
    }

    /* Card Elegant */
    .product-card {
        transition: 0.25s ease;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        border: none;
        text-align: center;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 18px rgba(0,0,0,0.14);
    }

    /* Buttons */
    .btn-market {
        background-color: var(--primary);
        color: #fff;
        font-size: 13px;
        padding: 8px 14px;
        border-radius: 8px;
        transition: 0.2s;
    }
    .btn-market:hover {
        background-color: var(--primary-dark);
        color: white;
    }

    /* Category icon */
    .category-icon {
        background: var(--primary-soft);
        padding: 18px;
        display: inline-block;
        border-radius: 16px;
        color: var(--primary);
        margin-bottom: 14px;
    }

    /* Empty State */
    .empty-state-card {
        background: white;
        border-radius: 20px;
        padding: 60px 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
    }

    .empty-state-content {
        padding: 20px;
    }

    .empty-state-title {
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 15px;
    }

    .empty-state-text {
        color: var(--text-light);
        font-size: 16px;
        margin-bottom: 25px;
    }
</style>

{{-- ============================= --}}
{{--       KATEGORI PRODUK         --}}
{{-- ============================= --}}
@if($kategoris->count() > 0)
<div class="container my-5">
    <h4 class="section-title">Kategori Pilihan</h4>

    <div class="row justify-content-center">
        @foreach($kategoris as $kategori)
            <div class="col-md-3 col-sm-6 mb-3 d-flex align-items-stretch">
                <div class="card product-card p-3 w-100">
                    <div class="category-icon">
                        <i class="fas fa-tag fa-2x"></i>
                    </div>
                    <h6 class="fw-bold">{{ $kategori->nama_kategori }}</h6>
                    <a href="{{ route('public.produks.index', ['kategori' => $kategori->id]) }}"
                       class="btn btn-market mt-2">
                        Lihat Produk
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
<div class="container my-5">
    <div class="empty-state-card">
        <div class="empty-state-content">
            <i class="fas fa-tags fa-4x text-muted mb-4"></i>
            <h3 class="empty-state-title">Belum Ada Kategori</h3>
            <p class="empty-state-text">Kategori produk akan segera ditambahkan untuk memudahkan pencarian.</p>
            <a href="{{ route('public.produks.index') }}" class="btn btn-market">
                <i class="fas fa-search"></i> Lihat Semua Produk
            </a>
        </div>
    </div>
</div>
@endif

{{-- ============================= --}}
{{--        PRODUK TERBARU         --}}
{{-- ============================= --}}
@if($produks->count() > 0)
<div class="py-5" style="background: var(--primary-soft)">
    <div class="container">
        <h4 class="section-title">Rekomendasi Untuk Anda</h4>

        <div class="row justify-content-center">
            @foreach($produks as $produk)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card product-card" style="height: 380px;">

                        @if($produk->gambarProduks->isNotEmpty())
                            <img src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover; width: 100%;">
                        @else
                            <img src="{{ asset('template/img/undraw_posting_photo.svg') }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover; width: 100%;">
                        @endif

                        <div class="card-body d-flex flex-column" style="height: 180px;">
                            <div class="flex-grow-1">
                                <p class="mb-1 product-title" style="font-size: 15px; font-weight: 600; min-height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $produk->nama_produk }}
                                </p>
                                <p class="mb-1 product-price" style="font-size: 16px; font-weight: 700; color: var(--primary)">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                                <p class="text-muted small product-store" style="min-height: 20px;">
                                    {{ Str::limit($produk->toko->nama_toko ?? 'Toko', 25) }}
                                </p>
                            </div>

                            <a href="{{ route('public.produks.show', $produk->id_produk) }}"
                               class="btn btn-market btn-sm w-100 mt-auto">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@else
<div class="py-5" style="background: var(--primary-soft)">
    <div class="container">
        <div class="empty-state-card">
            <div class="empty-state-content">
                <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                <h3 class="empty-state-title">Belum Ada Produk</h3>
                <p class="empty-state-text">Produk-produk menarik akan segera hadir di marketplace ini.</p>
                <a href="{{ route('public.produks.index') }}" class="btn btn-market">
                    <i class="fas fa-search"></i> Jelajahi Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endif

    {{-- ============================= --}}
    {{--         TOKO Terpercaya          --}}
    {{-- ============================= --}}
    @if($tokos->count() > 0)
    <div class="container my-5">
        <h4 class="section-title">Toko Terpercaya</h4>

        <div class="row justify-content-center">
            @foreach($tokos as $toko)
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="card product-card p-4 w-100">
                        @if($toko->gambar)
                            <img src="{{ asset('storage/tokos/' . $toko->gambar) }}" alt="{{ $toko->nama_toko }}" class="card-img-top mb-3 rounded-circle mx-auto d-block" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <img src="{{ asset('template/img/undraw_profile.svg') }}" alt="Default Store" class="card-img-top mb-3 rounded-circle mx-auto d-block" style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                        <h5 class="fw-bold">{{ $toko->nama_toko }}</h5>
                        <a href="{{ route('public.tokos.show', $toko->id_toko) }}"
                        class="btn btn-market mt-2 px-3">
                            Kunjungi Toko
                        </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
<div class="container my-5">
    <div class="empty-state-card">
        <div class="empty-state-content">
            <i class="fas fa-store fa-4x text-muted mb-4"></i>
            <h3 class="empty-state-title">Belum Ada Toko</h3>
            <p class="empty-state-text">Toko-toko terpercaya akan segera bergabung dengan marketplace ini.</p>
            <a href="{{ route('public.tokos.index') }}" class="btn btn-market">
                <i class="fas fa-search"></i> Jelajahi Toko
            </a>
        </div>
    </div>
</div>
@endif

@endsection
