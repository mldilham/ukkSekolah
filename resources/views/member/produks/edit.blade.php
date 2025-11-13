@extends('member.layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
        <a href="{{ route('member.produks.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Produk</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('member.produks.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <!-- Nama Produk -->
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                   id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="form-group">
                            <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_kategori') is-invalid @enderror"
                                    id="id_kategori" name="id_kategori" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $produk->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="form-group">
                            <label for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                   id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" min="0" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div class="form-group">
                            <label for="stok">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                   id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Gambar Produk Saat Ini -->
                        <div class="form-group">
                            <label>Gambar Produk Saat Ini</label>
                            <div class="border rounded p-3">
                                @if($produk->gambarProduks->count() > 0)
                                    <div class="row">
                                        @foreach($produk->gambarProduks as $gambar)
                                            <div class="col-md-3 mb-2">
                                                <img src="{{ asset('storage/produks/' . $gambar->nama_gambar) }}" alt="Gambar Produk" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" name="delete_gambar[]" value="{{ $gambar->id_gambar }}" id="delete_{{ $gambar->id_gambar }}">
                                                    <label class="form-check-label" for="delete_{{ $gambar->id_gambar }}">
                                                        Hapus gambar ini
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                        <p class="text-muted">Belum ada gambar</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Upload Gambar Baru -->
                        <div class="form-group">
                            <label for="gambar_produk">Tambah Gambar Baru</label>
                            <input type="file" class="form-control @error('gambar_produk') is-invalid @enderror"
                                   id="gambar_produk" name="gambar_produk[]" accept="image/*" multiple>
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB per file. Maksimal 10 gambar. Kosongkan jika tidak ingin menambah gambar.</small>
                            @error('gambar_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Gambar Baru -->
                        <div class="form-group">
                            <label>Preview Gambar Baru</label>
                            <div id="image-preview" class="border rounded p-3 text-center" style="min-height: 150px;">
                                <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                <p class="text-muted">Pilih gambar baru untuk melihat preview</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Produk
                    </button>
                    <a href="{{ route('member.produks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
document.getElementById('gambar_produk').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 150px;">';
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '<i class="fas fa-image fa-2x text-muted mb-2"></i><p class="text-muted">Pilih gambar baru untuk melihat preview</p>';
    }
});
</script>
