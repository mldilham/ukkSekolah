@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header Section with Enhanced Design -->
    <header class="text-center mb-5 position-relative">
        <div class="header-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        <div class="position-relative z-1">
            <h1 class="display-4 fw-bold text-dark mb-3 animate__animated animate__fadeInDown">MarSchool</h1>
            <p class="lead text-muted animate__animated animate__fadeInUp">Marketplace produk berkualitas dari berbagai toko terpercaya</p>
        </div>
    </header>

    <!-- Quick Actions with Enhanced Design -->
    <section class="row mb-5">
        <div class="col-md-6 mb-3">
            <a href="{{ route('public.produks.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow h-100 text-center p-4 quick-action-card position-relative overflow-hidden">
                    <div class="card-bg"></div>
                    <div class="position-relative z-1">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-shopping-bag fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Semua Produk</h5>
                        <p class="text-muted small mb-0">Jelajahi 100+ produk</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('public.tokos.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow h-100 text-center p-4 quick-action-card position-relative overflow-hidden">
                    <div class="card-bg bg-success"></div>
                    <div class="position-relative z-1">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-store fa-2x text-success"></i>
                        </div>
                        <h5 class="fw-bold">Daftar Toko</h5>
                        <p class="text-muted small mb-0">Temukan toko favorit Anda</p>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <!-- Produk Terbaru with Enhanced Design -->
    @if($produks->count() > 0)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="position-relative">
                <h2 class="h4 fw-bold text-dark">Produk Terbaru</h2>
                <div class="title-underline"></div>
            </div>
            <a href="{{ route('public.produks.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Lihat semua <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($produks as $produk)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm product-card h-100">
                    <div class="position-relative overflow-hidden product-image-container">
                        @if($produk->gambarProduks->count() > 0)
                            <img src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                                 class="card-img-top product-image" alt="{{ $produk->nama_produk }}">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                <i class="fas fa-box fa-3x text-muted"></i>
                            </div>
                        @endif
                        @if($produk->diskon > 0)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                -{{ $produk->diskon }}%
                            </span>
                        @endif
                        <div class="product-overlay">
                            <div class="product-actions">
                                <button class="btn btn-sm btn-light rounded-circle me-1" title="Tambah ke Favorit">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="btn btn-sm btn-light rounded-circle" title="Lihat Cepat">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-truncate mb-2">{{ $produk->nama_produk }}</h6>
                        <div class="d-flex align-items-center mb-2">
                            <p class="text-success fw-bold mb-0">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            @if($produk->diskon > 0)
                                <small class="text-muted text-decoration-line-through ms-2">
                                    Rp {{ number_format($produk->harga * (1 + $produk->diskon/100), 0, ',', '.') }}
                                </small>
                            @endif
                        </div>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-store me-1"></i>{{ $produk->toko->nama_toko }}
                        </p>
                        <a href="{{ route('produks.show', $produk->id_produk) }}"
                           class="btn btn-sm btn-primary w-100 rounded-pill">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Toko Terbaru with Enhanced Design -->
    @if($tokos->count() > 0)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="position-relative">
                <h2 class="h4 fw-bold text-dark">Toko Terbaru</h2>
                <div class="title-underline"></div>
            </div>
            <a href="{{ route('public.tokos.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                Lihat semua <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($tokos as $toko)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm store-card h-100">
                    <div class="position-relative overflow-hidden">
                        @if($toko->gambar)
                            <img src="{{ asset('storage/tokos/' . $toko->gambar) }}"
                                 class="card-img-top store-image" alt="{{ $toko->nama_toko }}">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                                <i class="fas fa-store fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="store-badge">
                            <i class="fas fa-star text-warning"></i> Toko Baru
                        </div>
                    </div>
                    <div class="card-body p-3 text-center">
                        <h6 class="fw-bold mb-1">{{ $toko->nama_toko }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($toko->deskripsi, 40) }}</p>
                        <a href="{{ route('tokos.show', $toko->id_toko) }}"
                           class="btn btn-sm btn-success w-100 rounded-pill">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- CTA Section with Enhanced Design -->
    <section class="cta-section bg-gradient-primary text-white rounded p-5 text-center mb-5 position-relative overflow-hidden">
        <div class="cta-shapes">
            <div class="cta-shape cta-shape-1"></div>
            <div class="cta-shape cta-shape-2"></div>
            <div class="cta-shape cta-shape-3"></div>
        </div>
        <div class="position-relative z-1">
            <h3 class="h4 fw-bold mb-3">Ingin Bergabung?</h3>
            <p class="mb-4">Buka toko Anda dan mulai jual produk di MarSchool</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-light rounded-pill px-4">
                    Daftar Sekarang
                </a>
                <a href="#" class="btn btn-outline-light rounded-pill px-4">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
