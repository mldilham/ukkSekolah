@extends('member.layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Toko</h1>
        @if(!$toko)
            <a href="{{ route('member.tokos.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Buat Toko
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($toko)
        <!-- Toko Info Card -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Toko</h6>
                        <div>
                            <a href="{{ route('tokos.show', $toko->id_toko) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Lihat Profil Publik
                            </a>
                            <a href="{{ route('member.tokos.edit') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if(!empty($toko->gambar) && file_exists(public_path('storage/tokos/' . $toko->gambar)))
                                    <img src="{{ asset('storage/tokos/' . $toko->gambar) }}"
                                        alt="Gambar {{ $toko->nama_toko }}"
                                        class="img-thumbnail"
                                        style=" max-height: 200px;">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h4>{{ $toko->nama_toko }}</h4>
                                <p class="text-muted">{{ $toko->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <strong>Kontak:</strong><br>
                                        {{ $toko->kontak_toko }}
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Alamat:</strong><br>
                                        {{ Str::limit($toko->alamat, 100) }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <strong>Jumlah Produk:</strong><br>
                                        {{ $toko->produks->count() }} produk
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Dibuat:</strong><br>
                                        {{ $toko->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('member.tokos.edit') }}" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-edit"></i> Edit Toko
                        </a>
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
                            <i class="fas fa-trash"></i> Hapus Toko
                        </button>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h2 class="text-primary">{{ $toko->produks->count() }}</h2>
                            <p class="text-muted">Total Produk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Toko</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('member.tokos.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <div class="alert alert-danger">
                                <strong>PERINGATAN!</strong> Tindakan ini tidak dapat dibatalkan.
                            </div>
                            <p>Apakah Anda yakin ingin menghapus toko <strong>"{{ $toko->nama_toko }}"</strong>?</p>
                            <p>Semua produk dan data terkait akan dihapus secara permanen.</p>
                            <div class="form-group">
                                <label for="confirm">Ketik <strong>HAPUS</strong> untuk konfirmasi:</label>
                                <input type="text" class="form-control" id="confirm" name="confirm" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus Toko</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <!-- No Toko Message -->
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-store fa-4x text-muted mb-3"></i>
                <h4>Anda Belum Memiliki Toko</h4>
                <p class="text-muted">Buat toko Anda sekarang untuk mulai berjualan produk.</p>
                <a href="{{ route('member.tokos.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Buat Toko Sekarang
                </a>
            </div>
        </div>
    @endif
@endsection
