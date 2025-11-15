@extends('layouts.app')
@section('content')
<div class="container py-4">

    <!-- Breadcumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb premium-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('public.produks.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>

    <div class="row">

        <!-- LEFT PRODUCT GALLERY -->
        <div class="col-lg-5 mb-4">

            <div class="gallery-card shadow-sm">

                <!-- Main image -->
                <div class="main-img-wrap">
                    @if($produk->gambarProduks->isNotEmpty())
                        <img id="mainImage"
                             src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                             class="main-img">
                    @else
                        <img id="mainImage"
                             src="{{ asset('template/img/undraw_posting_photo.svg') }}"
                             class="main-img">
                    @endif
                </div>

                <!-- Thumbnails -->
                @if($produk->gambarProduks->count() > 1)
                    <div class="thumbnail-list mt-3">
                        @foreach($produk->gambarProduks as $index => $gambar)
                            <div class="thumb-item">
                                <img src="{{ asset('storage/produks/' . $gambar->nama_gambar) }}"
                                     onclick="changeMainImage('{{ asset('storage/produks/' . $gambar->nama_gambar) }}', this)"
                                     class="thumb-img {{ $index == 0 ? 'active' : '' }}">
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>

        <!-- RIGHT PRODUCT CONTENT -->
        <div class="col-lg-7">

            <div class="product-header mb-3">
                <h1 class="product-title">{{ $produk->nama_produk }}</h1>

                <div class="price-box">
                    <h2 class="price-main">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- Stock Info -->
            <div class="stock-box mb-4">
                <span class="stock-label">Stok :</span>
                <span class="stock-value">
                    {{ $produk->stok }} {{ $produk->stok > 0 ? 'Tersedia' : 'Habis' }}
                </span>
            </div>

            <!-- STORE CARD (Shopee Style) -->
            <div class="store-card shadow-sm mb-4">
                <div class="store-left">
                    @if($produk->toko->gambar)
                        <img src="{{ asset('storage/tokos/'. $produk->toko->gambar) }}" class="store-avatar">
                    @else
                        <img src="{{ asset('template/img/undraw_profile.svg') }}" class="store-avatar">
                    @endif

                    <div>
                        <h5 class="store-name">
                            {{ $produk->toko->nama_toko }}
                        </h5>
                    </div>
                </div>

                <div class="store-right">
                    <a href="{{ route('public.tokos.show', $produk->toko->id_toko) }}"
                       class="btn store-btn">
                       Kunjungi Toko
                    </a>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="action-box">

                @if($produk->stok > 0)
                    <a href="https://wa.me/{{ $produk->toko->kontak_toko }}?text=Halo saya ingin membeli {{ urlencode($produk->nama_produk) }}"
                       target="_blank"
                       class="btn btn-chat">
                        <i class="fab fa-whatsapp"></i> Chat Penjual
                    </a>
                @else
                    <button class="btn btn-secondary btn-block mb-2" disabled>Stok Habis</button>
                @endif
            </div>

        </div>
    </div>

    <!-- DESCRIPTION CARD -->
    <div class="description-card shadow-sm mt-4 p-4">
        <h5 class="desc-title">Deskripsi Produk</h5>
        <p class="desc-text">{{ $produk->deskripsi }}</p>
    </div>

</div>

<script>
function changeMainImage(src, el) {
    document.getElementById("mainImage").src = src;
    document.querySelectorAll('.thumb-img').forEach(i => i.classList.remove("active"));
    el.classList.add("active");
}
</script>

<style>
/* ============================================================= */
/* SHOPEE PREMIUM THEME #EE6983 */
/* ============================================================= */
:root {
    --primary: #EE6983;
    --primary-dark: #d45b72;
    --soft-bg: #fff5f7;
}

/* Breadcrumb */
.premium-breadcrumb {
    background: #fff;
    border-radius: 6px;
    padding: 8px 14px;
}

/* Gallery Card */
.gallery-card {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
}

.main-img-wrap {
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
}

.main-img {
    width: 100%;
    height: 400px;
    border-radius: 8px;
    object-fit: cover;
}

.thumbnail-list {
    display: flex;
    gap: 8px;
}

.thumb-item {}

.thumb-img {
    width: 62px;
    height: 62px;
    border-radius: 6px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
}

.thumb-img.active,
.thumb-img:hover {
    border-color: var(--primary);
}

/* Product text */
.product-title {
    font-size: 1.6rem;
    font-weight: 600;
}

.price-main {
    color: var(--primary);
    font-weight: 800;
    font-size: 2rem;
}

/* Store card */
.store-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.store-left {
    display: flex;
    gap: 12px;
    align-items: center;
}

.store-avatar {
    width: 55px;
    height: 55px;
    border-radius: 50%;
}

.store-name {
    margin: 0;
    font-weight: 700;
}

.store-rating {
    font-size: 0.85rem;
    color: #777;
}

.store-btn {
    background: var(--primary);
    color: #fff;
    padding: 6px 16px;
    font-weight: 600;
    border-radius: 8px;
}

.store-btn:hover {
    background: var(--primary-dark);
}

/* Buttons Shopee style */
.action-box .btn {
    display: block;
    width: 100%;
    margin-bottom: 10px;
}

.btn-chat {
    background: #25D366 !important;
    color: #fff;
    font-weight: 700;
    padding: 12px;
    border-radius: 8px;
}

.description-card {
    background: #fff;
    border-radius: 14px;
}

.desc-title {
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.desc-text {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
}
</style>
@endsection