/* Enhanced Minimal Design Styles */
body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background-color: #f8f9fa;
    color: #212529;
}

/* Header Styles */
.header-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    overflow: hidden;
}

.shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
}

.shape-1 {
    width: 80px;
    height: 80px;
    background-color: #0d6efd;
    top: 10%;
    left: 10%;
    animation: float 6s ease-in-out infinite;
}

.shape-2 {
    width: 60px;
    height: 60px;
    background-color: #198754;
    top: 60%;
    right: 15%;
    animation: float 8s ease-in-out infinite;
}

.shape-3 {
    width: 40px;
    height: 40px;
    background-color: #ffc107;
    bottom: 20%;
    left: 30%;
    animation: float 7s ease-in-out infinite;
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
    100% { transform: translateY(0px); }
}

/* Card Styles */
.card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.product-card, .store-card {
    border-radius: 12px;
    height: 100%;
}

.product-image, .store-image {
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.store-image {
    height: 150px;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.store-card:hover .store-image {
    transform: scale(1.05);
}

/* Product Overlay */
.product-image-container {
    position: relative;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-actions {
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.product-card:hover .product-actions {
    transform: translateY(0);
}

/* Quick Action Cards */
.quick-action-card {
    border-radius: 16px;
    transition: all 0.3s ease;
    overflow: hidden;
}

.card-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(13, 110, 253, 0.1) 100%);
    z-index: 0;
}

.card-bg.bg-success {
    background: linear-gradient(135deg, rgba(25, 135, 84, 0.05) 0%, rgba(25, 135, 84, 0.1) 100%);
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.quick-action-card:hover .icon-wrapper {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* Store Badge */
.store-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(255,255,255,0.9);
    color: #333;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: bold;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Button Styles */
.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.btn-success {
    background-color: #198754;
    border-color: #198754;
}

.btn-success:hover {
    background-color: #157347;
    border-color: #146c43;
}

.btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-outline-success:hover {
    background-color: #198754;
    border-color: #198754;
}

/* Title Underline */
.title-underline {
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #0d6efd, #198754);
    border-radius: 3px;
}

/* CTA Section */
.cta-section {
    position: relative;
    overflow: hidden;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #198754 100%);
}

.cta-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}

.cta-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
    background-color: white;
}

.cta-shape-1 {
    width: 100px;
    height: 100px;
    top: 10%;
    left: 5%;
    animation: float 7s ease-in-out infinite;
}

.cta-shape-2 {
    width: 80px;
    height: 80px;
    top: 60%;
    right: 10%;
    animation: float 9s ease-in-out infinite;
}

.cta-shape-3 {
    width: 60px;
    height: 60px;
    bottom: 15%;
    left: 20%;
    animation: float 8s ease-in-out infinite;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    font-weight: 600;
}

/* Badge Styles */
.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
    border-radius: 20px;
}

/* Utility Classes */
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .product-image, .store-image {
        height: 150px;
    }

    .icon-wrapper {
        width: 60px;
        height: 60px;
    }
}

/* Clean minimal transitions */
a {
    transition: color 0.2s ease;
}

a:hover {
    color: #0d6efd;
}

/* Rounded Pills */
.rounded-pill {
    border-radius: 50px;
}
</style>
@endpush

@push('scripts')
<script>
// Simple image lazy loading
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.loading = 'lazy';
    });
});

// Add smooth scroll behavior
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add interactive product card effects
document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.querySelector('.product-overlay').style.opacity = '1';
        this.querySelector('.product-actions').style.transform = 'translateY(0)';
    });

    card.addEventListener('mouseleave', function() {
        this.querySelector('.product-overlay').style.opacity = '0';
        this.querySelector('.product-actions').style.transform = 'translateY(20px)';
    });
});
</script>
@endpush
