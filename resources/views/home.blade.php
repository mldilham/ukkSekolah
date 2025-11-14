@extends('layouts.app')

@section('content')

{{-- ============================= --}}
{{--         HERO CAROUSEL         --}}
{{-- ============================= --}}
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
</style>

{{-- ============================= --}}
{{--       KATEGORI PRODUK         --}}
{{-- ============================= --}}
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

{{-- ============================= --}}
{{--        PRODUK TERBARU         --}}
{{-- ============================= --}}
<div class="py-5" style="background: var(--primary-soft)">
    <div class="container">
        <h4 class="section-title">Rekomendasi Untuk Anda</h4>

        <div class="row justify-content-center">
            @foreach($produks as $produk)
                <div class="col-md-3 col-sm-6 mb-4 d-flex align-items-stretch">
                    <div class="card product-card h-100">

                        @if($produk->gambarProduks->isNotEmpty())
                            <img src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                                 class="card-img-top"
                                 style="height: 180px; object-fit: cover;">
                        @else
                            <img src="{{ asset('template/img/undraw_posting_photo.svg') }}"
                                 class="card-img-top"
                                 style="height: 180px; object-fit: cover;">
                        @endif

                        <div class="card-body">
                            <p class="mb-1" style="font-size: 15px; font-weight: 600;">
                                {{ Str::limit($produk->nama, 35) }}
                            </p>
                            <p class="mb-1" style="font-size: 16px; font-weight: 700; color: var(--primary)">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-muted small mb-3">
                                {{ $produk->toko->nama_toko ?? 'Toko' }}
                            </p>

                            <a href="{{ route('public.produks.show', $produk->id_produk) }}"
                               class="btn btn-market btn-sm w-100">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

    {{-- ============================= --}}
    {{--         TOKO Terpercaya          --}}
    {{-- ============================= --}}
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

@endsection
