@extends('layouts.app')

@section('title', 'Informasi | RAPAT')

@section('content')

<div class="info-page">


    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="info-header">

        <h1>
            Informasi RAPAT
        </h1>

        <p>
            Informasi aula, panduan pendaftaran, ketentuan pemakaian,
            keputusan pengajuan, dan bantuan untuk pengguna RAPAT.
        </p>

    </div>


    {{-- NAVIGASI BAGIAN --}}

    <nav class="info-nav">

        <a href="#informasi-aula">Informasi Aula</a>
        <a href="#panduan-pendaftaran">Panduan Pendaftaran</a>
        <a href="#ketentuan-pemakaian">Ketentuan Pemakaian</a>
        <a href="#keputusan-pengajuan">Keputusan Pengajuan</a>
        <a href="#bantuan">Bantuan</a>

    </nav>


    {{-- =========================================================
         A. INFORMASI AULA
    ========================================================== --}}

    <section class="info-section" id="informasi-aula">

        <div class="info-section-head">
            <span class="info-section-icon"><x-icon name="building" /></span>
            <div>
                <h2>Informasi Aula</h2>
                <p>Data aula yang dapat digunakan melalui RAPAT.</p>
            </div>
        </div>

        @if($aulas->count() > 0)

            <div class="aula-grid">

                @foreach($aulas as $item)

                    <article class="aula-info-card">

                        @if($item['foto'])
                            <img
                                src="{{ $item['foto'] }}"
                                alt="{{ $item['aula']->nama_aula }}"
                                class="aula-info-photo"
                            >
                        @else
                            <div class="aula-info-photo aula-info-photo-empty">
                                <x-icon name="building" size="42" />
                            </div>
                        @endif

                        <div class="aula-info-body">

                            <h3>{{ $item['aula']->nama_aula }}</h3>

                            <dl class="aula-info-list">

                                @if($item['kapasitas'])
                                    <div>
                                        <dt>Kapasitas</dt>
                                        <dd>{{ $item['kapasitas'] }}</dd>
                                    </div>
                                @endif

                                @if($item['ukuran'])
                                    <div>
                                        <dt>Ukuran</dt>
                                        <dd>{{ $item['ukuran'] }}</dd>
                                    </div>
                                @endif

                                @if($item['fasilitas'])
                                    <div>
                                        <dt>Fasilitas</dt>
                                        <dd>{{ $item['fasilitas'] }}</dd>
                                    </div>
                                @endif

                                @if($item['aula']->keterangan)
                                    <div>
                                        <dt>Keterangan</dt>
                                        <dd>{{ $item['aula']->keterangan }}</dd>
                                    </div>
                                @endif

                            </dl>

                            <a
                                href="{{ route('pendaftaran.create', $item['aula']) }}"
                                class="info-btn"
                            >
                                Daftar {{ $item['aula']->nama_aula }}
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="info-empty">
                Belum ada data aula.
            </div>

        @endif

    </section>


    {{-- =========================================================
         B. PANDUAN PENDAFTARAN
    ========================================================== --}}

    <section class="info-section" id="panduan-pendaftaran">

        <div class="info-section-head">
            <span class="info-section-icon"><x-icon name="pencil" /></span>
            <div>
                <h2>Panduan Pendaftaran</h2>
                <p>Langkah-langkah mengajukan pemakaian aula.</p>
            </div>
        </div>

        <ol class="step-list">

            <li>
                <span class="step-number">1</span>
                <div class="step-text">
                    <strong>Login</strong>
                    Login menggunakan akun yang terdaftar.
                </div>
            </li>

            <li>
                <span class="step-number">2</span>
                <div class="step-text">
                    <strong>Buka menu Daftar Aula</strong>
                    Buka menu
                    <a href="{{ route('aulas') }}">Daftar Aula</a>.
                </div>
            </li>

            <li>
                <span class="step-number">3</span>
                <div class="step-text">
                    <strong>Pilih aula</strong>
                    Pilih aula sesuai kebutuhan.
                </div>
            </li>

            <li>
                <span class="step-number">4</span>
                <div class="step-text">
                    <strong>Isi formulir</strong>
                    Isi formulir pendaftaran dengan benar.
                </div>
            </li>

            <li>
                <span class="step-number">5</span>
                <div class="step-text">
                    <strong>Kirim pengajuan</strong>
                    Kirim pengajuan.
                </div>
            </li>

            <li>
                <span class="step-number">6</span>
                <div class="step-text">
                    <strong>Pantau status</strong>
                    Pantau status pengajuan melalui menu
                    <a href="{{ route('pendaftaran.history') }}">Riwayat Pendaftaran</a>.
                </div>
            </li>

            <li>
                <span class="step-number">7</span>
                <div class="step-text">
                    <strong>Keputusan pengajuan</strong>
                    Silahkan cek di
                    <a href="#keputusan-pengajuan">Keputusan Pengajuan</a>.
                </div>
            </li>

        </ol>

    </section>


    {{-- =========================================================
         C. KETENTUAN PEMAKAIAN AULA
    ========================================================== --}}

    <section class="info-section" id="ketentuan-pemakaian">

        <div class="info-section-head">
            <span class="info-section-icon"><x-icon name="checklist" /></span>
            <div>
                <h2>Ketentuan Pemakaian Aula</h2>
                <p>Ketentuan umum yang perlu diperhatikan pemohon.</p>
            </div>
        </div>

        <ul class="rule-list">

            <li>
                <span class="rule-check"><x-icon name="check" size="14" /></span>
                Isi data pemohon dan kegiatan dengan benar.
            </li>

            <li>
                <span class="rule-check"><x-icon name="check" size="14" /></span>
                Pilih tanggal dan waktu sesuai kebutuhan.
            </li>

            <li>
                <span class="rule-check"><x-icon name="check" size="14" /></span>
                Periksa ketersediaan aula sebelum mengirim pengajuan.
            </li>

            <li>
                <span class="rule-check"><x-icon name="check" size="14" /></span>
                Pengajuan belum dianggap disetujui sebelum admin
                memberikan persetujuan.
            </li>

            <li>
                <span class="rule-check"><x-icon name="check" size="14" /></span>
                Pantau status pengajuan melalui Riwayat Pendaftaran.
            </li>

        </ul>

    </section>


    {{-- =========================================================
         D. KEPUTUSAN PENGAJUAN
    ========================================================== --}}

    <section class="info-section" id="keputusan-pengajuan">

        <div class="info-section-head">
            <span class="info-section-icon"><x-icon name="megaphone" /></span>
            <div>
                <h2>Keputusan Pengajuan</h2>
                <p>
                    Notifikasi hasil keputusan admin atas pengajuan
                    pemakaian aula Anda.
                </p>
            </div>
        </div>

        @forelse($keputusans as $keputusan)

            @php
                $disetujui = $keputusan['status'] === 'disetujui';
            @endphp

            <article class="announce-card">

                <div class="announce-title">
                    <span style="display:inline-block; margin-right:8px; padding:2px 10px;
                                 font-size:13px; font-weight:600; border-radius:999px;
                                 color:{{ $disetujui ? '#166534' : '#991b1b' }};
                                 background:{{ $disetujui ? '#dcfce7' : '#fee2e2' }};">
                        {{ $disetujui ? 'Disetujui' : 'Ditolak' }}
                    </span>

                    Pengajuan {{ $keputusan['aula'] }}
                    {{ $disetujui ? 'disetujui' : 'ditolak' }}
                </div>

                @if(!empty($keputusan['diputuskan']))
                    <div class="announce-date">
                        {{ $keputusan['diputuskan'] }}
                    </div>
                @endif

                <p>
                    @if($keputusan['tanggal'])
                        Tanggal pemakaian: {{ $keputusan['tanggal'] }}.
                    @endif

                    @if($keputusan['waktu'])
                        Waktu: {{ $keputusan['waktu'] }}.
                    @endif
                </p>

                @if(!empty($keputusan['catatan']))
                    <p>
                        <strong>Alasan penolakan:</strong>
                        {{ $keputusan['catatan'] }}
                    </p>
                @endif

                <p>
                    <a href="{{ $keputusan['url'] }}">Lihat detail pengajuan</a>
                </p>

            </article>

        @empty

            <div class="info-empty">
                Belum ada keputusan pengajuan.
            </div>

        @endforelse

    </section>


    {{-- =========================================================
         E. BANTUAN
    ========================================================== --}}

    <section class="info-section" id="bantuan">

        <div class="info-section-head">
            <span class="info-section-icon"><x-icon name="message" /></span>
            <div>
                <h2>Bantuan</h2>
                <p>Petunjuk untuk mengatasi kendala yang sering terjadi.</p>
            </div>
        </div>

        <div class="help-grid">

            <div class="help-card">
                <h3>Kendala Login</h3>
                <ul>
                    <li>Pastikan Anda memakai akun yang sudah terdaftar.</li>
                    <li>Periksa kembali email dan kata sandi yang dimasukkan.</li>
                    <li>Muat ulang halaman, lalu coba login kembali.</li>
                    <li>Jika masih gagal, hubungi admin.</li>
                </ul>
            </div>

            <div class="help-card">
                <h3>Kendala Pendaftaran</h3>
                <ul>
                    <li>Lengkapi semua kolom wajib pada formulir.</li>
                    <li>Periksa ketersediaan tanggal dan waktu pada Rekap Ketersediaan Aula di Dashboard.</li>
                    <li>Pastikan tanggal selesai tidak lebih awal dari tanggal mulai.</li>
                    <li>Pantau hasil pengajuan di Riwayat Pendaftaran.</li>
                </ul>
            </div>

            <div class="help-card">
                <h3>Verifikasi Lokasi</h3>
                <ul>
                    <li>Jika diminta, izinkan akses lokasi pada browser.</li>
                    <li>Pastikan lokasi (GPS) pada perangkat dalam keadaan aktif.</li>
                    <li>Muat ulang halaman, lalu ulangi verifikasi.</li>
                    <li>Jika masih gagal, hubungi admin.</li>
                </ul>
            </div>

        </div>


    </section>

