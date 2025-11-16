@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold text-primary mb-3">Testimoni Pelanggan</h1>
        <p class="lead text-muted">Apa kata pelanggan kami tentang pengalaman berbelanja di marketplace ini</p>
    </div>

    @if($testimonis->count() > 0)
        <!-- Testimoni Grid -->
        <div class="row justify-content-center">
            @foreach($testimonis as $testimoni)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card testimonial-card h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <!-- Avatar -->
                            <div class="mb-3">
                                @if($testimoni->foto)
                                    <img src="{{ asset('storage/' . $testimoni->foto) }}" alt="{{ $testimoni->nama }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 4px solid rgba(255,255,255,0.3);">
                                @else
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; border: 4px solid rgba(255,255,255,0.3);">
                                        <i class="fas fa-user text-primary fa-2x"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Quote Icon -->
                            <div class="mb-3">
                                <i class="fas fa-quote-left fa-2x text-white-50"></i>
                            </div>

                            <!-- Testimoni Text -->
                            <p class="card-text mb-4 flex-grow-1" style="font-style: italic; font-size: 15px; line-height: 1.6;">
                                "{{ Str::limit($testimoni->isi_testimoni, 200) }}"
                            </p>

                            <!-- Name and Position -->
                            <div class="mt-auto">
                                <h6 class="card-title mb-1 font-weight-bold">{{ $testimoni->nama }}</h6>
                                @if($testimoni->jabatan)
                                    <p class="text-white-50 small mb-0">{{ $testimoni->jabatan }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $testimonis->links() }}
        </div>

    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="empty-state-card mx-auto" style="max-width: 500px;">
                <div class="empty-state-content">
                    <i class="fas fa-comments fa-4x text-muted mb-4"></i>
                    <h3 class="empty-state-title">Belum Ada Testimoni</h3>
                    <p class="empty-state-text">Testimoni pelanggan akan segera ditampilkan di sini.</p>
                    <a href="{{ route('home') }}" class="btn btn-market">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* =======================================
        TESTIMONI PAGE STYLES
    ======================================== */
    :root {
        --primary: #6C63FF;
        --primary-dark: #5852d6;
        --text-dark: #2B2B2B;
        --text-light: #6D6D6D;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .testimonial-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .testimonial-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        border-radius: 20px;
        z-index: 1;
    }

    .testimonial-card .card-body {
        position: relative;
        z-index: 2;
    }

    .empty-state-card {
        background: white;
        border-radius: 20px;
        padding: 60px 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .empty-state-title {
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 15px;
    }

    .empty-state-text {
        color: var(--text-light);
        font-size: 16px;
        margin-bottom: 25px;
    }

    .btn-market {
        background-color: var(--primary);
        color: #fff;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 10px;
        transition: 0.3s;
        border: none;
    }

    .btn-market:hover {
        background-color: var(--primary-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
    }

    /* Pagination Styles */
    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        color: var(--primary);
        border-color: var(--primary);
        border-radius: 8px !important;
        margin: 0 2px;
        transition: 0.3s;
    }

    .page-link:hover {
        color: white;
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }

        .testimonial-card {
            margin-bottom: 20px;
        }

        .empty-state-card {
            padding: 40px 20px;
        }
    }
</style>
@endsection
