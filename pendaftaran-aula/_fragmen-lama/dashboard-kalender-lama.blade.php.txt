@extends('layouts.app')

@section('title', 'Dashboard | SAPA')

@section('content')

<style>

    /* =====================================================
       DASHBOARD
    ===================================================== */

    .dashboard-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 40px 28px 60px;
    }

    .welcome-section {
        margin-bottom: 28px;
    }

    .welcome-section h1 {
        margin: 0;
        color: #12355b;
        font-size: 32px;
        font-weight: 800;
    }

    .welcome-section p {
        margin: 8px 0 0;
        color: #64748b;
        font-size: 16px;
    }


    /* =====================================================
       STATISTIK
    ===================================================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #dbe3ec;
        border-radius: 13px;
        padding: 22px;

        box-shadow:
            0 4px 14px rgba(15, 23, 42, .05);
    }

    .stat-label {
        color: #64748b;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .stat-number {
        color: #12355b;
        font-size: 30px;
        font-weight: 800;
    }


    /* =====================================================
       REKAP
    ===================================================== */

    .schedule-section {
        background: #ffffff;
        border: 1px solid #dbe3ec;
        border-radius: 15px;

        box-shadow:
            0 5px 18px rgba(15, 23, 42, .05);

        overflow: hidden;
    }

    .schedule-header {
        padding: 28px;
        border-bottom: 1px solid #e2e8f0;
    }

    .schedule-title {
        margin: 0;
        color: #12355b;
        font-size: 25px;
        font-weight: 800;
    }

    .schedule-description {
        margin: 7px 0 0;
        color: #64748b;
        font-size: 15px;
    }


    /* =====================================================
       PILIH AULA
    ===================================================== */

    .aula-selector {
        padding: 22px 28px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .aula-selector-title {
        margin-bottom: 10px;
        color: #334155;
        font-size: 14px;
        font-weight: 800;
    }

    .aula-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .aula-btn {
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;

        border-radius: 9px;
        padding: 11px 20px;

        font-size: 15px;
        font-weight: 750;

        cursor: pointer;
        transition: .2s ease;
    }

    .aula-btn:hover {
        border-color: #12355b;
        color: #12355b;
    }

    .aula-btn.active {
        background: #12355b;
        border-color: #12355b;
        color: #ffffff;
    }


    /* =====================================================
       FILTER
    ===================================================== */

    .filter-area {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 8px;

        margin-top: 20px;
    }

    .filter-label {
        color: #334155;
        font-size: 14px;
        font-weight: 800;
        margin-right: 3px;
    }

    .filter-btn {
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;

        border-radius: 8px;
        padding: 9px 13px;

        font-size: 14px;
        font-weight: 700;

        cursor: pointer;
        transition: .2s ease;
    }

    .filter-btn:hover {
        border-color: #12355b;
        color: #12355b;
    }

    .filter-btn.active {
        background: #12355b;
        border-color: #12355b;
        color: #ffffff;
    }

    .filter-dot {
        display: inline-block;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        margin-right: 5px;
    }

    .dot-empty {
        background: #16a34a;
    }

    .dot-used {
        background: #2563eb;
    }

    .dot-full {
        background: #dc2626;
    }


    /* =====================================================
       NAVIGASI BULAN
    ===================================================== */

    .month-navigation {
        margin: 20px 28px;

        padding: 9px;

        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;

        background: #f8fafc;
        border: 1px solid #dbe3ec;
        border-radius: 10px;
    }

    .month-navigation a {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 40px;

        padding: 8px 14px;

        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;

        color: #12355b;
        text-decoration: none;

        font-size: 14px;
        font-weight: 750;

        transition: .2s ease;
    }

    .month-navigation a:hover {
        background: #12355b;
        border-color: #12355b;
        color: #ffffff;
    }

    .month-navigation a:first-child {
        justify-self: start;
    }

    .month-navigation a:last-child {
        justify-self: end;
    }

    .month-title {
        color: #12355b;
        font-size: 20px;
        font-weight: 800;
        text-align: center;
    }


    /* =====================================================
       CALENDAR
    ===================================================== */

    .calendar-wrapper {
        padding: 0 28px 30px;
        overflow-x: auto;
    }

    .calendar {
        min-width: 850px;

        border: 1px solid #dbe3ec;
        border-radius: 10px;

        overflow: hidden;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);

        background: #12355b;
    }

    .weekday {
        min-height: 47px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #ffffff;

        font-size: 14px;
        font-weight: 800;

        border-right: 1px solid
            rgba(255,255,255,.12);
    }

    .weekday:last-child {
        border-right: none;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
    }

    .calendar-day {
        min-height: 155px;

        padding: 10px;

        background: #ffffff;

        border-right: 1px solid #dbe3ec;
        border-bottom: 1px solid #dbe3ec;
    }

    .calendar-day:nth-child(7n) {
        border-right: none;
    }

    .calendar-day.empty-day {
        background: #f8fafc;
    }

    .calendar-day.hidden-by-filter {
        display: none;
    }

    .day-number {
        display: flex;
        align-items: center;
        justify-content: space-between;

        margin-bottom: 8px;
    }

    .day-number strong {
        color: #12355b;
        font-size: 17px;
        font-weight: 800;
    }

    .today-label {
        padding: 3px 6px;

        background: #12355b;
        color: #ffffff;

        border-radius: 5px;

        font-size: 10px;
        font-weight: 800;
    }


    /* =====================================================
       SLOT
    ===================================================== */

    .slot-list {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .slot {
        width: 100%;

        border: 1px solid;

        border-radius: 6px;

        padding: 7px;

        text-align: left;

        cursor: pointer;

        font-size: 11px;
        line-height: 1.35;
        font-weight: 750;

        transition: .18s ease;
    }

    .slot:hover {
        transform: translateY(-1px);

        box-shadow:
            0 2px 7px
            rgba(15,23,42,.12);
    }

    .slot-empty {
        background: #f0fdf4;
        border-color: #86efac;
        color: #166534;
    }

    .slot-empty:hover {
        background: #dcfce7;
    }

    .slot-used {
        background: #eff6ff;
        border-color: #93c5fd;
        color: #1d4ed8;
    }

    .slot-used:hover {
        background: #dbeafe;
    }

    .slot-full {
        background: #fef2f2;
        border-color: #fca5a5;
        color: #b91c1c;
    }

    .slot-name {
        display: block;
        font-size: 11px;
        font-weight: 800;
    }

    .slot-time {
        display: block;
        margin-top: 2px;
        font-size: 10px;
    }

    .all-used-badge {
        width: 100%;

        border: none;
        border-radius: 6px;

        background: #fee2e2;
        color: #b91c1c;

        padding: 7px;

        font-size: 10px;
        font-weight: 800;

        cursor: pointer;
    }


    /* =====================================================
       MODAL
    ===================================================== */

    .modal-overlay {
        position: fixed;
        inset: 0;

        z-index: 9999;

        display: none;
        align-items: center;
        justify-content: center;

        padding: 20px;

        background:
            rgba(15,23,42,.58);

        backdrop-filter: blur(3px);
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-card {
        width: min(620px, 100%);
        max-height: 90vh;

        overflow-y: auto;

        background: #ffffff;

        border-radius: 15px;

        box-shadow:
            0 20px 60px
            rgba(15,23,42,.25);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;

        padding: 22px 24px;

        border-bottom: 1px solid #e2e8f0;
    }

    .modal-header h3 {
        margin: 0;

        color: #12355b;

        font-size: 20px;
        font-weight: 800;
    }

    .modal-close {
        width: 34px;
        height: 34px;

        border: none;
        border-radius: 7px;

        background: #f1f5f9;
        color: #475569;

        font-size: 20px;

        cursor: pointer;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-status {
        display: inline-flex;

        padding: 6px 10px;

        border-radius: 6px;

        font-size: 12px;
        font-weight: 800;

        margin-bottom: 17px;
    }

    .status-empty {
        background: #dcfce7;
        color: #166534;
    }

    .status-used {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-full {
        background: #fee2e2;
        color: #b91c1c;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 150px 1fr;

        gap: 10px 15px;
    }

    .detail-label {
        color: #64748b;

        font-size: 14px;
        font-weight: 700;
    }

    .detail-value {
        color: #1e293b;

        font-size: 14px;
        font-weight: 600;

        line-height: 1.5;
    }

    .booking-divider {
        height: 1px;

        background: #e2e8f0;

        margin: 20px 0;
    }

    .modal-note {
        padding: 12px 14px;

        background: #f8fafc;

        border: 1px solid #e2e8f0;
        border-radius: 8px;

        color: #475569;

        font-size: 13px;
        line-height: 1.6;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;

        gap: 9px;

        margin-top: 20px;
    }

    .modal-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 10px 16px;

        border-radius: 8px;

        font-size: 14px;
        font-weight: 750;

        text-decoration: none;

        cursor: pointer;
    }

    .modal-button-primary {
        background: #12355b;
        color: #ffffff;

        border: 1px solid #12355b;
    }

    .modal-button-secondary {
        background: #ffffff;
        color: #475569;

        border: 1px solid #cbd5e1;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 900px) {

        .dashboard-page {
            padding-left: 18px;
            padding-right: 18px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }


    @media (max-width: 600px) {

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .schedule-header {
            padding: 22px 18px;
        }

        .aula-selector {
            padding: 20px 18px;
        }

        .month-navigation {
            margin-left: 18px;
            margin-right: 18px;

            grid-template-columns: 1fr;

            gap: 8px;
        }

        .month-navigation a:first-child,
        .month-navigation a:last-child {
            justify-self: stretch;
        }

        .calendar-wrapper {
            padding-left: 18px;
            padding-right: 18px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 3px;
        }

        .detail-label {
            margin-top: 8px;
        }

    }

</style>


<div class="dashboard-page">


    {{-- =================================================
         WELCOME
    ================================================== --}}

    <section class="welcome-section">

        <h1>
            Selamat Datang, {{ Auth::user()->name }}
        </h1>

        <p>
            Kelola pemanfaatan aula dan lihat jadwal kegiatan melalui SAPA.
        </p>

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


        <div class="stat-card">

            <div class="stat-label">
                Menunggu
            </div>

            <div class="stat-number">
                {{ $menunggu }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Disetujui
            </div>

            <div class="stat-number">
                {{ $disetujui }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Ditolak
            </div>

            <div class="stat-number">
                {{ $ditolak }}
            </div>

        </div>

    </section>


    {{-- =================================================
         REKAP
    ================================================== --}}

    <section class="schedule-section">


        {{-- HEADER --}}

        <div class="schedule-header">

            <h2 class="schedule-title">
                Rekap Ketersediaan Aula
            </h2>

            <p class="schedule-description">
                Pilih aula dan lihat waktu yang masih kosong sebelum
                melakukan pendaftaran.
            </p>


            {{-- FILTER --}}

            <div class="filter-area">

                <span class="filter-label">
                    Tampilkan:
                </span>


                <button
                    type="button"
                    class="filter-btn active"
                    data-filter="all"
                    onclick="setFilter('all')"
                >
                    Semua
                </button>


                <button
                    type="button"
                    class="filter-btn"
                    data-filter="empty"
                    onclick="setFilter('empty')"
                >
                    <span class="filter-dot dot-empty"></span>
                    Kosong
                </button>


                <button
                    type="button"
                    class="filter-btn"
                    data-filter="used"
                    onclick="setFilter('used')"
                >
                    <span class="filter-dot dot-used"></span>
                    Terpakai
                </button>


                <button
                    type="button"
                    class="filter-btn"
                    data-filter="full"
                    onclick="setFilter('full')"
                >
                    <span class="filter-dot dot-full"></span>
                    Semua Waktu Terpakai
                </button>

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

                @foreach($aulas as $index => $aula)

                    <button
                        type="button"
                        class="aula-btn {{ $index === 0 ? 'active' : '' }}"
                        data-aula-id="{{ $aula->id }}"
                        onclick="selectAula(
                            {{ $aula->id }},
                            this
                        )"
                    >
                        {{ $aula->nama_aula }}
                    </button>

                @endforeach

            </div>

        </div>


        {{-- =================================================
             BULAN
        ================================================== --}}

        <div class="month-navigation">

            <a
                href="{{ route(
                    'dashboard',
                    ['bulan' => $bulanSebelumnya]
                ) }}"
            >
                ← Bulan Sebelumnya
            </a>


            <div class="month-title">
                {{ $judulBulan }}
            </div>


            <a
                href="{{ route(
                    'dashboard',
                    ['bulan' => $bulanBerikutnya]
                ) }}"
            >
                Bulan Berikutnya →
            </a>

        </div>


        {{-- =================================================
             CALENDAR
        ================================================== --}}

        <div class="calendar-wrapper">

            <div class="calendar">

                <div class="calendar-weekdays">

                    <div class="weekday">
                        Senin
                    </div>

                    <div class="weekday">
                        Selasa
                    </div>

                    <div class="weekday">
                        Rabu
                    </div>

                    <div class="weekday">
                        Kamis
                    </div>

                    <div class="weekday">
                        Jumat
                    </div>

                    <div class="weekday">
                        Sabtu
                    </div>

                    <div class="weekday">
                        Minggu
                    </div>

                </div>


                <div
                    id="calendarGrid"
                    class="calendar-grid"
                >
                </div>

            </div>

        </div>

    </section>

