@extends('layouts.app')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Toko</h1>
    <a href="{{ route('member.tokos.index') }}" class="btn btn-sm btn-secondary shadow-sm">
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

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-warning text-white">
                <h6 class="m-0 font-weight-bold">Form Edit Toko</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('member.tokos.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="nama_toko">Nama Toko <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" id="nama_toko" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko) }}" required>
                        @error('nama_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi">Deskripsi Toko</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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

                    <div class="form-group mb-3">
                        <label for="kontak_toko">Kontak Toko <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kontak_toko') is-invalid @enderror" id="kontak_toko" name="kontak_toko" value="{{ old('kontak_toko', $toko->kontak_toko) }}" required>
                        @error('kontak_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="alamat">Alamat Toko <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $toko->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Toko
                        </button>
                        <a href="{{ route('member.tokos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
