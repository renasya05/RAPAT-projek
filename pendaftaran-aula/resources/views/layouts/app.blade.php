<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'RAPAT')</title>

    <meta
        name="description"
        content="RAPAT — REGISTRASI ADMINISTRASI PENGGUNAAN AULA TERKONTROL. Ajukan dan pantau pemakaian aula secara daring."
    >

    <meta name="theme-color" content="#1e40af">

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-rapat.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/rapat.css') }}">
</head>


@php
    $appUser  = auth()->user();
    $appAdmin = $appUser && $appUser->isAdmin();

    $appInitial = $appUser
        ? mb_strtoupper(mb_substr($appUser->name ?? 'U', 0, 1))
        : 'U';
@endphp


<body class="{{ $appAdmin ? 'is-admin' : 'is-user' }}{{ !$appAdmin && request()->routeIs('aulas', 'pendaftaran.create') ? ' is-full' : '' }}{{ !$appAdmin && request()->routeIs('aulas') ? ' is-aula-list' : '' }}">

    <a class="skip-link" href="#main">
        Lewati ke konten utama
    </a>

    @auth

        {{-- =====================================================
             OVERLAY (menutup sidebar saat navigasi mobile dibuka)
        ====================================================== --}}

        <div
            class="sidebar-overlay"
            data-nav-close
            aria-hidden="true"
        ></div>


        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}

        <aside class="sidebar" id="sidebar">

            {{-- BRAND --}}

            <div class="sidebar-brand">

                <a
                    href="{{ $appAdmin ? route('admin.dashboard') : route('dashboard') }}"
                    class="sidebar-brand-top"
                >

                    <img
                        class="sidebar-logo"
                        src="{{ asset('images/logo-rapat.svg') }}"
                        alt=""
                        width="40"
                        height="40"
                    >

                    <div class="sidebar-brand-text">

                        <strong class="sidebar-brand-title">
                            RAPAT
                        </strong>

                        <span>
                            REGISTRASI ADMINISTRASI PENGGUNAAN AULA TERKONTROL
                        </span>

                    </div>

                </a>

                <button
                    type="button"
                    class="sidebar-close"
                    data-nav-close
                    aria-label="Tutup menu navigasi"
                >
                    <x-icon name="x" size="18" />
                </button>

            </div>


            {{-- IDENTITAS PENGGUNA --}}

            <div class="sidebar-user">

                <span class="sidebar-user-avatar">
                    {{ $appInitial }}
                </span>

                <div class="sidebar-user-text">

                    <span class="sidebar-user-name">
                        {{ $appUser->name }}
                    </span>

                    <span class="sidebar-user-role">
                        {{ $appAdmin ? 'Administrator' : 'Pengguna' }}
                    </span>

                </div>

            </div>


            {{-- NAVIGATION --}}

            <nav class="sidebar-nav" aria-label="Menu utama">

                <div class="sidebar-section-title">
                    Menu Utama
                </div>


                @if($appAdmin)

                    {{-- ADMIN MENU --}}

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="dashboard" /></span>
                        <span>Dashboard Admin</span>
                    </a>


                    <a
                        href="{{ route('admin.pendaftaran.index') }}"
                        class="{{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}"
                        @if(request()->routeIs('admin.pendaftaran.*')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="history" /></span>
                        <span>Riwayat Pendaftaran</span>
                    </a>


                    <a
                        href="{{ route('admin.aulas.index') }}"
                        class="{{ request()->routeIs('admin.aulas*') ? 'active' : '' }}"
                        @if(request()->routeIs('admin.aulas*')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="building" /></span>
                        <span>Data Aula</span>
                    </a>


                    <a
                        href="{{ route('admin.struktur.index') }}"
                        class="{{ request()->routeIs('admin.struktur*') ? 'active' : '' }}"
                        @if(request()->routeIs('admin.struktur*')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="checklist" /></span>
                        <span>Struktur Organisasi</span>
                    </a>


                    <a
                        href="{{ route('admin.laporan') }}"
                        class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}"
                        @if(request()->routeIs('admin.laporan')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="chart" /></span>
                        <span>Laporan</span>
                    </a>

                @else

                    {{-- USER MENU --}}

                    <a
                        href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        @if(request()->routeIs('dashboard')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="dashboard" /></span>
                        <span>Dashboard</span>
                    </a>


                    <a
                        href="{{ route('aulas') }}"
                        class="{{ request()->routeIs('aulas') || request()->routeIs('pendaftaran.create') ? 'active' : '' }}"
                        @if(request()->routeIs('aulas') || request()->routeIs('pendaftaran.create')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="building" /></span>
                        <span>Daftar Aula</span>
                    </a>


                    <a
                        href="{{ route('pendaftaran.history') }}"
                        class="{{ request()->routeIs('pendaftaran.history*') || request()->routeIs('pendaftaran.show') ? 'active' : '' }}"
                        @if(request()->routeIs('pendaftaran.history*') || request()->routeIs('pendaftaran.show')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="history" /></span>
                        <span>Riwayat Pendaftaran</span>
                    </a>


                    <a
                        href="{{ route('informasi') }}"
                        class="{{ request()->routeIs('informasi') ? 'active' : '' }}"
                        @if(request()->routeIs('informasi')) aria-current="page" @endif
                    >
                        <span class="sidebar-icon"><x-icon name="info" /></span>
                        <span>Informasi</span>
                    </a>

                @endif

            </nav>


            {{-- LOGOUT --}}

            <div class="sidebar-bottom">

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    data-confirm="Yakin ingin keluar dari RAPAT?"
                >

                    @csrf

                    <button
                        type="submit"
                        class="sidebar-logout"
                    >
                        <span class="sidebar-icon"><x-icon name="logout" /></span>
                        <span>Keluar</span>
                    </button>

                </form>

            </div>

        </aside>

    @endauth


    {{-- =========================================================
         APP WRAPPER
    ========================================================== --}}

    <div class="app-wrapper">

        {{-- =====================================================
             APPBAR GLOBAL (jam, notifikasi, profil, menu mobile)
        ====================================================== --}}

        @auth
            @include('partials.topbar')
        @endauth


        {{-- =====================================================
             MAIN CONTENT
        ====================================================== --}}

        <main class="main-content" id="main" tabindex="-1">

            @include('partials.flash')

            @yield('content')

        </main>


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        @auth

            <footer class="footer">
                <span>
                    © {{ date('Y') }} RAPAT — REGISTRASI ADMINISTRASI PENGGUNAAN AULA TERKONTROL
                </span>

                <span class="footer-note">
                    Diskominfo
                </span>
            </footer>

        @endauth


    </div>


    {{-- Kembali ke atas --}}

    <button
        type="button"
        class="scroll-top"
        data-scroll-top
        aria-label="Kembali ke atas"
        tabindex="-1"
    >
        <x-icon name="arrow-up" size="18" />
    </button>


    <script src="{{ asset('js/rapat.js') }}" defer></script>

    @stack('scripts')

</body>

</html>