@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Testimoni</h1>
        <a href="{{ route('admin.testimonis.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Testimoni</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.testimonis.update', $testimoni) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $testimoni->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan', $testimoni->jabatan) }}">
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="isi_testimoni">Isi Testimoni <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('isi_testimoni') is-invalid @enderror" id="isi_testimoni" name="isi_testimoni" rows="4" required>{{ old('isi_testimoni', $testimoni->isi_testimoni) }}</textarea>
                            @error('isi_testimoni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control-file @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            @if($testimoni->foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $testimoni->foto) }}" alt="{{ $testimoni->nama }}" class="rounded-circle" width="100" height="100">
                                    <p class="mt-1">Foto saat ini</p>
                                </div>
                            @endif
                        </div>



                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.testimonis.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
