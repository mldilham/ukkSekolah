@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Testimoni</h1>
        <a href="{{ route('admin.testimonis.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Testimoni
        </a>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Success Alert for Testimoni Actions -->
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

    <!-- Error Alert for Testimoni Actions -->
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Testimoni</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Testimoni</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonis as $testimoni)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($testimoni->foto)
                                        <img src="{{ asset('storage/' . $testimoni->foto) }}" alt="{{ $testimoni->nama }}" class="rounded-circle" width="50" height="50">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $testimoni->nama }}</td>
                                <td>{{ $testimoni->jabatan ?? '-' }}</td>
                                <td>{{ Str::limit($testimoni->isi_testimoni, 50) }}</td>
                                <td>
                                    @if($testimoni->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.testimonis.edit', $testimoni) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @if($testimoni->is_active)
                                        <form action="{{ route('admin.testimonis.toggle-status', $testimoni) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Nonaktifkan Testimoni">
                                                <i class="fas fa-eye-slash"></i> Nonaktifkan
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.testimonis.toggle-status', $testimoni) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="Aktifkan Testimoni">
                                                <i class="fas fa-eye"></i> Aktifkan
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.testimonis.destroy', $testimoni) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada testimoni</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
