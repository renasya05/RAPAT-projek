<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar | RAPAT</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-rapat.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    {{--
        Halaman ini BERDIRI SENDIRI: tidak memakai layouts/auth dan tidak
        bergantung pada public/css/rapat.css. Semua class memakai awalan "lg-"
        supaya tidak bentrok dengan CSS lain.
    --}}
    <style>

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;

            font-family: 'Source Sans 3', system-ui, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #1f2c45;

            background: #f3f7fc;
        }

        h1,
        h2,
        .lg-label,
        .lg-btn {
            font-family: 'Lexend', system-ui, sans-serif;
        }

        img {
            display: block;
            max-width: 100%;
        }

        /* =====================================================
           KERANGKA DUA KOLOM
        ===================================================== */

        .lg-page {
            display: grid;
            grid-template-columns: 1.15fr 1fr;

            min-height: 100vh;
        }

        /* =====================================================
           PANEL KIRI (HERO)
        ===================================================== */

        .lg-hero {
            position: relative;
            overflow: hidden;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 32px;

            padding: 48px 56px;

            color: #ffffff;

            background: #122a5e;
        }

        /*
           LATAR FOTO DIAGONAL (dengan aksen biru tipis, lihat .lg-bg::after)
           Aula Kecil di sisi kiri-atas, Aula Besar di sisi kanan-bawah,
           dibelah garis diagonal.
        */
        .lg-bg {
            position: absolute;
            inset: 0;
            z-index: 0;

            /* satu foto kolase aula (garis diagonal sudah ada di fotonya) */
            background: url('{{ asset('images/aula-besar-aula-kecil-new.jpg') }}') center / cover no-repeat;
        }

        /*
           AKSEN BIRU di atas foto supaya tulisan lebih mudah dibaca.
           Lebih pekat di kiri (tempat judul dan logo) dan di bawah
           (tempat teks hak cipta), makin tipis ke kanan supaya foto
           tetap terlihat. Ubah angka alpha (0.42, 0.28, dst.) untuk
           membuat biru lebih tebal atau lebih tipis.
        */
        .lg-bg::after {
            content: "";
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    to bottom,
                    rgba(18, 42, 94, 0.40) 0%,
                    rgba(18, 42, 94, 0) 22%,
                    rgba(18, 42, 94, 0) 72%,
                    rgba(18, 42, 94, 0.45) 100%
                ),
                linear-gradient(
                    to right,
                    rgba(18, 42, 94, 0.42) 0%,
                    rgba(18, 42, 94, 0.28) 55%,
                    rgba(18, 42, 94, 0.08) 100%
                );
        }

        .lg-hero > .lg-bg {
            position: absolute;
        }

        .lg-hero > *:not(.lg-bg) {
            position: relative;
            z-index: 2;
        }

        /* ---------- brand ---------- */

        .lg-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .lg-brand img {
            flex: none;

            width: 52px;
            height: 52px;
        }

        .lg-brand-text {
            display: flex;
            flex-direction: column;
            gap: 2px;

            font-family: 'Lexend', system-ui, sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            line-height: 1.5;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #ffffff;
            text-shadow: 0 1px 3px rgba(2, 8, 23, 0.9), 0 2px 14px rgba(2, 8, 23, 0.8);
        }

        /* ---------- judul + tagline ---------- */

        .lg-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 18px;

            flex: 1;
        }

        .lg-title {
            max-width: 560px;

            font-size: clamp(1.6rem, 2.4vw, 2.3rem);
            font-weight: 700;
            line-height: 1.2;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(2, 8, 23, 0.9), 0 4px 24px rgba(2, 8, 23, 0.85);
        }

        .lg-title span {
            display: block;
        }

        .lg-tagline {
            max-width: 38ch;

            font-size: clamp(1rem, 1.3vw, 1.2rem);
            line-height: 1.5;
            color: #ffffff;
            text-shadow: 0 1px 4px rgba(2, 8, 23, 0.9), 0 2px 16px rgba(2, 8, 23, 0.8);
        }

        .lg-points {
            display: grid;
            gap: 10px;

            list-style: none;

            color: #ffffff;
            text-shadow: 0 1px 4px rgba(2, 8, 23, 0.9), 0 2px 16px rgba(2, 8, 23, 0.8);
        }

        .lg-points li {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lg-points li::before {
            content: "\2713";

            display: grid;
            place-items: center;
            flex: none;

            width: 22px;
            height: 22px;

            font-size: 13px;
            font-weight: 700;
            color: #ffffff;

            background: rgba(255, 255, 255, 0.22);
            border-radius: 999px;
            text-shadow: none;
        }

        /* ---------- footer ---------- */

        .lg-footer {
            font-size: 14px;
            color: #ffffff;
            text-shadow: 0 1px 3px rgba(2, 8, 23, 0.9), 0 2px 12px rgba(2, 8, 23, 0.8);
        }

        /* =====================================================
           PANEL KANAN (FORM)
        ===================================================== */

        .lg-panel {
            display: grid;
            place-items: center;

            padding: 56px 40px;

            background: #f3f7fc;
        }

        .lg-card {
            width: min(460px, 100%);

            padding: 40px 42px;

            background: #ffffff;
            border: 1px solid #e3ebf6;
            border-radius: 18px;
            box-shadow:
                0 32px 60px -28px rgba(15, 35, 95, 0.45),
                0 8px 20px -12px rgba(15, 35, 95, 0.25);
        }

        .lg-card h2 {
            margin-bottom: 6px;

            font-size: 1.45rem;
            font-weight: 700;
            color: #17315f;
        }

        .lg-card .lg-sub {
            margin-bottom: 22px;

            color: #5b6b85;
        }

        .lg-alert {
            margin-bottom: 16px;
            padding: 12px 14px;

            font-size: 15px;
            line-height: 1.5;

            border-radius: 10px;
        }

        .lg-alert-success {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #86efac;
        }

        .lg-alert-danger {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fca5a5;
        }

        .lg-group {
            margin-bottom: 18px;
        }

        .lg-label {
            display: block;

            margin-bottom: 8px;

            font-size: 14.5px;
            font-weight: 600;
            color: #17315f;
        }

        .lg-input {
            width: 100%;
            height: 48px;
            padding: 0 14px;

            font-family: inherit;
            font-size: 16px;
            color: #1f2c45;

            background: #ffffff;
            border: 1px solid #c9d8ec;
            border-radius: 10px;

            outline: none;

            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .lg-input::placeholder {
            color: #8494ab;
        }

        .lg-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.24);
        }

        .lg-error {
            display: block;

            margin-top: 6px;

            font-size: 14px;
            color: #dc2626;
        }

        .lg-btn {
            width: 100%;
            height: 48px;
            margin-top: 4px;

            font-size: 16px;
            font-weight: 600;
            color: #ffffff;

            background: #1e40af;
            border: none;
            border-radius: 10px;

            cursor: pointer;

            transition: background 0.15s ease;
        }

        .lg-btn:hover {
            background: #1a3699;
        }

        .lg-alt {
            margin-top: 18px;

            font-size: 15.5px;
            text-align: center;
            color: #5b6b85;
        }

        .lg-alt a {
            font-weight: 600;
            color: #1e40af;
        }

        /* =====================================================
           RESPONSIF
        ===================================================== */

        @media (max-width: 1100px) {

            .lg-hero {
                padding: 40px 34px;
            }

            .lg-panel {
                padding: 40px 24px;
            }
        }

        /* laptop berlayar pendek (mis. 1366x768 setelah dikurangi toolbar browser) */
        @media (min-width: 901px) and (max-height: 780px) {

            .lg-hero {
                gap: 18px;

                padding: 30px 48px;
            }

            .lg-body {
                gap: 14px;
            }

            .lg-panel {
                padding: 28px 32px;
            }
        }

        @media (max-width: 900px) {

            .lg-page {
                grid-template-columns: minmax(0, 1fr);
            }

            .lg-hero {
                gap: 22px;

                min-height: 460px;
                padding: 30px 22px 34px;
            }

            .lg-title {
                max-width: none;
            }

            .lg-footer {
                display: none;
            }

            .lg-panel {
                padding: 32px 18px 44px;
            }

            .lg-card {
                padding: 28px 22px;
            }
        }

        @media (max-width: 520px) {

            .lg-brand-text {
                font-size: 10.5px;
            }

            .lg-brand img {
                width: 44px;
                height: 44px;
            }
        }

    </style>

