{{-- =====================================================================
     APPBAR GLOBAL: menu mobile, judul halaman, jam, notifikasi, profil
     Dipasang sekali di layouts/app.blade.php (bukan per halaman).
====================================================================== --}}

@php
    $tbUser  = auth()->user();
    $tbAdmin = $tbUser && $tbUser->isAdmin();
    $tbNow   = now('Asia/Makassar');

    $tbHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    $tbBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    $tbNotifs = collect();

    if ($tbUser) {
        $tbQuery = $tbAdmin
            ? \App\Models\Pendaftaran::query()
            : $tbUser->pendaftarans();

        $tbNotifs = $tbQuery->with('aula')->latest('updated_at')->limit(6)->get();
    }

    $tbRoute = request()->route() ? request()->route()->getName() : '';

    $tbJudul = [
        'dashboard'                  => ['Dashboard', 'Ringkasan aktivitas pengajuan Anda'],
        'aulas'                      => ['Daftar Aula', 'Pilih aula untuk kegiatan Anda'],
        'informasi'                  => ['Informasi', 'Panduan, ketentuan, dan kontak layanan'],
        'pendaftaran.create'        => ['Formulir Pendaftaran', 'Lengkapi data pengajuan pemakaian aula'],
        'pendaftaran.show'          => ['Detail Pengajuan', 'Status dan rincian pengajuan Anda'],
        'pendaftaran.history'       => ['Riwayat Pendaftaran', 'Seluruh pengajuan yang pernah Anda buat'],
        'admin.dashboard'            => ['Dashboard Admin', 'Kelola pengajuan pemakaian aula'],
        'admin.pendaftaran.index'    => ['Riwayat Pendaftaran', 'Verifikasi dan proses pengajuan masuk'],
        'admin.pendaftaran.show'     => ['Detail Pengajuan', 'Periksa dan putuskan pengajuan'],
        'admin.aulas.index'          => ['Data Aula', 'Kelola daftar aula yang tersedia'],
        'admin.aulas.create'         => ['Tambah Aula', 'Daftarkan aula baru ke dalam sistem'],
        'admin.aulas.edit'           => ['Ubah Aula', 'Perbarui data aula'],
        'admin.aulas.show'           => ['Detail Aula', 'Informasi lengkap dan pemakaian aula'],
        'admin.laporan'              => ['Laporan', 'Rekapitulasi pemakaian aula'],
    ][$tbRoute] ?? ['SAPA', 'Sistem Aplikasi untuk Layanan Akomodasi (Aula)'];

    $tbSeksi = $tbAdmin ? 'Administrator' : 'Pengguna';
@endphp


