<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'RAPAT')</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-rapat.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/rapat.css') }}">
</head>


<body>

    <div class="auth-page">

        {{-- =====================================================
             PANEL KIRI: IDENTITAS APLIKASI
        ====================================================== --}}

            <div class="auth-hero-photos" aria-hidden="true">
                <div class="auth-photo auth-photo-large">
                    <img src="{{ asset('images/aula besar aula kecil.jpg') }}" alt="">
                    <span>Aula Besar</span>
                </div>
            </div>

            <div class="auth-brand">

                <img
                    class="auth-logo"
                    src="{{ asset('images/logo-rapat.jpg') }}"
                    alt=""
                    width="52"
                    height="52"
                >

                <span class="auth-brand-text">
                    <span>RAPAT</span>
                    <span>REGISTRASI ADMINISTRASI PENGGUNAAN AULA TERKONTROL</span>
                </span>

            </div>


            @hasSection('hero_title')

                <div class="auth-hero-body">

                    <h1>
                        @yield('hero_title')
                    </h1>

                    @hasSection('hero_text')

                        <p>
                            @yield('hero_text')
                        </p>

                    @endif

                    @hasSection('hero_list')

                        <ul class="auth-list">

                            @yield('hero_list')

                        </ul>

                    @endif

                </div>

            @endif

            <p class="auth-footer">
                &copy; {{ date('Y') }} SIMPAULA &mdash; Diskominfo
            </p>

        </section>


        {{-- =====================================================
             PANEL KANAN: FORMULIR
        ====================================================== --}}

        <main class="auth-panel">

            <div class="auth-card">

                @yield('content')

            </div>

        </main>

    </div>

</body>

</html>