</head>

<body>

    <div class="lg-page">

        {{-- =====================================================
             PANEL KIRI: IDENTITAS + FOTO LATAR DIAGONAL
        ====================================================== --}}
        <section class="lg-hero">

            {{-- LATAR FOTO DIAGONAL --}}
            <div class="lg-bg" aria-hidden="true"></div>


            <div class="lg-brand">

                <img
                    src="{{ asset('images/logo-rapat.jpg') }}"
                    alt=""
                    width="52"
                    height="52"
                >


            <div class="lg-brand-text">
                    <span>RAPAT</span>
                    <span>REGISTRASI ADMINISTRASI PENGGUNAAN AULA TERKONTROL</span>
                </div>

            </div>


            <div class="lg-body">

                <h1 class="lg-title">
                    <span>Buat akun untuk mulai</span>
                    <span>mengajukan pemakaian aula</span>
                </h1>

                <h2 class="lg-tagline">
                    Akun RAPAT dipakai untuk mengajukan pemakaian aula
                    dan memantau status pengajuan Anda.
                </h2>

            </div>


            <p class="lg-footer">
                &copy; {{ date('Y') }} RAPAT &mdash; Diskominfo
            </p>

        </section>


        {{-- =====================================================
             PANEL KANAN: FORM DAFTAR
        ====================================================== --}}
        <main class="lg-panel">

            <div class="lg-card">

                <h2>Daftar akun</h2>

                <p class="lg-sub">
                    Lengkapi data berikut untuk membuat akun RAPAT.
                </p>

                {{-- PESAN BERHASIL --}}
                @if (session('success'))
                    <div class="lg-alert lg-alert-success" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- PESAN ERROR --}}
                @if (session('error'))
                    <div class="lg-alert lg-alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- VALIDASI --}}
                @if ($errors->any())
                    <div class="lg-alert lg-alert-danger" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.process') }}">

                    @csrf

                    <div class="lg-group">

                        <label class="lg-label" for="name">Nama Lengkap</label>

                        <input
                            class="lg-input"
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            autofocus
                        >

                        @error('name')
                            <span class="lg-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="lg-group">

                        <label class="lg-label" for="email">Email</label>

                        <input
                            class="lg-input"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            required
                        >

                        @error('email')
                            <span class="lg-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="lg-group">

                        <label class="lg-label" for="password">Password</label>

                        <input
                            class="lg-input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >

                        @error('password')
                            <span class="lg-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="lg-group">

                        <label class="lg-label" for="password_confirmation">Konfirmasi Password</label>

                        <input
                            class="lg-input"
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                        >

                    </div>

                    <button type="submit" class="lg-btn">
                        Buat Akun
                    </button>

                </form>

                <p class="lg-alt">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}">Masuk di sini</a>
                </p>

            </div>

        </main>

    </div>

</body>
</html>