</div>

{{-- tombol navigasi bagian: yang biru mengikuti bagian yang sedang dibuka --}}
<style>
    /* semua tombol dibuat polos dulu, apa pun gaya lama yang menempel */
    .info-nav a:not(.is-active) {
        color: #17315f !important;
        background: #ffffff !important;
        border: 1px solid #c9d8ec !important;
        box-shadow: none !important;
    }

    .info-nav a:not(.is-active):hover {
        background: #eef4ff !important;
    }

    /* hanya satu tombol biru: bagian yang sedang dibuka */
    .info-nav a.is-active {
        color: #ffffff !important;
        background: #1e40af !important;
        border: 1px solid #1e40af !important;
        box-shadow: 0 8px 18px -8px rgba(30, 64, 175, 0.65) !important;
    }
</style>

<script>
(function () {

    var links = Array.prototype.slice.call(
        document.querySelectorAll('.info-nav a')
    );

    var sections = links.map(function (link) {
        return document.querySelector(link.getAttribute('href'));
    });

    var kunciSampai = 0;

    function aktifkan(index) {
        links.forEach(function (link, i) {
            link.classList.toggle('is-active', i === index);
        });
    }

    function sesuaikan() {

        if (Date.now() < kunciSampai) {
            return;
        }

        var index = 0;

        sections.forEach(function (section, i) {
            if (section && section.getBoundingClientRect().top <= 160) {
                index = i;
            }
        });

        // sampai di dasar halaman: bagian terakhir (Bantuan) yang aktif
        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 4) {
            index = sections.length - 1;
        }

        aktifkan(index);
    }

    links.forEach(function (link, i) {
        link.addEventListener('click', function () {
            aktifkan(i);
            kunciSampai = Date.now() + 900;
            setTimeout(sesuaikan, 950);
        });
    });

    window.addEventListener('scroll', sesuaikan, { passive: true });

    sesuaikan();

})();
</script>

@endsection