</div>


{{-- =====================================================
     MODAL
===================================================== --}}

<div
    id="scheduleModal"
    class="modal-overlay"
    onclick="closeModalOutside(event)"
>

    <div
        class="modal-card"
        onclick="event.stopPropagation()"
    >

        <div class="modal-header">

            <h3 id="modalTitle">
                Detail Jadwal
            </h3>

            <button
                type="button"
                class="modal-close"
                onclick="closeModal()"
            >
                ×
            </button>

        </div>


        <div
            id="modalBody"
            class="modal-body"
        >
        </div>

    </div>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | DATA DARI CONTROLLER
    |--------------------------------------------------------------------------
    */

    const semuaAula =
        @json($aulas);

    const jadwalData =
        @json($jadwal);

    const detailJadwalData =
        @json($detailJadwal);


    /*
    |--------------------------------------------------------------------------
    | INFORMASI BULAN
    |--------------------------------------------------------------------------
    */

    const tahun =
        {{ $awalBulan->year }};

    const bulan =
        {{ $awalBulan->month }};


    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let selectedAulaId =
        semuaAula.length > 0
            ? Number(semuaAula[0].id)
            : null;

    let selectedFilter =
        'all';


    /*
    |--------------------------------------------------------------------------
    | WAKTU
    |--------------------------------------------------------------------------
    */

    const daftarWaktu = [

        {
            key: 'pagi_siang',
            nama: 'Pagi – Siang',
            jam: '08.00 – 13.00'
        },

        {
            key: 'siang_sore',
            nama: 'Siang – Sore',
            jam: '14.00 – 16.00'
        },

        {
            key: 'malam',
            nama: 'Malam',
            jam: '18.00 – 21.00'
        }

    ];


    /*
    |--------------------------------------------------------------------------
    | PILIH AULA
    |--------------------------------------------------------------------------
    */

    function selectAula(
        aulaId,
        button
    ) {

        selectedAulaId =
            Number(aulaId);


        document
            .querySelectorAll('.aula-btn')
            .forEach(function(btn) {

                btn.classList.remove(
                    'active'
                );

            });


        button.classList.add(
            'active'
        );


        renderCalendar();
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    function setFilter(
        filter
    ) {

        selectedFilter =
            filter;


        document
            .querySelectorAll('.filter-btn')
            .forEach(function(btn) {

                btn.classList.remove(
                    'active'
                );

            });


        const button =
            document.querySelector(
                '.filter-btn[data-filter="' +
                filter +
                '"]'
            );


        if (button) {

            button.classList.add(
                'active'
            );

        }


        renderCalendar();
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL JADWAL
    |--------------------------------------------------------------------------
    */

    function getUsedSlots(
        aulaId,
        date
    ) {

        if (
            !jadwalData[aulaId] ||
            !jadwalData[aulaId][date]
        ) {
            return [];
        }


        return jadwalData[aulaId][date];
    }


    /*
    |--------------------------------------------------------------------------
    | CEK STATUS TANGGAL
    |--------------------------------------------------------------------------
    */

    function getDateStatus(
        aulaId,
        date
    ) {

        const used =
            getUsedSlots(
                aulaId,
                date
            );


        const jumlah =
            used.length;


        if (jumlah >= 3) {

            return 'full';

        }


        if (jumlah > 0) {

            return 'used';

        }


        return 'empty';
    }


    /*
    |--------------------------------------------------------------------------
    | BUAT CALENDAR
    |--------------------------------------------------------------------------
    */

    function renderCalendar() {

        const calendarGrid =
            document.getElementById(
                'calendarGrid'
            );


        calendarGrid.innerHTML =
            '';


        if (!selectedAulaId) {

            calendarGrid.innerHTML = `
                <div style="
                    grid-column:1/-1;
                    padding:40px;
                    text-align:center;
                    color:#64748b;
                ">
                    Belum ada data aula.
                </div>
            `;

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | HARI PERTAMA
        |--------------------------------------------------------------------------
        */

        const firstDate =
            new Date(
                tahun,
                bulan - 1,
                1
            );


        /*
        |--------------------------------------------------------------------------
        | HARI TERAKHIR
        |--------------------------------------------------------------------------
        */

        const lastDate =
            new Date(
                tahun,
                bulan,
                0
            );


        const jumlahHari =
            lastDate.getDate();


        /*
        |--------------------------------------------------------------------------
        | Senin = 0
        |--------------------------------------------------------------------------
        */

        let offset =
            firstDate.getDay() - 1;


        if (offset < 0) {

            offset = 6;

        }


        /*
        |--------------------------------------------------------------------------
        | KOTAK SEBELUM TANGGAL 1
        |--------------------------------------------------------------------------
        */

        for (
            let i = 0;
            i < offset;
            i++
        ) {

            const empty =
                document.createElement(
                    'div'
                );

            empty.className =
                'calendar-day empty-day';

            calendarGrid.appendChild(
                empty
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SEMUA TANGGAL
        |--------------------------------------------------------------------------
        */

        for (
            let hari = 1;
            hari <= jumlahHari;
            hari++
        ) {

            const date =
                new Date(
                    tahun,
                    bulan - 1,
                    hari
                );


            const dateKey =
                formatDateKey(
                    date
                );


            const status =
                getDateStatus(
                    selectedAulaId,
                    dateKey
                );


            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            let tampil =
                true;


            if (
                selectedFilter ===
                'empty'
            ) {

                tampil =
                    status === 'empty' ||
                    status === 'used';

            }


            if (
                selectedFilter ===
                'used'
            ) {

                tampil =
                    status === 'used' ||
                    status === 'full';

            }


            if (
                selectedFilter ===
                'full'
            ) {

                tampil =
                    status === 'full';

            }


            /*
            |--------------------------------------------------------------------------
            | CELL
            |--------------------------------------------------------------------------
            */

            const cell =
                document.createElement(
                    'div'
                );


            cell.className =
                'calendar-day';


            if (!tampil) {

                cell.style.display =
                    'none';

            }


            /*
            |--------------------------------------------------------------------------
            | HARI INI
            |--------------------------------------------------------------------------
            */

            const today =
                new Date();


            const isToday =
                today.getFullYear() ===
                    tahun &&
                today.getMonth() ===
                    bulan - 1 &&
                today.getDate() ===
                    hari;


            /*
            |--------------------------------------------------------------------------
            | HEADER TANGGAL
            |--------------------------------------------------------------------------
            */

            cell.innerHTML = `

                <div class="day-number">

                    <strong>
                        ${hari}
                    </strong>

                    ${
                        isToday
                            ? `
                                <span class="today-label">
                                    HARI INI
                                </span>
                              `
                            : ''
                    }

                </div>

                <div class="slot-list"></div>

            `;


            const slotList =
                cell.querySelector(
                    '.slot-list'
                );


            /*
            |--------------------------------------------------------------------------
            | 3 WAKTU
            |--------------------------------------------------------------------------
            */

            daftarWaktu.forEach(
                function(waktu) {

                    const usedSlots =
                        getUsedSlots(
                            selectedAulaId,
                            dateKey
                        );


                    const used =
                        usedSlots.includes(
                            waktu.key
                        );


                    const slot =
                        document.createElement(
                            'button'
                        );


                    slot.type =
                        'button';


                    slot.className =
                        'slot ' +
                        (
                            used
                                ? 'slot-used'
                                : 'slot-empty'
                        );


                    slot.dataset.status =
                        used
                            ? 'used'
                            : 'empty';


                    slot.innerHTML = `

                        <span class="slot-name">
                            ${
                                used
                                    ? 'TERPAKAI'
                                    : 'KOSONG'
                            }
                        </span>

                        <span class="slot-time">
                            ${waktu.nama}
                            (${waktu.jam})
                        </span>

                    `;


                    slot.addEventListener(
                        'click',
                        function() {

                            showSlotDetail(
                                selectedAulaId,
                                dateKey,
                                waktu.key
                            );

                        }
                    );


                    slotList.appendChild(
                        slot
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | SEMUA WAKTU TERPAKAI
            |--------------------------------------------------------------------------
            */

            if (
                status === 'full'
            ) {

                const fullButton =
                    document.createElement(
                        'button'
                    );


                fullButton.type =
                    'button';


                fullButton.className =
                    'all-used-badge';


                fullButton.textContent =
                    'SEMUA WAKTU TERPAKAI';


                fullButton.addEventListener(
                    'click',
                    function() {

                        showAllUsed(
                            selectedAulaId,
                            dateKey
                        );

                    }
                );


                slotList.appendChild(
                    fullButton
                );

            }


            calendarGrid.appendChild(
                cell
            );

        }


        /*
        |--------------------------------------------------------------------------
        | KOTAK SETELAH AKHIR BULAN
        |--------------------------------------------------------------------------
        */

        const totalCell =
            offset + jumlahHari;


        const sisa =
            (7 - (
                totalCell % 7
            )) % 7;


        for (
            let i = 0;
            i < sisa;
            i++
        ) {

            const empty =
                document.createElement(
                    'div'
                );

            empty.className =
                'calendar-day empty-day';

            calendarGrid.appendChild(
                empty
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT TANGGAL
    |--------------------------------------------------------------------------
    */

    function formatDateKey(
        date
    ) {

        const year =
            date.getFullYear();


        const month =
            String(
                date.getMonth() + 1
            ).padStart(
                2,
                '0'
            );


        const day =
            String(
                date.getDate()
            ).padStart(
                2,
                '0'
            );


        return (
            year +
            '-' +
            month +
            '-' +
            day
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL SLOT
    |--------------------------------------------------------------------------
    */

    function showSlotDetail(
        aulaId,
        date,
        criteria
    ) {

        const aula =
            semuaAula.find(
                function(item) {

                    return Number(
                        item.id
                    ) === Number(
                        aulaId
                    );

                }
            );


        const detail =
            detailJadwalData[aulaId] &&
            detailJadwalData[aulaId][date] &&
            detailJadwalData[aulaId][date][criteria]
                ? detailJadwalData[aulaId][date][criteria]
                : null;


        const waktu =
            daftarWaktu.find(
                function(item) {

                    return item.key ===
                        criteria;

                }
            );


        const tanggal =
            formatTanggalIndonesia(
                date
            );


        document.getElementById(
            'modalTitle'
        ).textContent =
            aula?.nama_aula ??
            'Detail Jadwal';


        const modalBody =
            document.getElementById(
                'modalBody'
            );


        /*
        |--------------------------------------------------------------------------
        | KOSONG
        |--------------------------------------------------------------------------
        */

        if (!detail) {

            const url =
                '{{ url('/pendaftaran') }}/' +
                aulaId;


            modalBody.innerHTML = `

                <span class="modal-status status-empty">
                    KOSONG
                </span>


                <div class="detail-grid">

                    <div class="detail-label">
                        Aula
                    </div>

                    <div class="detail-value">
                        ${escapeHtml(
                            aula?.nama_aula ?? '-'
                        )}
                    </div>


                    <div class="detail-label">
                        Tanggal
                    </div>

                    <div class="detail-value">
                        ${tanggal}
                    </div>


                    <div class="detail-label">
                        Waktu
                    </div>

                    <div class="detail-value">
                        ${escapeHtml(
                            waktu.nama
                        )}
                        (${escapeHtml(
                            waktu.jam
                        )})
                    </div>

                </div>


                <div class="booking-divider"></div>


                <div class="modal-note">

                    Waktu ini masih kosong.
                    Kamu dapat memilih waktu ini
                    untuk melakukan pendaftaran.

                </div>


                <div class="modal-actions">

                    <button
                        type="button"
                        class="modal-button modal-button-secondary"
                        onclick="closeModal()"
                    >
                        Tutup
                    </button>


                    <a
                        href="${url}"
                        class="modal-button modal-button-primary"
                    >
                        Daftar Menggunakan Aula Ini
                    </a>

                </div>

            `;


            openModal();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | TERPAKAI
        |--------------------------------------------------------------------------
        */

        modalBody.innerHTML = `

            <span class="modal-status status-used">
                TERPAKAI
            </span>


            <div class="detail-grid">

                <div class="detail-label">
                    Aula
                </div>

                <div class="detail-value">
                    ${escapeHtml(
                        detail.nama_aula ?? '-'
                    )}
                </div>


                <div class="detail-label">
                    Tanggal
                </div>

                <div class="detail-value">
                    ${escapeHtml(
                        detail.tanggal ??
                        tanggal
                    )}
                </div>


                <div class="detail-label">
                    Waktu
                </div>

                <div class="detail-value">
                    ${escapeHtml(
                        detail.waktu ??
                        waktu.nama
                    )}
                </div>


                <div class="detail-label">
                    Pemohon
                </div>

                <div class="detail-value">
                    ${escapeHtml(
                        detail.nama_pemohon ??
                        '-'
                    )}
                </div>


                <div class="detail-label">
                    Instansi
                </div>

                <div class="detail-value">
                    ${escapeHtml(
                        detail.instansi ??
                        '-'
                    )}
                </div>


                <div class="detail-label">
                    Jumlah Peserta
                </div>

                <div class="detail-value">
                    ${escapeHtml(
                        String(
                            detail.jumlah_peserta ??
                            '-'
                        )
                    )}
                    orang
                </div>


                <div class="detail-label">
                    Keperluan
                </div>

                <div class="detail-value">
                    ${escapeHtml(
                        detail.keperluan ??
                        '-'
                    )}
                </div>

            </div>


            <div class="modal-actions">

                <button
                    type="button"
                    class="modal-button modal-button-secondary"
                    onclick="closeModal()"
                >
                    Tutup
                </button>

            </div>

        `;


        openModal();
    }


    /*
    |--------------------------------------------------------------------------
    | SEMUA WAKTU TERPAKAI
    |--------------------------------------------------------------------------
    */

    function showAllUsed(
        aulaId,
        date
    ) {

        const aula =
            semuaAula.find(
                function(item) {

                    return Number(
                        item.id
                    ) === Number(
                        aulaId
                    );

                }
            );


        const details =
            detailJadwalData[aulaId] &&
            detailJadwalData[aulaId][date]
                ? detailJadwalData[aulaId][date]
                : {};


        let html = `

            <span class="modal-status status-full">
                SEMUA WAKTU TERPAKAI
            </span>


            <div class="detail-grid">

                <div class="detail-label">
                    Aula
                </div>

                <div class="detail-value">
                    ${escapeHtml(
                        aula?.nama_aula ?? '-'
                    )}
                </div>


                <div class="detail-label">
                    Tanggal
                </div>

                <div class="detail-value">
                    ${formatTanggalIndonesia(
                        date
                    )}
                </div>

            </div>


            <div class="booking-divider"></div>

        `;


        daftarWaktu.forEach(
            function(waktu) {

                const detail =
                    details[waktu.key];


                if (!detail) {
                    return;
                }


                html += `

                    <div
                        style="
                            padding:14px;
                            margin-bottom:10px;
                            background:#f8fafc;
                            border:1px solid #e2e8f0;
                            border-radius:9px;
                        "
                    >

                        <div
                            style="
                                color:#12355b;
                                font-size:14px;
                                font-weight:800;
                                margin-bottom:7px;
                            "
                        >
                            ${waktu.nama}
                            (${waktu.jam})
                        </div>


                        <div
                            style="
                                color:#475569;
                                font-size:13px;
                                line-height:1.7;
                            "
                        >

                            <strong>
                                Pemohon:
                            </strong>

                            ${escapeHtml(
                                detail.nama_pemohon ??
                                '-'
                            )}

                            <br>


                            <strong>
                                Keperluan:
                            </strong>

                            ${escapeHtml(
                                detail.keperluan ??
                                '-'
                            )}

                        </div>

                    </div>

                `;

            }
        );


        html += `

            <div class="modal-actions">

                <button
                    type="button"
                    class="modal-button modal-button-secondary"
                    onclick="closeModal()"
                >
                    Tutup
                </button>

            </div>

        `;


        document.getElementById(
            'modalTitle'
        ).textContent =
            aula?.nama_aula ??
            'Detail Jadwal';


        document.getElementById(
            'modalBody'
        ).innerHTML =
            html;


        openModal();
    }


    /*
    |--------------------------------------------------------------------------
    | TANGGAL INDONESIA
    |--------------------------------------------------------------------------
    */

    function formatTanggalIndonesia(
        dateString
    ) {

        const date =
            new Date(
                dateString +
                'T00:00:00'
            );


        return date.toLocaleDateString(
            'id-ID',
            {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(
        value
    ) {

        return String(value)
            .replace(
                /&/g,
                '&amp;'
            )
            .replace(
                /</g,
                '&lt;'
            )
            .replace(
                />/g,
                '&gt;'
            )
            .replace(
                /"/g,
                '&quot;'
            )
            .replace(
                /'/g,
                '&#039;'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MODAL
    |--------------------------------------------------------------------------
    */

    function openModal() {

        document
            .getElementById(
                'scheduleModal'
            )
            .classList.add(
                'show'
            );


        document.body.style.overflow =
            'hidden';
    }


    function closeModal() {

        document
            .getElementById(
                'scheduleModal'
            )
            .classList.remove(
                'show'
            );


        document.body.style.overflow =
            '';
    }


    function closeModalOutside(
        event
    ) {

        if (
            event.target.id ===
            'scheduleModal'
        ) {

            closeModal();

        }
    }


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key ===
                'Escape'
            ) {

                closeModal();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | LOAD
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            renderCalendar();

        }
    );

</script>

@endsection