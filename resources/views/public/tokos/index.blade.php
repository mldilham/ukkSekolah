@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Semua Toko</h1>
    </div>

    <!-- Stores Grid -->
    <div class="row">
        @forelse($tokos as $toko)
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Store Image -->
                    <div class="position-relative">
                        @if($toko->gambar)
                            <img src="{{ asset('storage/tokos/' . $toko->gambar) }}"
                                 class="card-img-top" alt="{{ $toko->nama_toko }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                 style="height: 200px;">
                                <i class="fas fa-store fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Store Info -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-2">
                            {{ $toko->nama_toko }}
                        </h5>

                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-user text-primary"></i>
                            {{ $toko->user->nama }}
                        </p>

                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-map-marker-alt text-success"></i>
                            {{ Str::limit($toko->alamat, 50) }}
                        </p>

                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-box text-info"></i>
                            {{ $toko->produks->count() }} Produk
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('public.tokos.show', $toko->id_toko) }}"
                               class="btn btn-primary btn-sm w-100 mb-2">
                                <i class="fas fa-eye"></i> Lihat Toko
                            </a>

                            @if($toko->kontak_toko)
                                <a href="https://wa.me/{{ $toko->kontak_toko }}"
                                   target="_blank" class="btn btn-success btn-sm w-100">
                                    <i class="fab fa-whatsapp"></i> Hubungi
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Store Footer -->
                    <div class="card-footer text-muted small">
                        Bergabung: {{ $toko->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-store-slash fa-4x text-muted mb-3"></i>
                        <h5>Belum ada toko</h5>
                        <p class="text-muted">Belum ada toko yang terdaftar di platform ini.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($tokos->hasPages())
        <div class="d-flex justify-content-center">
            {{ $tokos->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
