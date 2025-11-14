@extends('layouts.app')
@section('content')

<style>
:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --secondary: #f43f5e;
    --success: #10b981;
    --warning: #f59e0b;
    --soft-bg: #f8fafc;
    --border: #e2e8f0;
    --text-muted: #64748b;
    --radius: 16px;
    --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

body {
    background-color: #f1f5f9;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* BREADCRUMB */
.breadcrumb {
    background: white;
    border-radius: var(--radius);
    padding: 1rem 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: var(--text-muted);
}

.breadcrumb-item a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: var(--text-muted);
}

/* STORE HEADER */
.store-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius);
    color: white;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
}

.store-header::before,
.store-header::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
}

.store-header::before {
    top: 0;
    right: 0;
    width: 300px;
    height: 300px;
    transform: translate(100px, -100px);
}

.store-header::after {
    bottom: 0;
    left: 0;
    width: 200px;
    height: 200px;
    transform: translate(-50px, 50px);
}

.store-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.store-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 4px solid rgba(255,255,255,0.3);
    box-shadow: var(--shadow);
    flex-shrink: 0;
}

.store-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.store-details {
    flex: 1;
}

.store-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.store-description {
    opacity: 0.9;
    margin-bottom: 1rem;
    max-width: 600px;
}

.store-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-chat {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    padding: 0.5rem 1rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-chat:hover {
    background: rgba(255,255,255,0.3);
    color: white;
}

.store-stats {
    display: flex;
    gap: 2rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.stat-item i {
    font-size: 1.25rem;
    opacity: 0.8;
}

.stat-item span {
    font-weight: 600;
}

/* PRODUCT SECTION */
.products-section {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 2rem;
}

.section-header {
    background: var(--soft-bg);
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title {
    font-weight: 700;
    font-size: 1.25rem;
    color: #1e293b;
    margin: 0;
}

.product-count {
    background: var(--primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
}

/* PRODUCT CARD */
.product-card {
    border-radius: var(--radius);
    overflow: hidden;
    background: white;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    border: 1px solid var(--border);
    height: 100%;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.product-img-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-img {
    transform: scale(1.05);
}

.product-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 0.375rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-out {
    background: var(--secondary);
    color: white;
}

.badge-low {
    background: var(--warning);
    color: white;
}

.product-body {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.product-category {
    color: var(--primary);
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-name {
    font-weight: 700;
    font-size: 1.1rem;
    color: #1e293b;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    font-weight: 700;
    font-size: 1.25rem;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.product-stock {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.product-actions {
    margin-top: auto;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.btn-detail {
    background: var(--primary);
    color: white;
    border: none;
    padding: 0.625rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-align: center;
}

.btn-detail:hover {
    background: var(--primary-dark);
    color: white;
}

.btn-order {
    background: var(--success);
    color: white;
    border: none;
    padding: 0.625rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-order:hover {
    background: #059669;
    color: white;
}

.btn-disabled {
    background: #e2e8f0;
    color: var(--text-muted);
    border: none;
    padding: 0.625rem;
    border-radius: 10px;
    font-weight: 600;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.product-footer {
    background: var(--soft-bg);
    padding: 0.75rem 1.25rem;
    font-size: 0.85rem;
    color: var(--text-muted);
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* EMPTY STATE */
.empty-state {
    padding: 3rem 1rem;
    text-align: center;
}

.empty-icon {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.empty-title {
    font-weight: 700;
    font-size: 1.5rem;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-text {
    color: var(--text-muted);
    max-width: 400px;
    margin: 0 auto;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .store-info {
        flex-direction: column;
        text-align: center;
    }

    .store-stats {
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .store-actions {
        justify-content: center;
    }
}
</style>

<div class="container py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('public.tokos.index') }}">Toko</a></li>
            <li class="breadcrumb-item active">{{ $toko->nama_toko }}</li>
        </ol>
    </nav>

    <!-- STORE HEADER -->
    <div class="store-header">
        <div class="store-info">
            <div class="store-avatar">
                @if($toko->gambar)
                    <img src="{{ asset('storage/tokos/' . $toko->gambar) }}" alt="{{ $toko->nama_toko }}">
                @else
                    <i class="fas fa-store fa-3x text-primary"></i>
                @endif
            </div>

            <div class="store-details">
                <h2 class="store-title">{{ $toko->nama_toko }}</h2>
                <p class="store-description">{{ $toko->deskripsi ?: 'Tidak ada deskripsi tersedia' }}</p>

                <div class="store-actions">
                    @if($toko->kontak_toko)
                    <a href="https://wa.me/{{ $toko->kontak_toko }}?text=Halo, saya tertarik dengan toko {{ urlencode($toko->nama_toko) }}" target="_blank" class="btn-chat">
                        <i class="fab fa-whatsapp"></i> Hubungi Toko
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="store-stats">
            <div class="stat-item">
                <i class="fas fa-box"></i>
                <span>{{ $toko->produks->count() }} Produk</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-calendar"></i>
                <span>Bergabung {{ $toko->created_at->format('M Y') }}</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $toko->alamat ?: 'Lokasi tidak tersedia' }}</span>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="products-section">
        <div class="section-header">
            <h3 class="section-title">Produk Toko</h3>
            <span class="product-count">{{ $toko->produks->count() }} Produk</span>
        </div>

        <div class="p-3">
            @if($toko->produks->count())
                <div class="row justify-content-center">
                    @foreach($toko->produks as $produk)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="product-card">
                                <div class="product-img-container">
                                    @if($produk->gambarProduks->count())
                                        <img src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}" class="product-img" alt="{{ $produk->nama_produk }}">
                                    @else
                                        <div class="d-flex justify-content-center align-items-center bg-light h-100">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif

                                    @if($produk->stok <= 0)
                                        <span class="product-badge badge-out">Stok Habis</span>
                                    @elseif($produk->stok <= 5)
                                        <span class="product-badge badge-low">Stok Terbatas</span>
                                    @endif
                                </div>

                                <div class="product-body">
                                    <h5 class="product-name">{{ $produk->nama_produk }}</h5>
                                    <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>

                                    <div class="product-actions">
                                        <a href="{{ route('public.produks.show', $produk->id_produk) }}" class="btn-detail">
                                            <i class="fas fa-eye me-1"></i> Lihat Detail
                                        </a>

                                        @if($produk->stok > 0)
                                            <a href="https://wa.me/{{ $toko->kontak_toko }}?text=Halo, saya ingin membeli produk {{ urlencode($produk->nama_produk) }}" class="btn-order" target="_blank">
                                                <i class="fab fa-whatsapp me-1"></i> Pesan via WA
                                            </a>
                                        @else
                                            <button class="btn-disabled" disabled>
                                                <i class="fas fa-times me-1"></i> Stok Habis
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="product-footer">
                                    <i class="fas fa-clock"></i> Upload: {{ $produk->tanggal_upload->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="empty-title">Belum ada produk</h3>
                    <p class="empty-text">Toko ini belum mengupload produk apapun. Silakan kembali lagi nanti untuk melihat produk terbaru dari toko ini.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
