@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Hero Section -->
    <div class="row align-items-center my-5 bg-light rounded shadow-sm p-4">
        <div class="col-md-6 text-center text-md-start">
            <h1 class="display-5 fw-bold text-primary mb-3">Selamat Datang di <span class="text-success">MarSchool</span></h1>
            <p class="lead text-muted mb-4">Tempat terbaik untuk menemukan produk keren dari berbagai toko!</p>
            <a href="{{ route('public.produks.index') }}" class="btn btn-success btn-lg me-2">
                <i class="fas fa-shopping-bag"></i> Belanja Sekarang
            </a>
            {{-- <a href="{{ route('publi') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-store"></i> Buka Toko
            </a> --}}
        </div>
        <div class="col-md-6 text-center mt-4 mt-md-0">
            <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" alt="E-commerce"
                 class="img-fluid" style="max-height: 280px;">
        </div>
    </div>

    <!-- Toko Terbaru -->
    @if($tokos->count() > 0)
    <div class="my-5">
        <h3 class="text-center fw-bold text-dark mb-4">Toko Terbaru</h3>
        <div class="row">
            @foreach($tokos as $toko)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    @if($toko->gambar)
                        <img src="{{ asset('storage/tokos/' . $toko->gambar) }}"
                             class="card-img-top" alt="{{ $toko->nama_toko }}"
                             style="height:180px;object-fit:cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                            <i class="fas fa-store fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body text-center">
                        <h6 class="fw-bold text-dark">{{ $toko->nama_toko }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($toko->deskripsi, 50) }}</p>
                        <a href="{{ route('tokos.show', $toko->id_toko) }}" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-eye"></i> Lihat Toko
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Produk Terbaru -->
    @if($produks->count() > 0)
    <div class="my-5">
        <h3 class="text-center fw-bold text-dark mb-4">Produk Terbaru</h3>
        <div class="row">
            @foreach($produks as $produk)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    @if($produk->gambarProduks->count() > 0)
                        <img src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                             class="card-img-top" alt="{{ $produk->nama_produk }}"
                             style="height:180px;object-fit:cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                            <i class="fas fa-box fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body text-center">
                        <h6 class="fw-bold text-dark">{{ Str::limit($produk->nama_produk, 30) }}</h6>
                        <p class="fw-bold text-success mb-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <small class="text-muted d-block mb-2">{{ $produk->toko->nama_toko }}</small>
                        <a href="{{ route('produks.show', $produk->id_produk) }}" class="btn btn-sm btn-success w-100">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Link ke Halaman Produk dan Toko -->
    <div class="my-5">
        <h3 class="text-center fw-bold text-dark mb-4">Jelajahi Marketplace</h3>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-box fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Semua Produk</h5>
                        <p class="text-muted">Temukan produk menarik dari berbagai toko</p>
                        <a href="{{ route('public.produks.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i> Lihat Produk
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-store fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Semua Toko</h5>
                        <p class="text-muted">Jelajahi berbagai toko yang tersedia</p>
                        <a href="{{ route('public.tokos.index') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-store"></i> Lihat Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-primary text-white text-center py-5 rounded shadow my-5">
        <h3 class="fw-bold mb-3">Ingin Mulai Berjualan?</h3>
        <p class="mb-4">Buka toko Anda di MarSchool dan jangkau lebih banyak pembeli!</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
            <i class="fas fa-rocket"></i> Daftar Sekarang
        </a>
    </div>

</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(90deg, #007bff 0%, #28a745 100%);
}
.hover-shadow:hover {
    transform: translateY(-5px);
    transition: 0.3s;
}
.card-body h6 {
    min-height: 40px;
}
</style>
@endpush
