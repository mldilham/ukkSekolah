@extends('layouts.app')

@section('content')
<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($produks->take(3) as $index => $produk)
            <li data-target="#heroCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>
    <div class="carousel-inner">
        @foreach($produks->take(3) as $index => $produk)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                @if($produk->gambarProduks->isNotEmpty())
                    <img class="d-block w-100" src="{{ asset('storage/' . $produk->gambarProduks->first()->gambar) }}" alt="{{ $produk->nama }}" style="height: 500px; object-fit: cover;">
                @else
                    <img class="d-block w-100" src="{{ asset('template/img/undraw_posting_photo.svg') }}" alt="Default" style="height: 500px; object-fit: cover;">
                @endif
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $produk->nama }}</h5>
                    <p>Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('public.produks.show', $produk->id_produk) }}" class="btn btn-success">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- Kategori Produk -->
<div class="container my-5">
    <h2 class="text-center mb-4 text-success">Kategori Produk</h2>
    <div class="row">
        @foreach($kategoris as $kategori)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-tag fa-3x text-success mb-3"></i>
                        <h5 class="card-title">{{ $kategori->nama }}</h5>
                        <a href="{{ route('public.produks.index', ['kategori' => $kategori->id]) }}" class="btn btn-outline-success btn-sm">Lihat Produk</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Produk Terbaru -->
<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4 text-success">Produk Terbaru</h2>
        <div class="row">
            @foreach($produks as $produk)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        @if($produk->gambarProduks->isNotEmpty())
                            <img class="card-img-top" src="{{ asset('storage/produks/' . $produk->gambarProduks->first()->gambar) }}" alt="{{ $produk->nama }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img class="card-img-top" src="{{ asset('template/img/undraw_posting_photo.svg') }}" alt="Default" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{ $produk->nama }}</h6>
                            <p class="card-text text-success font-weight-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            <p class="card-text small text-muted">{{ $produk->toko->nama ?? 'Toko' }}</p>
                            <a href="{{ route('public.produks.show', $produk->id_produk) }}" class="btn btn-success btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Toko Terbaru -->
<div class="container my-5">
    <h2 class="text-center mb-4 text-success">Toko Terbaru</h2>
    <div class="row">
        @foreach($tokos as $toko)
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-store fa-3x text-success mb-3"></i>
                        <h5 class="card-title">{{ $toko->nama }}</h5>
                        <p class="card-text small text-muted">{{ $toko->user->nama ?? 'Pemilik' }}</p>
                        <a href="{{ route('public.tokos.show', $toko->id_toko) }}" class="btn btn-outline-success btn-sm">Kunjungi Toko</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