<header class="appbar" id="appbar">

    @auth

        <button
            type="button"
            class="appbar-toggle"
            data-nav-toggle
            aria-label="Buka menu navigasi"
            aria-controls="sidebar"
            aria-expanded="false"
        >
            <x-icon name="menu" size="20" />
        </button>

    @endauth


    <a href="{{ $tbAdmin ? route('admin.dashboard') : route('dashboard') }}" class="appbar-brand" aria-label="RAPAT - Beranda">
        <img src="{{ asset('images/logo-rapat.jpg') }}" alt="Logo RAPAT">
    </a>

    <div class="appbar-crumb">

        <span class="appbar-seksi">{{ $tbSeksi }}</span>

        <strong class="appbar-title">{{ $tbJudul[0] }}</strong>

        <span class="appbar-sub">{{ $tbJudul[1] }}</span>

    </div>


    <div class="appbar-spacer"></div>


    <div class="topbar">

        {{-- HARI & JAM REALTIME (diperbarui tiap detik oleh rapat.js) --}}

        <div class="tb-date">
            <x-icon name="calendar" size="16" />

            <span class="tb-day" id="tbDay">
                {{ $tbHari[(int) $tbNow->format('w')] }},
                {{ $tbNow->format('j') }}
                {{ $tbBulan[(int) $tbNow->format('n')] }}
                {{ $tbNow->format('Y') }}
            </span>

            <span class="tb-time" id="tbTime">
                {{ $tbNow->format('H.i.s') }} WITA
            </span>
        </div>


        @auth

            {{-- NOTIFIKASI --}}

            <div class="tb-dropdown">

                <button
                    type="button"
                    class="tb-btn tb-bell"
                    data-tb-toggle="tbNotifPanel"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-label="Notifikasi"
                >
                    <x-icon name="bell" size="20" />

                    <span
                        class="tb-badge"
                        id="tbBadge"
                        data-account="{{ $tbUser->id }}"
                        hidden
                    ></span>
                </button>

                <div class="tb-panel" id="tbNotifPanel" role="menu" aria-label="Daftar notifikasi">

                    <div class="tb-panel-title">
                        Notifikasi Terbaru
                        <span>{{ $tbNotifs->count() }}</span>
                    </div>

                    <div class="tb-list">

                        @forelse ($tbNotifs as $n)

                            @php
                                $tbNamaAula = $n->aula->nama_aula ?? 'Aula';

                                $tbRentang = $n->tanggal_mulai
                                    ? $n->tanggal_mulai->format('d/m/Y')
                                    : '';

                                if (
                                    $n->tanggal_selesai
                                    && $n->tanggal_mulai
                                    && $n->tanggal_selesai->ne($n->tanggal_mulai)
                                ) {
                                    $tbRentang .= ' – ' . $n->tanggal_selesai->format('d/m/Y');
                                }

                                $tbTautan = $tbAdmin
                                    ? route('admin.pendaftaran.show', $n)
                                    : route('pendaftaran.show', $n);
                            @endphp

                            <a
                                href="{{ $tbTautan }}"
                                class="tb-item {{ $n->status }}"
                                data-status="{{ $n->status }}"
                                data-ts="{{ $n->updated_at->timestamp }}"
                            >
                                <span class="tb-dot"></span>

                                <span class="tb-item-text">

                                    <strong>
                                        @if ($tbAdmin)
                                            {{ $n->nama_pemohon }} — {{ $tbNamaAula }}
                                        @elseif ($n->status === 'disetujui')
                                            Pengajuan {{ $tbNamaAula }} disetujui
                                        @elseif ($n->status === 'ditolak')
                                            Pengajuan {{ $tbNamaAula }} ditolak
                                        @elseif ($n->status === 'dibatalkan')
                                            Pengajuan {{ $tbNamaAula }} dibatalkan
                                        @else
                                            Pengajuan {{ $tbNamaAula }} menunggu persetujuan
                                        @endif
                                    </strong>

                                    <span>
                                        @if ($n->status === 'ditolak' && $n->catatan_admin)
                                            {{ \Illuminate\Support\Str::limit($n->catatan_admin, 70) }}
                                        @else
                                            {{ $tbRentang }}
                                        @endif
                                    </span>

                                    <span>
                                        {{ $n->updated_at->timezone('Asia/Makassar')->format('d/m/Y H:i') }} WITA
                                    </span>

                                </span>
                            </a>

                        @empty

                            <div class="tb-empty">
                                Belum ada notifikasi.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- PROFIL --}}

            <div class="tb-dropdown">

                <button
                    type="button"
                    class="tb-btn tb-profile"
                    data-tb-toggle="tbProfilePanel"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-label="Menu akun"
                >
                    <span class="tb-avatar">
                        {{ mb_strtoupper(mb_substr($tbUser->name ?? 'U', 0, 1)) }}
                    </span>

                    <span class="tb-user-name">
                        {{ $tbUser->name ?? '' }}
                    </span>

                    <span class="tb-caret">
                        <x-icon name="chevron-down" size="16" />
                    </span>
                </button>

                <div class="tb-panel" id="tbProfilePanel" role="menu" aria-label="Menu akun">

                    <div class="tb-profile-head">

                        <span class="tb-avatar">
                            {{ mb_strtoupper(mb_substr($tbUser->name ?? 'U', 0, 1)) }}
                        </span>

                        <div>
                            <strong>{{ $tbUser->name ?? '' }}</strong>

                            <span>{{ $tbUser->email ?? '' }}</span>

                            <span class="tb-role">
                                {{ $tbAdmin ? 'Administrator' : 'Pengguna' }}
                            </span>
                        </div>

                    </div>

                 <div class="tb-menu">

                        @if ($tbAdmin)

                            <a href="{{ route('admin.dashboard') }}">
                                <x-icon name="dashboard" size="17" />
                                Dashboard Admin
                            </a>

                            <a href="{{ route('admin.pendaftaran.index') }}">
                                <x-icon name="history" size="17" />
                                Riwayat Pendaftaran
                            </a>

                            <a href="{{ route('admin.laporan') }}">
                                <x-icon name="chart" size="17" />
                                Laporan
                            </a>

                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="tb-logout">
                                <x-icon name="logout" size="17" />
                                Keluar
                            </button>
                        </form>

                    </div>
                    
                </div>

            </div>

        @endauth

    </div>

</header>