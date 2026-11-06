@extends('layouts.app')

@section('title', 'Dashboard | RAPAT')

@section('content')



<div class="dashboard-page">


    {{-- =================================================
         WELCOME
    ================================================== --}}

    <section class="welcome-section">

        <h1>
            Selamat Datang, {{ Auth::user()->name }}
        </h1>

        <p>
            Kelola pemakaian aula dan lihat jadwal kegiatan melalui RAPAT.
        </p>
        <div class="dashboard-recap-row">
            <div class="dashboard-recap-intro">
                <strong>Rekap Penggunaan Aula</strong>
                <span>Data untuk bulan {{ \Carbon\Carbon::create($tahun, $bulanPilihan, 1)->locale('id')->translatedFormat('F Y') }}.</span>
            </div>
            <div class="month-nav-buttons">
                @if($bulanSebelumnya)
                    <a class="btn btn-secondary month-prev-btn" href="{{ route('dashboard', ['aula' => $aulaTerpilih?->id, 'bulan' => $bulanSebelumnya, 'tahun' => $tahunSebelumnya]) }}">
                        <x-icon name="arrow-left" size="16" /> Bulan Sebelumnya
                    </a>
                @else
                    <span class="btn btn-secondary month-prev-btn is-disabled" aria-disabled="true"><x-icon name="arrow-left" size="16" /> Bulan Sebelumnya</span>
                @endif
                @if($bulanBerikutnya)
                    <a class="btn btn-primary month-next-btn" href="{{ route('dashboard', ['aula' => $aulaTerpilih?->id, 'bulan' => $bulanBerikutnya, 'tahun' => $tahunBerikutnya]) }}">Bulan Selanjutnya <x-icon name="arrow-right" size="16" /></a>
                @else
                    <span class="btn btn-primary month-next-btn is-disabled" aria-disabled="true">Bulan Selanjutnya <x-icon name="arrow-right" size="16" /></span>
                @endif
            </div>
        </div>

    </section>


    {{-- =================================================
         STATISTIK
    ================================================== --}}

    <section class="stats-grid">

        <div class="stat-card">

            <div class="stat-label">
                Total Pendaftaran
            </div>

            <div class="stat-number">
                {{ $totalPendaftaran }}
            </div>

        </div>


        <div class="stat-card is-menunggu">

            <div class="stat-label">
                Menunggu
            </div>

            <div class="stat-number">
                {{ $menunggu }}
            </div>

        </div>


        <div class="stat-card is-disetujui">

            <div class="stat-label">
                Disetujui
            </div>

            <div class="stat-number">
                {{ $disetujui }}
            </div>

        </div>


        <div class="stat-card is-ditolak">

            <div class="stat-label">
                Ditolak
            </div>

            <div class="stat-number">
                {{ $ditolak }}
            </div>

        </div>

    </section>


    {{-- =================================================
         STATISTIK PER AULA
    ================================================== --}}

    <section class="aula-stats-section" id="ringkasan-pendaftaran">

        <h2 class="aula-stats-heading">
            Ringkasan Pendaftaran Aula
        </h2>

        <p class="aula-stats-description">
            Lihat jumlah pendaftaran dan statusnya untuk setiap aula.
        </p>

        <div class="aula-stats-grid">

            @foreach($aulas as $aula)

                @php
                    $stat = $statistikAula[$aula->id] ?? [
                        'total' => 0,
                        'menunggu' => 0,
                        'disetujui' => 0,
                        'ditolak' => 0,
                    ];

                    // foto aula mengikuti nama aula
                    $fotoAula = str_contains(strtolower($aula->nama_aula ?? ''), 'kecil')
                        ? 'images/aula-kecil.jpg'
                        : 'images/aula-besar.jpg';
                @endphp

                <div class="aula-stat-card">

                    <div class="aula-stat-head">

                        <img
                            src="{{ asset($fotoAula) }}"
                            alt="{{ $aula->nama_aula }}"
                            width="48"
                            height="48"
                            style="flex:none; width:48px; height:48px; object-fit:cover;
                                   border-radius:12px; box-shadow:0 6px 14px -6px rgba(15,35,95,.5);"
                        >

                        <div class="aula-stat-titles">
                            <div class="aula-stat-name">
                                {{ $aula->nama_aula }}
                            </div>
                        </div>

                    </div>

                    <div class="aula-stat-rows">
                        <div class="aula-stat-item aula-stat-total-row">
                            <span class="lbl">Pendaftaran</span>
                            <span class="num">{{ $stat['total'] }}</span>
                        </div>
                        <div class="aula-stat-item is-menunggu">
                            <span class="lbl">Menunggu</span>
                            <span class="num">{{ $stat['menunggu'] }}</span>
                        </div>
                        <div class="aula-stat-item is-disetujui">
                            <span class="lbl">Disetujui</span>
                            <span class="num">{{ $stat['disetujui'] }}</span>
                        </div>
                        <div class="aula-stat-item is-ditolak">
                            <span class="lbl">Ditolak</span>
                            <span class="num">{{ $stat['ditolak'] }}</span>
                        </div>
                    </div>

                </div>

            @endforeach

        </div>

    </section>


    {{-- =================================================
         REKAP
    ================================================== --}}

    <section class="schedule-section" id="rekap">


        {{-- HEADER --}}

        <div class="schedule-header schedule-header-with-actions">
            <div>
                <h2 class="schedule-title">Rekap Penggunaan Aula</h2>
                <p class="schedule-description">
                    Data untuk bulan {{ \Carbon\Carbon::create($tahun, $bulanPilihan, 1)->locale('id')->translatedFormat('F Y') }}.
                </p>
            </div>

        </div>


        {{-- =================================================
             PILIH AULA
        ================================================== --}}

        <div class="aula-selector">

            <div class="aula-selector-title">
                Pilih Aula
            </div>


            <div class="aula-buttons">

                @foreach($aulas as $aula)

                    <a
                        href="{{ route('dashboard', [
                            'aula' => $aula->id,
                        ]) }}#rekap"
                        class="aula-btn {{ $aulaTerpilih && $aulaTerpilih->id === $aula->id ? 'active' : '' }}"
                    >
                        {{ $aula->nama_aula }}
                    </a>

                @endforeach

            </div>


            {{-- DATA AULA TERPILIH --}}

            @if($aulaTerpilih)

                @php
                    $namaAulaTerpilih = strtolower(
                        $aulaTerpilih->nama_aula ?? ''
                    );

                    if (str_contains($namaAulaTerpilih, 'kecil')) {
                        $ukuranTerpilih = '7,6 x 4 m';
                        $fasilitasTerpilih = 'TV 65 inch';
                        $kapasitasTerpilih = '< 30 orang';
                    } else {
                        $ukuranTerpilih = '15 x 10 m';
                        $fasilitasTerpilih = 'Audio System, Videotron, Lighting, Panggung';
                        $kapasitasTerpilih = '> 30 orang';
                    }
                @endphp

                <div class="aula-info">

                    <div class="aula-info-title">
                        Data Aula
                    </div>

                    <p>
                        <strong>{{ $aulaTerpilih->nama_aula }}</strong>
                        — Kap {{ $kapasitasTerpilih }}
                        ({{ $ukuranTerpilih }})
                    </p>

                    <p>
                        Fasilitas: {{ $fasilitasTerpilih }}
                    </p>


                </div>

            @endif

        </div>


        {{-- =================================================
             FILTER
        ================================================== --}}

        <div class="filter-area">

            <span class="filter-label">
                Tampilkan:
            </span>


            <button
                type="button"
                class="filter-btn active"
                data-filter="all"
            >
                Semua
            </button>


            <button
                type="button"
                class="filter-btn"
                data-filter="disetujui"
            >
                <span class="filter-dot dot-disetujui"></span>
                Disetujui
            </button>


            <button
                type="button"
                class="filter-btn"
                data-filter="menunggu"
            >
                <span class="filter-dot dot-menunggu"></span>
                Menunggu
            </button>


            <button
                type="button"
                class="filter-btn"
                data-filter="ditolak"
            >
                <span class="filter-dot dot-ditolak"></span>
                Ditolak
            </button>


            <button
                type="button"
                class="filter-btn"
                data-filter="kosong"
            >
                <span class="filter-dot dot-empty"></span>
                Kosong
            </button>

        </div>


        {{-- =================================================
             TABEL REKAP HARIAN BULAN INI
        ================================================== --}}

        <div class="rekap-legend">
            <span class="legend-item">
                <span class="legend-box box-disetujui"></span>
                Disetujui
            </span>

            <span class="legend-item">
                <span class="legend-box box-menunggu"></span>
                Menunggu
            </span>

            <span class="legend-item">
                <span class="legend-box box-ditolak"></span>
                Ditolak
            </span>

            <span class="legend-item">
                <span class="legend-box box-kosong"></span>
                Kosong
            </span>
        </div>


        @if($rekapBulanIni)

            <div class="rekap-month">

                <div class="rekap-month-title">
                    {{ $rekapBulanIni['judul'] }}
                </div>


                <div class="rekap-wrapper">

                    <div class="rekap-table-scroll">

                        <table class="rekap-table">

                            <thead>

                                <tr>
                                    <th class="col-tanggal">
                                        Tanggal
                                    </th>

                                    <th class="col-hari">
                                        Hari
                                    </th>

                                    <th>
                                        Pagi
                                        <span>08.00 - 13.00</span>
                                    </th>

                                    <th>
                                        Siang
                                        <span>14.00 - 16.00</span>
                                    </th>

                                    <th>
                                        Malam
                                        <span>18.00 - 21.00</span>
                                    </th>

                                    <th>
                                        Full Day
                                        <span>08.00 - 21.00</span>
                                    </th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($rekapBulanIni['rows'] as $row)

                                    <tr
                                        class="rekap-row {{ in_array($row['hari'], ['Sabtu', 'Minggu']) ? 'weekend' : '' }}"
                                        data-status="{{ $row['status'] }}"
                                        data-disetujui="{{ ($row['adaDisetujui'] ?? false) ? '1' : '0' }}"
                                        data-menunggu="{{ ($row['adaMenunggu'] ?? false) ? '1' : '0' }}"
                                        data-ditolak="{{ ($row['adaDitolak'] ?? false) ? '1' : '0' }}"
                                        data-booking="{{ ($row['adaBooking'] ?? false) ? '1' : '0' }}"
                                        data-tanggal="{{ $row['key'] }}"
                                    >
                                        <td class="col-tanggal">
                                            {{ $row['tanggal'] }}
                                        </td>

                                        <td class="col-hari">
                                            {{ $row['hari'] }}
                                        </td>

                                        <td class="{{ $row['pagiStatus'] ? 'cell-' . $row['pagiStatus'] : '' }}">
                                            {{ $row['pagi'] }}
                                            @if($row['pagiStatus'])
                                                <small class="rekap-cell-status">{{ ucfirst($row['pagiStatus']) }}</small>
                                            @endif
                                        </td>

                                        <td class="{{ $row['siangStatus'] ? 'cell-' . $row['siangStatus'] : '' }}">
                                            {{ $row['siang'] }}
                                            @if($row['siangStatus'])
                                                <small class="rekap-cell-status">{{ ucfirst($row['siangStatus']) }}</small>
                                            @endif
                                        </td>

                                        <td class="{{ $row['malamStatus'] ? 'cell-' . $row['malamStatus'] : '' }}">
                                            {{ $row['malam'] }}
                                            @if($row['malamStatus'])
                                                <small class="rekap-cell-status">{{ ucfirst($row['malamStatus']) }}</small>
                                            @endif
                                        </td>

                                        @php
                                            $fullDayNama = $row['fullDay'] ?? '';
                                            $fullDayStatus = $row['fullDayStatus'] ?? '';
                                        @endphp
                                        <td class="{{ $fullDayStatus ? 'cell-' . $fullDayStatus : '' }}">
                                            {{ $fullDayNama }}
                                            @if($fullDayStatus)
                                                <small class="rekap-cell-status">{{ ucfirst($fullDayStatus) }}</small>
                                            @endif
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6" class="rekap-empty-note">
                                            Belum ada data untuk ditampilkan.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        @endif

    </section>

</div>


<script>

    document
        .querySelectorAll('.filter-btn')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    document
                        .querySelectorAll('.filter-btn')
                        .forEach(function (item) {
                            item.classList.remove('active');
                        });

                    button.classList.add('active');

                    var filter = button.dataset.filter;

                    document
                        .querySelectorAll('.rekap-row')
                        .forEach(function (row) {

                            var status = row.dataset.status;
                            var disetujui = row.dataset.disetujui;
                            var menunggu = row.dataset.menunggu;
                            var ditolak = row.dataset.ditolak;
                            var booking = row.dataset.booking;

                            var tampil;

                            if (filter === 'all') {
                                tampil = true;
                            } else if (filter === 'disetujui') {
                                tampil = (disetujui === '1');
                            } else if (filter === 'menunggu') {
                                tampil = (menunggu === '1');
                            } else if (filter === 'ditolak') {
                                tampil = (ditolak === '1');
                            } else if (filter === 'kosong') {
                                tampil = (booking !== '1');
                            } else {
                                tampil = (status === filter);
                            }

                            row.classList.toggle(
                                'hidden-by-filter',
                                !tampil
                            );

                        });

                }
            );

        });

</script>

@endsection