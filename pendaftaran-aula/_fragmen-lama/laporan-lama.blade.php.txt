@extends('layouts.app')

@section('title', 'Laporan Pengajuan | SAPA')

@section('content')

<style>
    .laporan-page {
        max-width: 1250px;
        margin: 0 auto;
    }

    /* =========================
       HEADER
    ========================= */
    .laporan-header {
        background: linear-gradient(135deg, #12355b, #1d4f7a);
        border-radius: 16px;
        padding: 28px 30px;
        margin-bottom: 22px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .laporan-header::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 35px solid rgba(255, 255, 255, 0.05);
        right: -55px;
        top: -75px;
    }

    .header-content {
        position: relative;
        z-index: 1;
    }

    .header-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 8px;
        color: #bfdbfe;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.3px;
        text-transform: uppercase;
    }

    .laporan-header h1 {
        margin: 0 0 7px;
        font-size: 27px;
        font-weight: 750;
    }

    .laporan-header p {
        max-width: 700px;
        margin: 0;
        color: #dbeafe;
        font-size: 14px;
        line-height: 1.6;
    }

    /* =========================
       FILTER
    ========================= */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        padding: 22px;
        margin-bottom: 22px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
    }

    .filter-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .filter-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .filter-heading h2 {
        margin: 0;
        color: #12355b;
        font-size: 17px;
    }

    .filter-heading p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 7px;
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        min-height: 44px;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        background: #ffffff;
        color: #1e293b;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .filter-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
    }

    /* =========================
       BUTTON
    ========================= */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 10px 18px;
        border-radius: 9px;
        border: none;
        text-decoration: none;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-primary {
        background: #12355b;
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #0d2947;
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
    }

    .btn-print {
        background: #2563eb;
        color: #ffffff;
    }

    .btn-print:hover {
        background: #1d4ed8;
    }

    /* =========================
       REPORT CARD
    ========================= */
    .report-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .report-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 21px 22px;
        border-bottom: 1px solid #e2e8f0;
    }

    .report-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .report-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #12355b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .report-title h2 {
        margin: 0;
        color: #12355b;
        font-size: 18px;
    }

    .report-title p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    /* =========================
       TABLE
    ========================= */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
    }

    .report-table th {
        padding: 13px 12px;
        background: #f8fafc;
        color: #475569;
        text-align: left;
        font-size: 11px;
        font-weight: 750;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .report-table td {
        padding: 14px 12px;
        color: #334155;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
        line-height: 1.5;
    }

    .report-table tbody tr:hover {
        background: #f8fafc;
    }

    .number-cell {
        width: 45px;
        color: #64748b;
        font-weight: 700;
        text-align: center;
    }

    .nama {
        color: #12355b;
        font-weight: 750;
        white-space: nowrap;
    }

    .sub-text {
        margin-top: 3px;
        color: #64748b;
        font-size: 11px;
    }

    .aula-name {
        color: #334155;
        font-weight: 700;
        white-space: nowrap;
    }

    .date-text {
        color: #334155;
        font-weight: 600;
        white-space: nowrap;
    }

    /* =========================
       TIME
    ========================= */
    .time-badge {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 115px;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.4;
        white-space: nowrap;
    }

    .time-name {
        font-size: 11px;
        font-weight: 800;
    }

    .time-range {
        margin-top: 2px;
        font-size: 10px;
        font-weight: 600;
    }

    .time-pagi {
        background: #fef3c7;
        color: #92400e;
    }

    .time-siang {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .time-malam {
        background: #ede9fe;
        color: #6d28d9;
    }

    .time-default {
        background: #f1f5f9;
        color: #475569;
    }

    /* =========================
       PARTICIPANT
    ========================= */
    .participant {
        color: #334155;
        font-weight: 650;
        white-space: nowrap;
    }

    /* =========================
       PURPOSE
    ========================= */
    .purpose {
        max-width: 230px;
        color: #475569;
        line-height: 1.5;
    }

    /* =========================
       STATUS
    ========================= */
    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .status-disetujui {
        background: #dcfce7;
        color: #166534;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-dibatalkan {
        background: #e2e8f0;
        color: #475569;
    }

    /* =========================
       EMPTY
    ========================= */
    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 16px;
        border-radius: 16px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .empty-state h3 {
        margin: 0 0 7px;
        color: #334155;
        font-size: 18px;
    }

    .empty-state p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    /* =========================
       PRINT
    ========================= */
    .print-header {
        display: none;
    }

    @media (max-width: 950px) {
        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 650px) {
        .laporan-header {
            padding: 23px 20px;
        }

        .laporan-header h1 {
            font-size: 23px;
        }

        .filter-card {
            padding: 18px;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn {
            width: 100%;
        }

        .report-top {
            flex-direction: column;
            align-items: stretch;
        }

        .report-top .btn {
            width: 100%;
        }
    }

    @media print {
        body {
            background: #ffffff !important;
        }

        nav,
        .navbar,
        header,
        footer,
        .filter-card,
        .no-print {
            display: none !important;
        }

        .laporan-page {
            max-width: none;
            margin: 0;
            padding: 0;
        }

        .report-card {
            border: none;
            box-shadow: none;
            border-radius: 0;
        }

        .report-top {
            border: none;
            padding: 0 0 15px;
        }

        .report-title {
            display: none;
        }

        .print-header {
            display: block;
            text-align: center;
            margin-bottom: 18px;
        }

        .print-header h1 {
            margin: 0;
            font-size: 20px;
            color: #000000;
        }

        .print-header h2 {
            margin: 5px 0 0;
            font-size: 15px;
            color: #222222;
        }

        .print-header p {
            margin: 5px 0;
            font-size: 11px;
            color: #333333;
        }

        .report-table {
            min-width: 0;
            width: 100%;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #999999;
            padding: 7px;
            font-size: 9px;
        }

        .purpose {
            max-width: none;
        }

        .status {
            padding: 3px 6px;
            background: transparent !important;
            color: #000000 !important;
            font-size: 8px;
        }

        .status-dot {
            display: none;
        }

        .time-badge {
            background: transparent !important;
            color: #000000 !important;
            padding: 0;
        }
    }
</style>

<div class="laporan-page">

    {{-- =========================
         HEADER
    ========================= --}}
    <div class="laporan-header no-print">
        <div class="header-content">

            <div class="header-label">
                <span>▣</span>
                Administrator
            </div>

            <h1>
                Laporan Pengajuan Aula
            </h1>

            <p>
                Lihat, filter, dan cetak data pengajuan pemakaian aula
                berdasarkan periode, aula, dan status pengajuan.
            </p>

        </div>
    </div>


    {{-- =========================
         FILTER
    ========================= --}}
    <div class="filter-card no-print">

        <div class="filter-heading">

            <div class="filter-icon">
                ⚙
            </div>

            <div>
                <h2>
                    Filter Laporan
                </h2>

                <p>
                    Gunakan filter untuk menampilkan data yang dibutuhkan.
                </p>
            </div>

        </div>


        <form action="{{ route('admin.laporan') }}" method="GET">

            <div class="filter-grid">

                {{-- TANGGAL MULAI --}}
                <div class="form-group">

                    <label for="tanggal_mulai">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        id="tanggal_mulai"
                        name="tanggal_mulai"
                        value="{{ $tanggalMulai ?? '' }}"
                    >

                </div>


                {{-- TANGGAL SELESAI --}}
                <div class="form-group">

                    <label for="tanggal_selesai">
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        id="tanggal_selesai"
                        name="tanggal_selesai"
                        value="{{ $tanggalSelesai ?? '' }}"
                    >

                </div>


                {{-- AULA --}}
                <div class="form-group">

                    <label for="aula_id">
                        Aula
                    </label>

                    <select
                        id="aula_id"
                        name="aula_id"
                    >

                        <option value="">
                            Semua Aula
                        </option>

                        @foreach ($aulas as $aula)

                            <option
                                value="{{ $aula->id }}"
                                {{ (string) ($aulaId ?? '') === (string) $aula->id ? 'selected' : '' }}
                            >
                                {{ $aula->nama_aula }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}
                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="menunggu"
                            {{ ($status ?? '') === 'menunggu' ? 'selected' : '' }}
                        >
                            Menunggu
                        </option>

                        <option
                            value="disetujui"
                            {{ ($status ?? '') === 'disetujui' ? 'selected' : '' }}
                        >
                            Disetujui
                        </option>

                        <option
                            value="ditolak"
                            {{ ($status ?? '') === 'ditolak' ? 'selected' : '' }}
                        >
                            Ditolak
                        </option>

                    </select>

                </div>

            </div>


            {{-- ACTION --}}
            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    🔍 Tampilkan Laporan
                </button>

                <a
                    href="{{ route('admin.laporan') }}"
                    class="btn btn-secondary"
                >
                    ↻ Reset Filter
                </a>

            </div>

        </form>

    </div>


    {{-- =========================
         REPORT
    ========================= --}}
    <div class="report-card">

        {{-- =========================
             HEADER CETAK
        ========================= --}}
        <div class="print-header">

            <h1>
                LAPORAN PENDAFTARAN PEMAKAIAN AULA
            </h1>

            <h2>
                SAPA — Sistem Aplikasi Pemakaian Aula
            </h2>

            @if (($tanggalMulai ?? null) || ($tanggalSelesai ?? null))

                <p>

                    Periode:

                    {{ $tanggalMulai
                        ? \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y')
                        : '...' }}

                    -

                    {{ $tanggalSelesai
                        ? \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y')
                        : '...' }}

                </p>

            @endif

        </div>


        {{-- =========================
             REPORT HEADER
        ========================= --}}
        <div class="report-top">

            <div class="report-title">

                <div class="report-icon">
                    ▤
                </div>

                <div>

                    <h2>
                        Data Pengajuan
                    </h2>

                    <p>
                        Total
                        <strong>{{ $pendaftarans->count() }}</strong>
                        pengajuan ditemukan.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="btn btn-print no-print"
                onclick="window.print()"
            >
                🖨 Cetak Laporan
            </button>

        </div>


        {{-- =========================
             DATA
        ========================= --}}
        @if ($pendaftarans->count() > 0)

            <div class="table-wrapper">

                <table class="report-table">

                    <thead>

                        <tr>

                            <th style="width: 50px;">
                                No
                            </th>

                            <th>
                                Pemohon
                            </th>

                            <th>
                                Aula
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Waktu
                            </th>

                            <th>
                                Peserta
                            </th>

                            <th>
                                Keperluan
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($pendaftarans as $index => $pendaftaran)

                            <tr>

                                {{-- NO --}}
                                <td class="number-cell">
                                    {{ $index + 1 }}
                                </td>


                                {{-- PEMOHON --}}
                                <td>

                                    <div class="nama">
                                        {{ $pendaftaran->nama_pemohon }}
                                    </div>

                                    <div class="sub-text">
                                        NIP:
                                        {{ $pendaftaran->nip ?: '-' }}
                                    </div>

                                    <div class="sub-text">
                                        {{ $pendaftaran->jabatan ?: '-' }}
                                    </div>

                                </td>


                                {{-- AULA --}}
                                <td>

                                    <div class="aula-name">
                                        {{ $pendaftaran->aula->nama_aula ?? '-' }}
                                    </div>

                                </td>


                                {{-- TANGGAL --}}
                                <td>

                                    <div class="date-text">

                                        @if ($pendaftaran->tanggal_mulai == $pendaftaran->tanggal_selesai)

                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->format('d/m/Y') }}

                                        @else

                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->format('d/m/Y') }}

                                            -

                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)->format('d/m/Y') }}

                                        @endif

                                    </div>

                                </td>


                                {{-- WAKTU --}}
                                <td>

                                    @switch($pendaftaran->kriteria_waktu)

                                        @case('pagi_siang')

                                            <span class="time-badge time-pagi">

                                                <span class="time-name">
                                                    Pagi – Siang
                                                </span>

                                                <span class="time-range">
                                                    08.00 – 13.00
                                                </span>

                                            </span>

                                            @break


                                        @case('siang_sore')

                                            <span class="time-badge time-siang">

                                                <span class="time-name">
                                                    Siang – Sore
                                                </span>

                                                <span class="time-range">
                                                    14.00 – 16.00
                                                </span>

                                            </span>

                                            @break


                                        @case('malam')

                                            <span class="time-badge time-malam">

                                                <span class="time-name">
                                                    Malam
                                                </span>

                                                <span class="time-range">
                                                    18.00 – 21.00
                                                </span>

                                            </span>

                                            @break


                                        @default

                                            <span class="time-badge time-default">
                                                -
                                            </span>

                                    @endswitch

                                </td>


                                {{-- PESERTA --}}
                                <td>

                                    <div class="participant">

                                        {{ $pendaftaran->jumlah_peserta }}
                                        orang

                                    </div>

                                </td>


                                {{-- KEPERLUAN --}}
                                <td>

                                    <div class="purpose">

                                        {{ \Illuminate\Support\Str::limit(
                                            $pendaftaran->keperluan,
                                            60
                                        ) }}

                                    </div>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if ($pendaftaran->status === 'menunggu')

                                        <span class="status status-menunggu">

                                            <span class="status-dot"></span>

                                            Menunggu

                                        </span>

                                    @elseif ($pendaftaran->status === 'disetujui')

                                        <span class="status status-disetujui">

                                            <span class="status-dot"></span>

                                            Disetujui

                                        </span>

                                    @elseif ($pendaftaran->status === 'ditolak')

                                        <span class="status status-ditolak">

                                            <span class="status-dot"></span>

                                            Ditolak

                                        </span>

                                    @elseif ($pendaftaran->status === 'dibatalkan')

                                        <span class="status status-dibatalkan">

                                            <span class="status-dot"></span>

                                            Dibatalkan

                                        </span>

                                    @else

                                        <span class="status status-dibatalkan">

                                            <span class="status-dot"></span>

                                            {{ ucfirst($pendaftaran->status ?? '-') }}

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    📋
                </div>

                <h3>
                    Tidak Ada Data Pengajuan
                </h3>

                <p>
                    Tidak ditemukan pengajuan yang sesuai dengan filter yang dipilih.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection