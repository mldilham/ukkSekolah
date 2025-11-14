<footer class="footer-premium pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row">

            <!-- Brand -->
            <div class="col-md-4 mb-4">
                <h4 class="footer-brand">
                    <i class="fas fa-store"></i> MarShop
                </h4>
                <p class="footer-desc">
                    Platform marketplace modern untuk menampilkan produk, toko, dan transaksi via WhatsApp,
                    dengan tampilan premium dan mudah digunakan.
                </p>
            </div>

            <!-- Menu -->
            <div class="col-md-4 mb-4">
                <h5 class="footer-heading">Navigasi</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ route('public.produks.index') }}">Produk</a></li>
                    <li><a href="{{ route('public.tokos.index') }}">Toko</a></li>
                    <li><a href="#">Transaksi</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-4 mb-4">
                <h5 class="footer-heading">Kontak</h5>

                <p class="footer-info"><i class="fas fa-map-marker-alt"></i> Bandung, Indonesia</p>
                <p class="footer-info"><i class="fas fa-envelope"></i> support@marshop.com</p>
                <p class="footer-info"><i class="fas fa-phone"></i> +62 812 3456 7890</p>

                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

        </div>

        <hr class="footer-divider">

        <div class="text-center footer-copy">
            &copy; {{ date('Y') }} <strong>MarShop</strong>. Semua Hak Dilindungi.
        </div>
    </div>
</footer>

<style>
    :root {
        --primary: #6C63FF;
        --primary-dark: #5751d8;
        --text-dark: #2B2B2B;
        --soft-bg: #F4F3FF;
    }

    .footer-premium {
        background: #ffffff;
        border-top: 1px solid #eee;
        color: var(--text-dark);
    }

    .footer-brand {
        font-weight: 700;
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .footer-desc {
        font-size: 0.9rem;
        opacity: 0.75;
        line-height: 1.6;
    }

    .footer-heading {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 16px;
    }

    /* Links */
    .footer-links {
        list-style: none;
        padding: 0;
    }
    .footer-links li {
        margin-bottom: 8px;
    }
    .footer-links a {
        text-decoration: none;
        color: var(--text-dark);
        transition: 0.25s ease;
        padding-left: 0;
    }
    .footer-links a:hover {
        color: var(--primary);
        padding-left: 6px;
    }

    /* Contact */
    .footer-info {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-bottom: 6px;
    }

    /* Social Icons */
    .footer-social a {
        color: var(--primary);
        margin-right: 15px;
        font-size: 1.3rem;
        transition: 0.25s;
    }
    .footer-social a:hover {
        color: var(--primary-dark);
        transform: translateY(-3px);
    }

    .footer-divider {
        border-color: rgba(0,0,0,0.1);
    }

    .footer-copy {
        font-size: 0.85rem;
        opacity: 0.75;
    }
</style>
