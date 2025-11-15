@extends('layouts.app')
@section('content')

<style>
/* ============================================================= */
/* SHOPEE / TOKOPEDIA PREMIUM STYLE – #EE6983 */
/* ============================================================= */
:root {
    --primary: #EE6983;
    --primary-dark: #d45b72;
    --soft-bg: #fff5f7;
    --radius: 14px;
    --border: #f1d5dc;
}

/* Title */
.section-title {
    font-weight: 700;
    font-size: 1.7rem;
    color: #333;
}

/* ======================= SIDEBAR FILTER ======================= */
.sidebar-filter {
    background: #fff;
    border-radius: var(--radius);
    padding: 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid var(--border);
    position: sticky;
    top: 100px;
}

.filter-title {
    color: var(--primary);
    font-weight: 700;
    margin-bottom: 15px;
}

/* Category List */
.category-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.category-item {
    padding: 10px 14px;
    border-radius: 10px;
    font-weight: 600;
    color: #555;
    display: block;
    border: 1px solid #eee;
    transition: 0.2s;
}

.category-item:hover {
    background: var(--soft-bg);
    color: var(--primary);
    transform: translateX(6px);
}

.category-item.active {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

/* ======================= PRODUCT CARD ======================= */
.product-card {
    background: #fff;
    border-radius: var(--radius);
    overflow: hidden;
    transition: 0.25s ease;
    box-shadow: 0 3px 14px rgba(0,0,0,0.06);
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.product-thumb {
    width: 100%;
    height: 210px;
    object-fit: cover;
    border-bottom: 1px solid #eee;
}

.product-title {
    font-size: 1rem;
    font-weight: 700;
    color: #333;
}

.product-price {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--primary);
}

.product-btn {
    background: var(--primary);
    color: #fff;
    border-radius: 10px;
    font-weight: 600;
    padding: 8px;
    transition: 0.2s;
}

.product-btn:hover {
    background: var(--primary-dark);
}

/* Stock badge */
.stock-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
}

.stock-habis { background: #ff4444; color: white; }
.stock-terbatas { background: #FFB100; color: white; }

/* Responsive */
@media(max-width: 992px) {
    .sidebar-filter {
        position: relative;
        top: 0;
        margin-bottom: 20px;
    }
}
</style>

<div class="container py-4">

    <h1 class="mb-4 section-title">Semua Produk</h1>

    <div class="row">

        <!-- ===================== GRID PRODUK (KIRI) ===================== -->
        <div class="col-lg-9 order-1 order-lg-1">
            <div class="row">

                @forelse($produks as $produk)
                <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                    <div class="product-card">

                        <div class="position-relative">
                            @if($produk->gambarProduks->count())
                                <img src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                                     class="product-thumb">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height:210px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif

                            @if($produk->stok <= 0)
                                <span class="stock-badge stock-habis">Stok Habis</span>
                            @elseif($produk->stok <= 5)
                                <span class="stock-badge stock-terbatas">Terbatas</span>
                            @endif
                        </div>

                        <div class="p-3">
                            <h5 class="product-title mb-1">
                                {{ Str::limit($produk->nama_produk, 20) }}
                            </h5>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                <small class="text-muted">Stok: {{ $produk->stok }}</small>
                            </div>

                            <a href="{{ route('public.produks.show', $produk->id_produk) }}"
                               class="btn product-btn w-100">Lihat Detail</a>
                        </div>

                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <div class="p-5 bg-white rounded-3 shadow-sm">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h5 class="fw-bold">Tidak ada produk ditemukan</h5>
                        <p class="text-muted">Coba ubah filter atau pencarian.</p>
                    </div>
                </div>
                @endforelse

            </div>

            @if($produks->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $produks->appends(request()->query())->links() }}
                </div>
            @endif

        </div>

        <!-- ===================== SIDEBAR FILTER (KANAN) ===================== -->
        <div class="col-lg-3 order-2 order-lg-2">

            <div class="sidebar-filter">

                <h5 class="filter-title">Kategori</h5>

                <div class="category-list">

                    <a href="{{ route('public.produks.index', request()->only('search')) }}"
                       class="category-item {{ !request('kategori') ? 'active' : '' }}">
                        Semua Produk
                    </a>

                    @foreach($kategoris as $kategori)
                        <a href="{{ route('public.produks.index',
                            ['kategori' => $kategori->id_kategori] + request()->only('search')) }}"
                           class="category-item {{ request('kategori') == $kategori->id_kategori ? 'active' : '' }}">
                            {{ $kategori->nama_kategori }}
                        </a>
                    @endforeach
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
