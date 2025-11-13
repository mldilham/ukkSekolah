@extends('admin.layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk Baru</h1>
        <a href="{{ route('admin.produks.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Produk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.produks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Produk -->
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text"
                                   class="form-control @error('nama_produk') is-invalid @enderror"
                                   id="nama_produk"
                                   name="nama_produk"
                                   value="{{ old('nama_produk') }}"
                                   required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="form-group">
                            <label for="id_kategori">Kategori</label>
                            <select class="form-control @error('id_kategori') is-invalid @enderror"
                                    id="id_kategori"
                                    name="id_kategori"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Toko -->
                        <div class="form-group">
                            <label for="id_toko">Toko</label>
                            <select class="form-control @error('id_toko') is-invalid @enderror"
                                    id="id_toko"
                                    name="id_toko"
                                    required>
                                <option value="">Pilih Toko</option>
                                @foreach($tokos as $toko)
                                    <option value="{{ $toko->id_toko }}" {{ old('id_toko') == $toko->id_toko ? 'selected' : '' }}>
                                        {{ $toko->nama_toko }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number"
                                   class="form-control @error('harga') is-invalid @enderror"
                                   id="harga"
                                   name="harga"
                                   value="{{ old('harga') }}"
                                   min="0"
                                   required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   id="stok"
                                   name="stok"
                                   value="{{ old('stok') }}"
                                   min="0"
                                   required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi"
                                      name="deskripsi"
                                      rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload Gambar -->
                        <div class="form-group">
                            <label for="gambar_produk">Gambar Produk</label>
                            <input type="file"
                                   class="form-control @error('gambar_produk') is-invalid @enderror"
                                   id="gambar_produk"
                                   name="gambar_produk[]"
                                   accept="image/*"
                                   multiple
                                   required>
                            <small class="form-text text-muted">
                                Pilih satu atau lebih gambar (format JPG, PNG, GIF, max 2MB per file, maksimal 10 gambar)
                            </small>
                            @error('gambar_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.produks.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
