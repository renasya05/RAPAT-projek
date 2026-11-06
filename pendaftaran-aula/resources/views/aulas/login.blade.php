<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | RAPAT</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-rapat.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            min-height: 100vh;
            overflow: hidden;
        }

        /* =========================
           HALAMAN LOGIN
        ========================= */

        .login-page {
            min-height: 100vh;
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 50px 8%;

            position: relative;

            background-image:
                linear-gradient(
                    90deg,
                    rgba(7, 27, 47, 0.82),
                    rgba(7, 27, 47, 0.55),
                    rgba(7, 27, 47, 0.25)
                ),
                url('{{ asset('images/login-bg.jpg') }}');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* =========================
           BAGIAN KIRI
        ========================= */

        .welcome-section {
            width: 52%;
            max-width: 650px;
            color: white;
            z-index: 2;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 3px;
            margin-bottom: 20px;
        }

        .line {
            width: 75px;
            height: 5px;
            background: white;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .welcome-section h1 {
            font-size: 48px;
            line-height: 1.15;
            font-weight: 800;
            margin-bottom: 22px;
        }

        .welcome-section p {
            max-width: 540px;
            font-size: 19px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.94);
        }

        /* =========================
           KARTU LOGIN
        ========================= */

        .login-card {
            width: 440px;
            background: rgba(255, 255, 255, 0.97);

            border-radius: 24px;

            padding: 42px;

            box-shadow:
                0 25px 70px rgba(0, 0, 0, 0.35);

            z-index: 3;
        }

        .login-header {
            margin-bottom: 28px;
        }

        .login-header h2 {
            color: #12355b;
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #667085;
            font-size: 16px;
            line-height: 1.5;
        }

        /* =========================
           ALERT
        ========================= */

        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-danger {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        .alert-success {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #263238;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            height: 54px;

            border: 1px solid #d5dbe2;
            border-radius: 11px;

            padding: 0 16px;

            background: white;

            font-family: inherit;
            font-size: 16px;

            outline: none;

            transition: all 0.2s ease;
        }

        .form-group input:focus {
            border-color: #12355b;

            box-shadow:
                0 0 0 3px rgba(18, 53, 91, 0.10);
        }

        .form-group input::placeholder {
            color: #9aa3ad;
        }

        /* =========================
           BUTTON
        ========================= */

        .login-button {
            width: 100%;
            height: 55px;

            border: none;
            border-radius: 11px;

            background: #12355b;
            color: white;

            font-family: inherit;
            font-size: 17px;
            font-weight: 700;

            cursor: pointer;

            margin-top: 5px;

            transition: all 0.2s ease;
        }

        .login-button:hover {
            background: #0d2947;
            transform: translateY(-1px);
        }

        /* =========================
           REGISTER
        ========================= */

        .register-text {
            text-align: center;

            margin-top: 24px;

            color: #667085;
            font-size: 15px;
        }

        .register-text a {
            color: #12355b;
            font-weight: 700;
            text-decoration: none;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        /* =========================
           ERROR
        ========================= */

        .error-text {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        /* =========================
           TABLET
        ========================= */

        @media (max-width: 950px) {

            body {
                overflow-y: auto;
            }

            .login-page {
                flex-direction: column;
                justify-content: center;
                gap: 35px;

                padding: 45px 25px;

                min-height: 100vh;
            }

            .welcome-section {
                width: 100%;
                max-width: 650px;
                text-align: center;
            }

            .line {
                margin-left: auto;
                margin-right: auto;
            }

            .welcome-section h1 {
                font-size: 38px;
            }

            .welcome-section p {
                margin: auto;
                font-size: 17px;
            }

            .login-card {
                width: min(440px, 100%);
            }
        }

        /* =========================
           HP
        ========================= */

        @media (max-width: 500px) {

            .login-page {
                padding: 30px 18px;
            }

            .brand {
                font-size: 20px;
            }

            .welcome-section h1 {
                font-size: 30px;
            }

            .welcome-section p {
                font-size: 15px;
            }

            .login-card {
                padding: 30px 24px;
                border-radius: 20px;
            }

            .login-header h2 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

    <div class="login-page">

        <!-- =========================
             BAGIAN KIRI
        ========================== -->

        <div class="welcome-section">

            <div class="brand">
                <img
                    src="{{ asset('images/logo-sapa.svg') }}"
                    alt=""
                    width="48"
                    height="48"
                >
                RAPAT
            </div>

            <div class="line"></div>

            <p>Selamat Datang

            <h1>
                Sistem Aplikasi<br>
                Pemakaian Aula
            </h1>

            <p>
                Kelola pendaftaran dan pemakaian aula
                dengan mudah, cepat, dan terorganisir.
            </p>

        </div>


        <!-- =========================
             FORM LOGIN
        ========================== -->

        <div class="login-card">

            <div class="login-header">

                <h2>
                    Selamat Datang
                </h2>

                <p>
                    Silakan masuk untuk melanjutkan ke sistem.
                </p>

            </div>


            {{-- PESAN BERHASIL --}}

            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            {{-- PESAN ERROR --}}

            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            {{-- VALIDATION ERROR --}}

            @if($errors->any())

                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>

            @endif


            <form
                method="POST"
                action="{{ route('login.process') }}"
            >

                @csrf


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                        autofocus
                    >

                    @error('email')

                        <div class="error-text">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >

                    @error('password')

                        <div class="error-text">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- BUTTON -->

                <button
                    type="submit"
                    class="login-button"
                >
                    Masuk
                </button>

            </form>


            <!-- REGISTER -->

            <div class="register-text">

                Belum memiliki akun?

                <a href="{{ route('register') }}">
                    Daftar sekarang
                </a>

            </div>

        </div>

    </div>

</body>

</html>