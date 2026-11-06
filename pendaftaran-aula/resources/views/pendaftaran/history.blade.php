@extends('layouts.app')

@section('title', 'Riwayat Pemakaian Aula | RAPAT')

@section('content')

<div class="history-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="page-header">

        <div class="header-left">

            <h1>
                Riwayat Pemakaian Aula
            </h1>

            <p>
                Daftar seluruh pengajuan pemakaian aula yang telah Anda lakukan.
            </p>

        </div>

        <div class="header-action">

            <a
                href="{{ route('aulas') }}"
                class="primary-btn"
            >
                <x-icon name="plus" size="17" />
                Ajukan Pemakaian
            </a>

        </div>

    </div>


    {{-- =========================================================
         BACK TO DASHBOARD
    ========================================================== --}}

    <div class="back-dashboard">

        <a
            href="{{ route('dashboard') }}"
            class="back-link"
        >
            <x-icon name="arrow-left" size="16" />
            Kembali ke Dashboard
        </a>

    </div>


    {{-- =========================================================
         SUMMARY
    ========================================================== --}}

    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-icon">
                <x-icon name="history" />
            </div>

            <div class="summary-content">

                <span class="summary-label">
                    Total Pengajuan
                </span>

                <strong>
                    {{ $pendaftarans->count() }}
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon waiting">
                <x-icon name="clock" />
            </div>

            <div class="summary-content">

                <span class="summary-label">
                    Menunggu
                </span>

                <strong>
                    {{ $pendaftarans->where('status', 'menunggu')->count() }}
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon approved">
                <x-icon name="check" />
            </div>

            <div class="summary-content">

                <span class="summary-label">
                    Disetujui
                </span>

                <strong>
                    {{ $pendaftarans->where('status', 'disetujui')->count() }}
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon rejected">
                <x-icon name="x" />
            </div>

            <div class="summary-content">

                <span class="summary-label">
                    Ditolak
                </span>

                <strong>
                    {{ $pendaftarans->where('status', 'ditolak')->count() }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =========================================================
         HISTORY CARD
    ========================================================== --}}

    <div class="history-card">

        {{-- CARD HEADER --}}

        <div class="card-header">

            <div>

                <div class="card-title-row">

                    <div class="card-title-icon">
                        <x-icon name="history" />
                    </div>

                    <div>

                        <h2>
                            Daftar Pengajuan
                        </h2>

                        <p>
                            Riwayat pemakaian aula Anda
                        </p>

                    </div>

                </div>

            </div>


            <div class="total-badge">

                {{ $pendaftarans->count() }}
                Pengajuan

            </div>

        </div>


        {{-- =====================================================
             DATA
        ====================================================== --}}

        @if($pendaftarans->count() > 0)

            @php
                $labelWaktu = [
                    'pagi_siang' => '08.00 - 13.00',
                    'siang_sore' => '14.00 - 16.00',
                    'malam' => '18.00 - 21.00',
                    'gabungan_pagi_siang' => 'Full Day (1 hari penuh)',
                    'gabungan_siang_malam' => 'Full Day (1 hari penuh)',
                    'gabungan_pagi_malam' => 'Full Day (1 hari penuh)',
                ];
            @endphp

            {{-- PENCARIAN & FILTER --}}

            <div class="riwayat-toolbar">

                <div class="riwayat-search">
                    <span class="riwayat-search-icon"><x-icon name="search" size="18" /></span>
                    <input
                        type="text"
                        id="riwayatSearch"
                        placeholder="Cari nama kegiatan..."
                        autocomplete="off"
                    >
                </div>

                <select id="riwayatFilter" class="riwayat-select">
                    <option value="all">Semua</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>

            </div>


            {{-- DAFTAR RIWAYAT --}}

            <div class="riwayat-list" id="riwayatList">

                @foreach($pendaftarans as $pendaftaran)

                    @php
                        $namaAula = $pendaftaran->aula->nama_aula ?? '-';

                        $fotoAula = str_contains(strtolower($namaAula), 'kecil')
                            ? asset('images/aula-kecil.jpg')
                            : asset('images/aula-besar.jpg');

                        $namaKegiatan = $pendaftaran->keperluan ?: 'Pemakaian Aula';

                        $statusRiwayat = in_array(
                            $pendaftaran->status,
                            ['disetujui', 'ditolak', 'dibatalkan']
                        ) ? $pendaftaran->status : 'menunggu';
                    @endphp

                    <a
                        href="{{ route('pendaftaran.show', $pendaftaran) }}"
                        class="riwayat-item"
                        data-nama="{{ strtolower($namaKegiatan) }}"
                        data-status="{{ $statusRiwayat }}"
                    >

                        <img
                            src="{{ $fotoAula }}"
                            alt="{{ $namaAula }}"
                            class="riwayat-thumb"
                        >

                        <div class="riwayat-info">

                            <div class="riwayat-title">
                                {{ $namaKegiatan }}
                            </div>

                            <div class="riwayat-meta">

                                @if($pendaftaran->tanggal_mulai)

                                    {{
                                        \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)
                                            ->locale('id')
                                            ->translatedFormat('d M Y')
                                    }}

                                    @if(
                                        $pendaftaran->tanggal_selesai &&
                                        $pendaftaran->tanggal_selesai != $pendaftaran->tanggal_mulai
                                    )
                                        -
                                        {{
                                            \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)
                                                ->locale('id')
                                                ->translatedFormat('d M Y')
                                        }}
                                    @endif

                                    •

                                    {{ $labelWaktu[$pendaftaran->kriteria_waktu] ?? '-' }}

                                @else
                                    -
                                @endif

                            </div>

                            <div class="riwayat-aula">
                                <x-icon name="map-pin" size="15" /> {{ $namaAula }}
                            </div>

                        </div>

                        <div class="riwayat-status">

                            @if($statusRiwayat === 'disetujui')

                                <span class="badge badge-success">
                                    Disetujui
                                </span>

                            @elseif($statusRiwayat === 'ditolak')

                                <span class="badge badge-danger">
                                    Ditolak
                                </span>

                            @elseif($statusRiwayat === 'dibatalkan')

                                <span class="badge badge-cancelled">
                                    Dibatalkan
                                </span>

                            @else

                                <span class="badge badge-pending">
                                    Menunggu
                                </span>

                            @endif

                        </div>

                    </a>

                @endforeach

                <div class="riwayat-empty-search" id="riwayatEmpty" style="display:none;">
                    Tidak ada pengajuan yang cocok.
                </div>

            </div>


            {{-- =================================================
                 TABLE FOOTER
            ================================================== --}}

            <div class="table-footer">

                <div class="footer-description">

                    <span class="footer-icon">
                        <x-icon name="info" size="16" />
                    </span>

                    Menampilkan seluruh riwayat pengajuan
                    pemakaian aula Anda.

                </div>

                <div class="status-info">

                    Status diperbarui oleh administrator.

                </div>

            </div>


        @else

            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            <div class="empty-state">

                <div class="empty-icon">
                    <x-icon name="history" />
                </div>

                <h3>
                    Belum Ada Pengajuan
                </h3>

                <p>
                    Anda belum memiliki riwayat pengajuan
                    pemakaian aula.
                </p>

                <a
                    href="{{ route('aulas') }}"
                    class="primary-btn empty-btn"
                >
                    Lihat Daftar Aula
                </a>

            </div>

        @endif

    </div>

</div>


<script>

    (function () {

        var search = document.getElementById('riwayatSearch');
        var filter = document.getElementById('riwayatFilter');

        if (!search || !filter) return;

        function terapkan() {

            var kata = search.value.trim().toLowerCase();
            var status = filter.value;
            var tampil = 0;

            document.querySelectorAll('.riwayat-item').forEach(function (item) {

                var cocokNama = item.dataset.nama.indexOf(kata) !== -1;
                var cocokStatus = status === 'all' || item.dataset.status === status;
                var ok = cocokNama && cocokStatus;

                item.style.display = ok ? '' : 'none';

                if (ok) tampil++;

            });

            document.getElementById('riwayatEmpty').style.display =
                tampil === 0 ? '' : 'none';

        }

        search.addEventListener('input', terapkan);
        filter.addEventListener('change', terapkan);

    })();

</script>



@endsection