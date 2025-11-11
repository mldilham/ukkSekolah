@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Toko</h1>
        <a href="{{ route('admin.tokos.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Toko</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tokos.update', $toko->id_toko) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_toko">Nama Toko</label>
                            <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" id="nama_toko" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko) }}" required>
                            @error('nama_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="form-group">
                            <label for="gambar">Logo / Banner Toko</label>
                            <input type="file" class="form-control-file @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                            @error('gambar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            @if($toko->gambar)
                                <div class="mt-2">
                                    <p>Gambar saat ini:</p>
                                    <img src="{{ asset('storage/tokos/' . $toko->gambar) }}" alt="Gambar Toko" class="img-thumbnail" width="150">
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="id_user">Pemilik Toko</label>
                            <select class="form-control @error('id_user') is-invalid @enderror" id="id_user" name="id_user" required>
                                <option value="">Pilih Pemilik</option>
                                @foreach($users as $user)
                                    @php
                                        $hasToko = $user->tokos()->where('id_toko', '!=', $toko->id_toko)->exists();
                                    @endphp
                                    <option value="{{ $user->id_user }}" {{ old('id_user', $toko->id_user) == $user->id_user ? 'selected' : '' }} {{ $hasToko ? 'disabled' : '' }}>
                                        {{ $user->nama }} ({{ $user->username }})
                                        @if($hasToko)
                                            - Sudah memiliki toko lain
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">User yang sudah memiliki toko lain akan dinonaktifkan dalam pilihan ini.</small>
                        </div>

                        <div class="form-group">
                            <label for="kontak_toko">Kontak Toko</label>
                            <input type="text" class="form-control @error('kontak_toko') is-invalid @enderror" id="kontak_toko" name="kontak_toko" value="{{ old('kontak_toko', $toko->kontak_toko) }}" required>
                            @error('kontak_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $toko->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.tokos.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
