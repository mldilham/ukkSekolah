@extends('layouts.app')

@section('content')
<style>
    .produk-container {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .produk-gambar-utama img {
        width: 100%;
        max-height: 420px;
        object-fit: cover;
        border-radius: 10px;
    }
    .produk-thumbnail img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid transparent;
        cursor: pointer;
        transition: border 0.2s;
    }
    .produk-thumbnail img:hover,
    .produk-thumbnail img.active {
        border-color: #ee4d2d;
    }
    .harga-produk {
        font-size: 1.8rem;
        font-weight: bold;
        color: #ee4d2d;
    }
    .harga-coret {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9rem;
        margin-left: 8px;
    }
    .btn-wa {
        background-color: #25D366;
        color: #fff;
        font-weight: 600;
        border: none;
    }
    .btn-wa:hover {
        background-color: #1ebe5d;
        color: #fff;
    }
    .produk-lain img {
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<div class="container py-4">
    <div class="produk-container mb-4">
        <div class="row g-4">
            {{-- ======================== --}}
            {{-- BAGIAN GAMBAR PRODUK --}}
            {{-- ======================== --}}
            <div class="col-md-5 text-center">
                <div class="produk-gambar-utama mb-3">
                    @if($produk->gambarProduks->count() > 0)
                        <img id="mainImage"
                            src="{{ Storage::url('produks/') , $produk->gambarProduks->first()->path_gambar }}"
                            alt="{{ $produk->nama_produk }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                    @endif
                </div>

                <div class="d-flex justify-content-center flex-wrap gap-2 produk-thumbnail">
                    @foreach($produk->gambarProduks as $gambar)
                        <img src="{{ Storage::url($gambar->path_gambar) }}"
                             onclick="changeImage(this, '{{ Storage::url($gambar->path_gambar) }}')"
                             alt="Thumbnail">
                    @endforeach
                </div>

                <p class="mt-2 text-muted small">
                    {{ $produk->gambarProduks->count() }} Gambar Produk
                </p>
            </div>

            {{-- ======================== --}}
            {{-- BAGIAN DETAIL PRODUK --}}
            {{-- ======================== --}}
            <div class="col-md-7">
                <h4 class="fw-bold mb-2">{{ $produk->nama_produk }}</h4>

                <div class="mb-3 text-muted small">
                    ⭐ 4.7 | {{ rand(20, 120) }} Terjual
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <span class="harga-produk">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </span>
                    <span class="harga-coret">
                        Rp {{ number_format($produk->harga * 1.3, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Info Produk --}}
                <div class="border-top border-bottom py-3 mb-3">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="150"><strong>Kategori</strong></td>
                            <td>{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Stok</strong></td>
                            <td>{{ $produk->stok }} tersedia</td>
                        </tr>
                        <tr>
                            <td><strong>Toko</strong></td>
                            <td>
                                <a href="{{ route('tokos.show', $produk->toko->id_toko) }}" class="text-decoration-none text-primary">
                                    {{ $produk->toko->nama_toko ?? '-' }}
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <h6 class="fw-bold mb-2">Deskripsi Produk</h6>
                    <p class="text-secondary" style="white-space: pre-line;">
                        {{ $produk->deskripsi }}
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex align-items-center gap-3">
                    @if($produk->stok > 0)
                        <a href="https://wa.me/{{ $produk->toko->kontak_toko }}?text=Halo, saya tertarik membeli produk {{ $produk->nama_produk }} seharga Rp{{ number_format($produk->harga, 0, ',', '.') }}"
                           target="_blank"
                           class="btn btn-wa px-4 py-2">
                            <i class="fab fa-whatsapp me-2"></i>Beli via WhatsApp
                        </a>
                    @else
                        <button class="btn btn-secondary px-4 py-2" disabled>Stok Habis</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== --}}
    {{-- BAGIAN PRODUK LAIN --}}
    {{-- ======================== --}}
    @if($produk->toko && $produk->toko->produks->count() > 1)
        <div class="mt-4">
            <h5 class="fw-bold mb-3">Produk Lain dari {{ $produk->toko->nama_toko }}</h5>
            <div class="row">
                @foreach($produk->toko->produks->where('id_produk', '!=', $produk->id_produk)->take(4) as $p)
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('produk.detail', $p->id_produk) }}" class="text-decoration-none text-dark">
                            <div class="card produk-lain h-100">
                                @if($p->gambarProduks->count() > 0)
                                    <img src="{{ Storage::url($p->gambarProduks->first()->path_gambar) }}" class="card-img-top">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1">{{ Str::limit($p->nama_produk, 40) }}</h6>
                                    <p class="text-danger fw-bold mb-0">
                                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function changeImage(element, src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.produk-thumbnail img').forEach(img => img.classList.remove('active'));
    element.classList.add('active');
}
</script>
@endsection
