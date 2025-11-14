@extends('admin.layouts.app')
@section('content')
    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Success Alert for Produk Actions -->
    @if(session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "OK",
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    <!-- Error Alert for Produk Actions -->
    @if(session('error'))
        <script>
            Swal.fire({
                title: "Gagal!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>
    @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Produks</h1>
        <a href="{{ route('admin.produks.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pencarian & Filter</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.produks.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Nama Produk</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Masukkan nama produk...">
                </div>
                <div class="col-md-3">
                    <label for="kategori" class="form-label">Filter Kategori</label>
                    <select class="form-control" id="kategori" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}" {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="toko" class="form-label">Filter Toko</label>
                    <select class="form-control" id="toko" name="toko">
                        <option value="">Semua Toko</option>
                        @foreach($tokos as $toko)
                            <option value="{{ $toko->id_toko }}" {{ request('toko') == $toko->id_toko ? 'selected' : '' }}>
                                {{ $toko->nama_toko }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.produks.index') }}"  class="btn btn-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produks ({{ $produks->total() }} produk)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table">
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Toko</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produks as $produk)
                        <tr>
                            <td>{{ $produk->id_produk }}</td>
                            <td>
                                @if($produk->gambarProduks->isNotEmpty())
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($produk->gambarProduks->take(3) as $gambar)
                                            <img src="{{ Storage::url('produks/' . $gambar->nama_gambar) }}"
                                                 alt="{{ $produk->nama_produk }}"
                                                 width="40" height="40"
                                                 class="img-thumbnail">
                                        @endforeach
                                        @if($produk->gambarProduks->count() > 3)
                                            <div class="d-flex align-items-center justify-content-center bg-light border rounded" style="width: 40px; height: 40px;">
                                                <small class="text-muted">+{{ $produk->gambarProduks->count() - 3 }}</small>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>{{ $produk->nama_produk }}</td>
                            <td>{{ $produk->kategori->nama_kategori ?? 'N/A' }}</td>
                            <td>{{ $produk->toko->nama_toko ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>{{ $produk->tanggal_upload->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('produks.show', $produk->id_produk) }}" target="_blank" class="btn btn-sm btn-info mb-1">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('admin.produks.edit', $produk->id_produk) }}" class="btn btn-sm btn-warning mb-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.produks.destroy', $produk->id_produk) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $produks->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
