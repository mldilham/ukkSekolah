@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Gambar Produk</h1>
        <a href="{{ route('admin.gambar_produks.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Gambar Produk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gambar_produks.update', $gambarProduk->id_gambar) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="id_produk">Produk</label>
                            <select class="form-control @error('id_produk') is-invalid @enderror" id="id_produk" name="id_produk" required>
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->id_produk }}" {{ old('id_produk', $gambarProduk->id_produk) == $produk->id_produk ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_gambar">Nama Gambar</label>
                            <input type="text" class="form-control @error('nama_gambar') is-invalid @enderror" id="nama_gambar" name="nama_gambar" value="{{ old('nama_gambar', $gambarProduk->nama_gambar) }}" required>
                            @error('nama_gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.gambar_produks.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
