@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('public.tokos.index') }}">Toko</a></li>
            <li class="breadcrumb-item active">{{ $toko->nama_toko }}</li>
        </ol>
    </nav>

    <!-- Store Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            @if($toko->gambar)
                                <img src="{{ asset('storage/tokos/' . $toko->gambar) }}"
                                     alt="Logo Toko" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                                    <i class="fas fa-store fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h2 class="mb-2">{{ $toko->nama_toko }}</h2>
                            <p class="text-muted mb-2">{{ $toko->deskripsi ?: 'Tidak ada deskripsi' }}</p>

                            <div class="store-details">
                                <p class="mb-1">
                                    <i class="fas fa-user text-primary"></i>
                                    <strong>Pemilik:</strong> {{ $toko->user->nama }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-phone text-success"></i>
                                    <strong>Kontak:</strong> {{ $toko->kontak_toko }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                    <strong>Alamat:</strong> {{ $toko->alamat }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar text-info"></i>
                                    <strong>Bergabung:</strong> {{ $toko->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            @if($toko->kontak_toko)
                                <a href="https://wa.me/{{ $toko->kontak_toko }}?text=Halo, saya tertarik dengan produk di toko {{ urlencode($toko->nama_toko) }}"
                                   target="_blank" class="btn btn-success btn-lg mb-2">
                                    <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                                </a>
                            @endif
                            <a href="{{ route('public.tokos.index') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Produk Toko ({{ $toko->produks->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($toko->produks->count() > 0)
                        <div class="row">
                            @foreach($toko->produks as $produk)
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <!-- Product Image -->
                                        <div class="position-relative">
                                            @if($produk->gambarProduks->count() > 0)
                                                <img src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                                                     class="card-img-top" alt="{{ $produk->nama_produk }}"
                                                     style="height: 180px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                     style="height: 180px;">
                                                    <i class="fas fa-image fa-2x text-muted"></i>
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
                                                {{ Str::limit($produk->nama_produk, 35) }}
                                            </h6>

                                            <p class="card-text text-muted small mb-2">
                                                <i class="fas fa-tag text-success"></i>
                                                {{ $produk->kategori->nama_kategori ?? 'N/A' }}
                                            </p>

                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="h6 text-success fw-bold mb-0">
                                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                                    </span>
                                                    <small class="text-muted">
                                                        Stok: {{ $produk->stok }}
                                                    </small>
                                                </div>

                                                <a href="{{ route('produks.show', $produk->id_produk) }}"
                                                   class="btn btn-primary btn-sm w-100 mb-2">
                                                    <i class="fas fa-eye"></i> Lihat Detail
                                                </a>

                                                @if($produk->stok > 0 && $toko->kontak_toko)
                                                    <a href="https://wa.me/{{ $toko->kontak_toko }}?text=Halo, saya tertarik dengan produk {{ urlencode($produk->nama_produk) }} yang dijual di toko {{ urlencode($toko->nama_toko) }}. Apakah masih tersedia?"
                                                       target="_blank" class="btn btn-success btn-sm w-100">
                                                        <i class="fab fa-whatsapp"></i> Pesan
                                                    </a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                                        <i class="fas fa-times"></i> Stok Habis
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Product Footer -->
                                        <div class="card-footer text-muted small">
                                            Upload: {{ $produk->tanggal_upload->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                            <h5>Toko ini belum memiliki produk</h5>
                            <p class="text-muted">Belum ada produk yang dijual di toko ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
