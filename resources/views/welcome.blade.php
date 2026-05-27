<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobiTravel — Daftar Agen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest: #1a3328;
            --moss: #2d5a3d;
            --sage: #4e8060;
            --cream: #f5f0e8;
            --ivory: #faf8f3;
            --sand: #e8dfc8;
            --gold: #e8a83e;
            --charcoal: #1c1c1c;
            --ink: #2e2e2e;
            --muted: #7a7a6e;
            --font-display: 'Playfair Display', Georgia, serif;
            --font-body: 'DM Sans', sans-serif;
            --font-mono: 'DM Mono', monospace;
            --ease-smooth: cubic-bezier(.25,.46,.45,.94);
            --ease-bounce: cubic-bezier(.34,1.56,.64,1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background: var(--ivory);
            color: var(--ink);
            overflow-x: hidden;
        }

        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 4rem;
            background: rgba(245,240,232,.92);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 rgba(0,0,0,.08);
        }

        .nav__logo {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--forest);
            letter-spacing: -.02em;
        }
        .nav__logo span { color: var(--gold); }

        .nav__links {
            display: flex;
            gap: 2.5rem;
            list-style: none;
        }

        .nav__links a {
            font-size: .875rem;
            font-weight: 500;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--ink);
            transition: color .2s;
        }
        .nav__links a:hover { color: var(--gold); }

        .nav__cta {
            background: var(--gold);
            color: var(--forest) !important;
            padding: .5rem 1.25rem;
            border-radius: 2rem;
            font-weight: 700 !important;
            transition: transform .2s var(--ease-bounce), background .2s !important;
        }
        .nav__cta:hover { background: var(--terra); transform: translateY(-2px); }

        .hero {
            min-height: 60vh;
            display: flex;
            align-items: center;
            background: linear-gradient(160deg, rgba(26,51,40,.85) 0%, rgba(45,90,61,.5) 55%, rgba(26,51,40,.8) 100%);
            padding: 8rem 4rem 4rem;
        }

        .hero__content {
            max-width: 900px;
        }

        .hero__title {
            font-family: var(--font-display);
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 900;
            color: var(--cream);
            letter-spacing: -.03em;
            margin-bottom: 1rem;
        }
        .hero__title em { font-style: italic; color: var(--gold); }

        .hero__sub {
            font-size: 1rem;
            line-height: 1.7;
            color: rgba(245,240,232,.8);
            max-width: 500px;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .875rem 2rem;
            border-radius: 3rem;
            font-weight: 600;
            font-size: .9375rem;
            cursor: pointer;
            transition: transform .2s var(--ease-bounce), box-shadow .2s, background .2s;
            border: none;
            text-decoration: none;
        }
        .btn--primary { background: var(--gold); color: var(--forest); }
        .btn--primary:hover {
            background: var(--terra);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(200,120,40,.35);
        }

        .how {
            background: var(--cream);
            padding: 5rem 4rem;
            text-align: center;
        }

        .section-tag {
            font-family: var(--font-mono);
            font-size: .75rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--sage);
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: .75rem;
        }
        .section-tag::before {
            content: '';
            display: inline-block;
            width: 2rem;
            height: 1px;
            background: var(--sage);
        }
        .section-tag::after {
            content: '';
            display: inline-block;
            width: 2rem;
            height: 1px;
            background: var(--sage);
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 900;
            letter-spacing: -.02em;
            color: var(--forest);
            line-height: 1.1;
            margin-bottom: 3rem;
        }
        .section-title em { font-style: italic; color: var(--terra); }

        .how__steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .step {
            text-align: center;
        }

        .step__num {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            background: var(--ivory);
            border: 2px solid var(--sage);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--forest);
            transition: background .3s, transform .3s var(--ease-bounce);
        }
        .step:hover .step__num {
            background: var(--forest);
            color: var(--cream);
            transform: scale(1.1);
        }

        .step__title {
            font-family: var(--font-display);
            font-size: 1.0625rem;
            font-weight: 700;
            color: var(--forest);
            margin-bottom: .5rem;
        }

        .step__desc {
            font-size: .875rem;
            color: var(--muted);
            line-height: 1.65;
        }

        .cta-banner {
            background: linear-gradient(135deg, rgba(26,51,40,.92) 0%, rgba(45,90,61,.85) 100%), url('https://images.unsplash.com/photo-1588392382834-a891154bca4d?w=1400&q=80') center/cover;
            text-align: center;
            padding: 5rem 4rem;
        }

        .cta-banner__title {
            font-family: var(--font-display);
            font-size: clamp(1.5rem, 3vw, 2.5rem);
            font-weight: 900;
            color: var(--cream);
            margin-bottom: 1rem;
        }
        .cta-banner__title em { color: var(--gold); }
        .cta-banner__sub {
            font-size: 1rem;
            color: rgba(245,240,232,.7);
            max-width: 480px;
            margin: 0 auto 2rem;
        }

        .footer {
            background: var(--charcoal);
            padding: 3rem 4rem;
            text-align: center;
        }
        .footer__logo {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--cream);
            margin-bottom: 1rem;
        }
        .footer__logo span { color: var(--gold); }
        .footer__copyright {
            font-size: .8rem;
            color: rgba(255,255,255,.3);
        }

        @media (max-width: 1024px) {
            .nav { padding: 1rem 2rem; }
            .hero { padding: 7rem 2rem 3rem; }
            .how { padding: 3rem 2rem; }
            .how__steps { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
            .cta-banner { padding: 3rem 2rem; }
            .footer { padding: 2rem; }
        }

        @media (max-width: 640px) {
            .nav__links { display: none; }
            .how__steps { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="nav">
        <div class="nav__logo">Mobi<span>Travel</span></div>
        <ul class="nav__links">
            <li><a href="#how">Cara Jadi Agen</a></li>
            <li><a href="#daftar">Daftar Agen</a></li>
            <li><a href="{{ route('agen.login') }}" class="nav__cta">Login Agen</a></li>
        </ul>
    </nav>

    {{-- ===== HERO ===== --}}
    <section class="hero">
        <div class="hero__content">
            <h1 class="hero__title">
                Daftar Jadi Agen<br>
                <em>MobiTravel</em>
            </h1>
            <p class="hero__sub">
                Bergabunglah dengan ribuan agen travel lokal terpercaya di seluruh Indonesia. 
                Jangkau lebih banyak pelanggan dan kembangkan bisnismu bersama kami.
            </p>
            <a href="{{ route('agen.register') }}" class="btn btn--primary">Daftar Agen Gratis →</a>
        </div>
    </section>

    {{-- ===== 4 LANGKAH MENJADI AGEN ===== --}}
    <section class="how" id="how">
        <div class="section-tag">Mulai Sekarang</div>
        <h2 class="section-title"><em>4 Langkah</em> Menjadi Agen</h2>
        <div class="how__steps">
            <div class="step">
                <div class="step__num">01</div>
                <div class="step__title">Daftar Akun</div>
                <p class="step__desc">Isi formulir pendaftaran agen dengan data lengkap dan upload dokumen yang diperlukan.</p>
            </div>
            <div class="step">
                <div class="step__num">02</div>
                <div class="step__title">Verifikasi Admin</div>
                <p class="step__desc">Tim admin akan memverifikasi data dan dokumen yang kamu kirimkan.</p>
            </div>
            <div class="step">
                <div class="step__num">03</div>
                <div class="step__title">Kelola Layanan</div>
                <p class="step__desc">Tambahkan destinasi, paket wisata, kendaraan, dan tentukan harga layananmu.</p>
            </div>
            <div class="step">
                <div class="step__num">04</div>
                <div class="step__title">Mulai Terima Pesanan</div>
                <p class="step__desc">Terima pesanan dari pelanggan dan kelola perjalanan dari dashboard agen.</p>
            </div>
        </div>
    </section>

    {{-- ===== CTA BANNER ===== --}}
    <section class="cta-banner" id="daftar">
        <div class="cta-banner__title">Punya Usaha Travel Lokal? <em>Bergabung bersama Kami</em></div>
        <p class="cta-banner__sub">Daftarkan agen travelmu dan jangkau ribuan pelanggan baru. Gratis pendaftaran, mudah dikelola, dan didukung tim MobiTravel.</p>
        <a href="{{ route('agen.register') }}" class="btn btn--primary">Daftar Agen Gratis →</a>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer">
        <div class="footer__logo">Mobi<span>Travel</span></div>
        <div class="footer__copyright">© {{ date('Y') }} MobiTravel. Hak cipta dilindungi.</div>
    </footer>

</body>
</html>