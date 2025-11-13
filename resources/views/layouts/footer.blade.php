<footer class="bg-light text-dark pt-5 pb-3 mt-5 border-top">
    <div class="container">
        <div class="row">
            <!-- Tentang -->
            <div class="col-md-4 mb-4">
                <h5 class="text-success font-weight-bold">Tentang MarShop</h5>
                <p class="small text-muted">
                    MarShop adalah platform marketplace sederhana untuk menampilkan produk, toko, dan transaksi via WhatsApp.
                    Mudah digunakan dan cocok untuk UMKM maupun individu yang ingin berjualan online.
                </p>
            </div>

            <!-- Navigasi Cepat -->
            <div class="col-md-4 mb-4">
                <h5 class="text-success font-weight-bold">Navigasi Cepat</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-dark text-decoration-none">🏠 Beranda</a></li>
                    <li><a href="{{ route('public.produks.index') }}" class="text-dark text-decoration-none">🛒 Produk</a></li>
                    <li><a href="{{ route('public.tokos.index') }}" class="text-dark text-decoration-none">🏪 Toko</a></li>
                    <li><a href="#" class="text-dark text-decoration-none">💬 Transaksi</a></li>
                    <li><a href="{{ route('login') }}" class="text-dark text-decoration-none">🔑 Login</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-md-4 mb-4">
                <h5 class="text-success font-weight-bold">Hubungi Kami</h5>
                <p class="small text-muted mb-1">
                    <i class="fas fa-map-marker-alt"></i> Bandung, Indonesia
                </p>
                <p class="small text-muted mb-1">
                    <i class="fas fa-envelope"></i> support@marshop.com
                </p>
                <p class="small text-muted mb-1">
                    <i class="fas fa-phone"></i> +62 812 3456 7890
                </p>

                <!-- Ikon Sosial -->
                <div class="mt-3">
                    <a href="#" class="text-success mr-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-success mr-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-success mr-3"><i class="fab fa-whatsapp fa-lg"></i></a>
                </div>
            </div>
        </div>

        <hr>
        <div class="text-center small text-muted">
            &copy; {{ date('Y') }} <strong>MarShop</strong>. Semua Hak Dilindungi.
        </div>
    </div>
</footer>
<style>
    footer a:hover {
    color: #28a745 !important;
    text-decoration: underline;
}
</style>
