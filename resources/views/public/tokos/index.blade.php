@extends('layouts.app')
@section('content')

<style>
:root {
    --primary: #EE6983;
    --primary-dark: #d45b72;
    --soft-bg: #fff7f9;
    --radius: 14px;
    --border: #f1d7dd;
}

/* WRAPPER */
.store-card {
    display: flex;
    align-items: center;
    background: #fff;
    padding: 18px 20px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: .2s ease;
}

.store-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

/* STORE IMAGE */
.store-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 20px;
    background: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
}

.store-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* STORE MAIN INFO */
.store-main {
    flex: 1;
}

.store-name {
    font-size: 1.15rem;
    font-weight: 800;
    margin: 0;
    color: #333;
}

.store-sub-info {
    margin-top: 4px;
    display: flex;
    gap: 18px;
    font-size: .9rem;
}

.store-sub-info span {
    color: #666;
}

/* BUTTON AREA */
.store-actions {
    display: flex;
    gap: 10px;
}

/* BUTTON CHAT */
.btn-chat {
    background: #25D366 !important;  /* Hijau WhatsApp */
    border: 1px solid #1ebe59;       /* Hijau lebih gelap */
    color: #ffffff;                  /* Tulisan putih */
    padding: 8px 14px;
    font-weight: 700;
    border-radius: 8px;
    transition: 0.2s;
}

.btn-chat:hover {
    background: #1ebe59;  /* Hijau gelap */
    color: #ffffff;
}


/* BUTTON VISIT */
.btn-visit {
    background: var(--primary);
    border-radius: 8px;
    color: white;
    padding: 8px 14px;
    font-weight: 700;
}

.btn-visit:hover {
    background: var(--primary-dark);
}

/* RESPONSIVE */
@media(max-width: 768px) {
    .store-card {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .store-avatar {
        margin-right: 0;
    }

    .store-actions {
        width: 100%;
        justify-content: center;
    }
}
</style>


<div class="container py-4">
    <h1 class="mb-4 fw-bold" style="font-size: 1.8rem;">Semua Toko</h1>

    <div class="row gy-3">
        @forelse($tokos as $toko)
        <div class="col-12">

            <div class="store-card">

                {{-- Avatar --}}
                <div class="store-avatar">
                    @if($toko->gambar)
                        <img src="{{ asset('storage/tokos/' . $toko->gambar) }}">
                    @else
                        <i class="fas fa-store fa-2x text-muted"></i>
                    @endif
                </div>

                {{-- Main --}}
                <div class="store-main">
                    <h4 class="store-name">{{ $toko->nama_toko }}</h4>

                    <div class="store-sub-info">
                        <span>{{ $toko->produks->count() }} Produk</span>
                        <span>• {{ Str::limit($toko->alamat) }}</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="store-actions">

                    <a href="{{ route('public.tokos.show', $toko->id_toko) }}" class="btn-visit">
                        <i class="fas fa-store"></i> Kunjungi
                    </a>

                    @if($toko->kontak_toko)
                    <a href="https://wa.me/{{ $toko->kontak_toko }}" class="btn-chat" target="_blank">
                        <i class="fab fa-whatsapp"></i> Chat
                    </a>
                    @endif

                </div>
            </div>

        </div>

        @empty
        <div class="col-12 text-center">
            <div class="p-5 bg-white rounded-3 shadow-sm">
                <i class="fas fa-store-slash fa-4x text-muted mb-3"></i>
                <h5 class="fw-bold">Belum ada toko</h5>
                <p class="text-muted">Belum ada toko yang terdaftar saat ini.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($tokos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $tokos->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@endsection
