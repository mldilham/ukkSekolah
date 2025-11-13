@extends('member.layouts.app')
@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('member.produks.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Galeri Gambar -->
        <div class="col-lg-6">
            <div class="product-gallery">
                @if($produk->gambarProduks->isNotEmpty())
                    <!-- Gambar Utama -->
                    <div class="main-image-container mb-3">
                        <img id="mainImage"
                             src="{{ Storage::url('produks/' . $produk->gambarProduks->first()->nama_gambar) }}"
                             alt="{{ $produk->nama_produk }}"
                             class="img-fluid main-product-image">
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($produk->gambarProduks->count() > 1)
                        <div class="thumbnail-gallery">
                            @foreach($produk->gambarProduks as $index => $gambar)
                                <img src="{{ Storage::url('produks/' . $gambar->nama_gambar) }}"
                                     alt="{{ $produk->nama_produk }}"
                                     class="thumbnail-image {{ $index == 0 ? 'active' : '' }}"
                                     onclick="changeMainImage('{{ Storage::url('produks/' . $gambar->nama_gambar) }}', this)">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="no-image-placeholder">
                        <img src="{{ asset('template/img/undraw_posting_photo.svg') }}" alt="No Image" class="img-fluid">
                        <p class="text-muted mt-3">Tidak ada gambar untuk produk ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informasi Produk -->
        <div class="col-lg-6">
            <div class="product-info">
                <!-- Nama Produk -->
                <h1 class="product-title mb-2">{{ $produk->nama_produk }}</h1>

                <!-- Kategori -->
                <div class="category-badge mb-3">
                    <span class="badge badge-primary">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</span>
                </div>

                <!-- Harga -->
                <div class="price-section mb-4">
                    <h2 class="product-price text-success mb-0">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
                </div>

                <!-- Stok -->
                <div class="stock-info mb-3">
                    <span class="stock-label">Stok:</span>
                    <span class="stock-value {{ $produk->stok > 0 ? 'text-success' : 'text-danger' }}">
                        {{ $produk->stok }} {{ $produk->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>

                <!-- Informasi Toko -->
                <div class="store-info mb-4 p-3 bg-light rounded">
                    <h5 class="store-name mb-2">
                        <i class="fas fa-store text-primary"></i>
                        {{ $produk->toko->nama_toko ?? 'N/A' }}
                    </h5>
                    @if($produk->toko)
                        <div class="store-details">
                            <p class="mb-1">
                                <i class="fas fa-user text-muted"></i>
                                <small class="text-muted">Pemilik: {{ $produk->toko->user->name ?? 'N/A' }}</small>
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-phone text-muted"></i>
                                <small class="text-muted">Kontak: {{ $produk->toko->kontak_toko ?? 'N/A' }}</small>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-map-marker-alt text-muted"></i>
                                <small class="text-muted">Alamat: {{ $produk->toko->alamat ?? 'N/A' }}</small>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Informasi Tambahan -->
                <div class="additional-info mb-4">
                    <div class="info-item">
                        <strong>ID Produk:</strong> {{ $produk->id_produk }}
                    </div>
                    <div class="info-item">
                        <strong>Tanggal Upload:</strong> {{ $produk->tanggal_upload->format('d M Y, H:i') }}
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="product-description mb-4">
                    <h5>Deskripsi Produk</h5>
                    <p class="description-text">{{ $produk->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('member.produks.edit', $produk->id_produk) }}" class="btn btn-warning btn-lg btn-block mb-2">
                        <i class="fas fa-edit"></i> Edit Produk
                    </a>
                    {{-- <a href="{{ route('tokos.show', $produk->toko->id_toko) }}" class="btn btn-info btn-lg btn-block mb-2" target="_blank">
                        <i class="fas fa-store"></i> Lihat di Toko
                    </a> --}}
                    <form action="{{ route('member.produks.destroy', $produk->id_produk) }}" method="POST" class="d-inline w-100">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg btn-block" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            <i class="fas fa-trash"></i> Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeMainImage(src, element) {
            document.getElementById('mainImage').src = src;
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail-image').forEach(img => {
                img.classList.remove('active');
            });
            // Add active class to clicked thumbnail
            element.classList.add('active');
        }
    </script>

    <style>
        .product-gallery {
            position: sticky;
            top: 20px;
        }

        .main-product-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .thumbnail-gallery {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 10px 0;
        }

        .thumbnail-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }

        .thumbnail-image:hover,
        .thumbnail-image.active {
            border-color: #007bff;
        }

        .product-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
        }

        .stock-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stock-label {
            font-weight: 600;
            color: #666;
        }

        .store-info {
            border-left: 4px solid #007bff;
        }

        .store-name {
            color: #007bff;
            font-weight: 600;
        }

        .product-description h5 {
            color: #333;
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 8px;
        }

        .description-text {
            line-height: 1.6;
            color: #666;
        }

        .action-buttons .btn {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .no-image-placeholder {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .breadcrumb {
            background: #f8f9fa;
            border-radius: 4px;
        }
    </style>
@endsection
