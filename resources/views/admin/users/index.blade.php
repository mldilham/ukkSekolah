@extends('admin.layouts.app')
@section('content')
    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Success Alert for User Actions -->
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

    <!-- Error Alert for User Actions -->
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
        <h1 class="h3 mb-0 text-gray-800">Manajemen Users</h1>
        <a href="{{ route('admin.users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah User
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id_user }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->kontak }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : 'info' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                @if($user->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($user->status == 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($user->status == 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status == 'pending')
                                    <form action="{{ route('admin.users.approve', $user->id_user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui user ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.reject', $user->id_user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak user ini?')">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.users.edit', $user->id_user) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id_user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
