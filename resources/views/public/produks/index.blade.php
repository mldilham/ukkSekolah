@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Semua Produk</h1>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Produk</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('public.produks.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">Cari Produk</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Masukkan nama produk...">
                        </div>
                        <div class="col-md-4">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}"
                                            {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @forelse($produks as $produk)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Product Image -->
                    <div class="position-relative">
                        @if($produk->gambarProduks->count() > 0)
                            <img src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                                 class="card-img-top" alt="{{ $produk->nama_produk }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                 style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif

                        <!-- Stock Badge -->
                        @if($produk->stok <= 0)
                            <span class="badge bg-danger position-absolute" style="top: 10px; right: 10px;">
                                Stok Habis
                            </span>
                        @elseif($produk->stok <= 5)
                            <span class="badge bg-warning position-absolute" style="top: 10px; right: 10px;">
                                Stok Terbatas
                            </span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold text-dark mb-2">
                            {{ Str::limit($produk->nama_produk, 40) }}
                        </h6>

                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-store text-primary"></i>
                            {{ $produk->toko->nama_toko }}
                        </p>

                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-tag text-success"></i>
                            {{ $produk->kategori->nama_kategori ?? 'N/A' }}
                        </p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 text-success fw-bold mb-0">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </span>
                                <small class="text-muted">
                                    Stok: {{ $produk->stok }}
                                </small>
                            </div>

                            <a href="{{ route('public.produks.show', $produk->id_produk) }}"
                               class="btn btn-primary btn-sm w-100 mb-2">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h5>Tidak ada produk ditemukan</h5>
                        <p class="text-muted">Coba ubah kriteria pencarian atau filter kategori.</p>
                        <a href="{{ route('public.produks.index') }}" class="btn btn-primary">
                            <i class="fas fa-refresh"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($produks->hasPages())
        <div class="d-flex justify-content-center">
            {{ $produks->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
