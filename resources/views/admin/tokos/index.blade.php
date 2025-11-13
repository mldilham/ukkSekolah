@extends('admin.layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Tokos</h1>
        <a href="{{ route('admin.tokos.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Toko
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tokos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Logo / Banner</th>
                            <th>Nama Toko</th>
                            <th>Pemilik</th>
                            <th>Kontak Toko</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tokos as $toko)
                        <tr>
                            <td>{{ $toko->id_toko }}</td>
                            <td>
                                @if(!empty($toko->gambar) && file_exists(public_path('storage/tokos/' . $toko->gambar)))
                                    <img src="{{ asset('storage/tokos/' . $toko->gambar) }}"
                                        alt="Gambar {{ $toko->nama_toko }}"
                                        class="img-thumbnail"
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>

                            <td>{{ $toko->nama_toko }}</td>
                            <td>{{ $toko->user->nama ?? 'N/A' }}</td>
                            <td>{{ $toko->kontak_toko }}</td>
                            <td>{{ Str::limit($toko->alamat, 50) }}</td>
                            <td>
                                <a href="{{ route('tokos.show', $toko->id_toko) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('admin.tokos.edit', $toko->id_toko) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.tokos.destroy', $toko->id_toko) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus toko ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
