@extends('member.layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $toko->nama_toko }}</h1>
        @if(Auth::check() && Auth::user()->id_user == $toko->id_user)
            <a href="{{ route('member.tokos.edit') }}" class="btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Toko
            </a>
        @endif
    </div>

    <!-- Toko Information -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Toko</h6>
                </div>
                <div class="card-body text-center">
                    @if($toko->gambar)
                        <img src="{{ asset('storage/tokos/' . $toko->gambar) }}"
                             alt="Logo Toko" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                            <i class="fas fa-store fa-3x text-muted"></i>
                        </div>
                    @endif

                    <h4>{{ $toko->nama_toko }}</h4>
                    <p class="text-muted">{{ $toko->deskripsi ?: 'Tidak ada deskripsi' }}</p>

                    <hr>

                    <div class="text-left">
                        <p><strong>Pemilik:</strong> {{ $toko->user->nama }}</p>
                        <p><strong>Kontak:</strong> {{ $toko->kontak_toko }}</p>
                        <p><strong>Alamat:</strong> {{ $toko->alamat }}</p>
                        <p><strong>Bergabung:</strong> {{ $toko->created_at->format('d M Y') }}</p>
                    </div>

                    @if($toko->kontak_toko)
                        <a href="https://wa.me/{{ $toko->kontak_toko }}" target="_blank" class="btn btn-success btn-block">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Produk ({{ $toko->produks->count() }})</h6>
                </div>
                <div class="card-body">
                    @if($toko->produks->count() > 0)
                        <div class="row">
                            @foreach($toko->produks as $produk)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        @if($produk->gambarProduks->count() > 0)
                                            <img src="{{ Storage::url('produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                                                 alt="{{ $produk->nama_produk }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif

                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title">{{ $produk->nama_produk }}</h6>
                                            <p class="card-text text-muted small">{{ Str::limit($produk->deskripsi, 50) }}</p>
                                            <p class="card-text"><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>

                                            <div class="mt-auto">
                                                @if($produk->stok > 0)
                                                    <a href="{{ route('tokos.show', $toko->id_toko) }}?produk={{ $produk->id_produk }}" class="btn btn-success btn-sm btn-block">
                                                        <i class="fas fa-eye"></i> Detail Produk
                                                    </a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm btn-block" disabled>
                                                        <i class="fas fa-times"></i> Stok Habis
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="card-footer text-muted small">
                                            Ditambahkan: {{ $produk->tanggal_upload->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                            <h5>Belum ada produk</h5>
                            <p class="text-muted">Toko ini belum memiliki produk yang dijual.</p>
                            @if(Auth::check() && Auth::user()->id_user == $toko->id_user)
                                <a href="#" class="btn btn-primary">Tambah Produk</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
