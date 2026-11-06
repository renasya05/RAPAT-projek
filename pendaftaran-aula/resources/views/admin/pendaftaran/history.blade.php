@extends('layouts.app')

@section('title', 'Riwayat Pendaftaran | RAPAT')

@section('content')

<style>
    .history-page {
        max-width: 1250px;
        margin: 0 auto;
    }

    /* HEADER */
    .page-header {
        margin-bottom: 22px;
    }

    .page-header h1 {
        margin: 0 0 7px;
        color: #12355b;
        font-size: 27px;
        font-weight: 750;
    }

    .page-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    /* FILTER */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 22px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 14px;
        align-items: end;
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

    .form-group select {
        width: 100%;
        min-height: 43px;
        padding: 9px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #ffffff;
        color: #1e293b;
        font-family: inherit;
        font-size: 13px;
        outline: none;
    }

    .form-group select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .filter-btn {
        min-height: 43px;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        background: #12355b;
        color: #ffffff;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .filter-btn:hover {
        background: #0d2947;
    }

    /* TABLE CARD */
    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 22px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-header-title {
        color: #12355b;
        font-size: 17px;
        font-weight: 750;
    }

    .table-header-subtitle {
        margin-top: 4px;
        color: #64748b;
        font-size: 12px;
    }

    .total-data {
        padding: 7px 12px;
        border-radius: 20px;
        background: #eef4fa;
        color: #12355b;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* TABLE */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 1150px;
        border-collapse: collapse;
    }

    thead {
        background: #12355b;
        color: #ffffff;
    }

    th {
        padding: 13px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    td {
        padding: 14px;
        border-bottom: 1px solid #eef2f6;
        color: #334155;
        font-size: 12px;
        vertical-align: top;
        line-height: 1.5;
    }

    tbody tr:hover {
        background: #f8fafc;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .number {
        text-align: center;
        color: #64748b;
        font-weight: 700;
    }

    /* PEMOHON */
    .applicant-name {
        color: #12355b;
        font-weight: 750;
        white-space: nowrap;
    }

    .sub-text {
        margin-top: 3px;
        color: #64748b;
        font-size: 11px;
    }

    /* UNIT */
    .unit {
        max-width: 220px;
        color: #475569;
        line-height: 1.5;
    }

    .section-text {
        margin-top: 3px;
        color: #64748b;
        font-size: 11px;
    }

    /* AULA */
    .aula-name {
        color: #12355b;
        font-weight: 700;
        white-space: nowrap;
    }

    /* DATE */
    .date-wrapper {
        min-width: 150px;
    }

    .date-day {
        color: #64748b;
        font-size: 11px;
        margin-bottom: 3px;
    }

    .date-value {
        color: #334155;
        font-weight: 650;
        white-space: nowrap;
    }

    /* TIME */
    .time-badge {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 110px;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 750;
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
        opacity: 0.9;
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

    /* PESERTA */
    .participant {
        white-space: nowrap;
        color: #334155;
        font-weight: 700;
    }

    .participant small {
        color: #64748b;
        font-weight: 400;
    }

    /* PURPOSE */
    .purpose {
        max-width: 230px;
        color: #475569;
        line-height: 1.5;
    }

    /* STATUS */
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

    /* ACTION */
    .detail-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border: 1px solid #d6e2ef;
        border-radius: 7px;
        background: #eef4fa;
        color: #12355b;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
        transition: 0.2s ease;
    }

    .detail-btn:hover {
        background: #12355b;
        border-color: #12355b;
        color: #ffffff;
    }

    /* EMPTY */
    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: #eef4fa;
        color: #12355b;
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

    /* FOOTER */
    .table-note {
        padding: 13px 20px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
    }

    @media (max-width: 800px) {
        .filter-form {
            grid-template-columns: 1fr;
        }

        .table-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .filter-btn {
            width: 100%;
        }
    }
</style>

<div class="history-page">

    <div class="page-header">
        <h1>Riwayat Pendaftaran Aula</h1>
        <p>
            Daftar seluruh pengajuan pemakaian aula yang masuk ke dalam sistem RAPAT.
        </p>
    </div>

    {{-- FILTER --}}
    <div class="filter-card">

        <form action="{{ route('admin.history') }}" method="GET" class="filter-form">

            <div class="form-group">
                <label for="status">Filter Status</label>

                <select name="status" id="status">
                    <option value="">Semua Status</option>

                    <option value="menunggu"
                        {{ request('status') === 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>

                    <option value="disetujui"
                        {{ request('status') === 'disetujui' ? 'selected' : '' }}>
                        Disetujui
                    </option>

                    <option value="ditolak"
                        {{ request('status') === 'ditolak' ? 'selected' : '' }}>
                        Ditolak
                    </option>

                    <option value="dibatalkan"
                        {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>
                        Dibatalkan
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="aula_id">Filter Aula</label>

                <select name="aula_id" id="aula_id">
                    <option value="">Semua Aula</option>

                    @foreach ($aulas as $aula)
                        <option value="{{ $aula->id }}"
                            {{ (string) request('aula_id') === (string) $aula->id ? 'selected' : '' }}>
                            {{ $aula->nama_aula }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="filter-btn">
                🔍 Tampilkan
            </button>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="table-card">

        @if ($pendaftarans->count() > 0)

            <div class="table-header">

                <div>
                    <div class="table-header-title">
                        Daftar Pengajuan
                    </div>

                    <div class="table-header-subtitle">
                        Riwayat seluruh pendaftaran pemakaian aula
                    </div>
                </div>

                <div class="total-data">
                    {{ $pendaftarans->count() }} Pengajuan
                </div>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th>Pemohon</th>
                            <th>Unit Organisasi</th>
                            <th>Aula</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Peserta</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($pendaftarans as $pendaftaran)

                            <tr>

                                {{-- NO --}}
                                <td class="number">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- PEMOHON --}}
                                <td>
                                    <div class="applicant-name">
                                        {{ $pendaftaran->nama_pemohon }}
                                    </div>

                                    <div class="sub-text">
                                        {{ $pendaftaran->jabatan ?: '-' }}
                                    </div>
                                </td>

                                {{-- UNIT --}}
                                <td>
                                    <div class="unit">
                                        {{ $pendaftaran->unit_organisasi ?: '-' }}
                                    </div>

                                    @if ($pendaftaran->bagian_seksi)
                                        <div class="section-text">
                                            {{ $pendaftaran->bagian_seksi }}
                                        </div>
                                    @endif
                                </td>

                                {{-- AULA --}}
                                <td>
                                    <div class="aula-name">
                                        {{ $pendaftaran->aula->nama_aula ?? '-' }}
                                    </div>
                                </td>

                                {{-- TANGGAL --}}
                                <td>

                                    @if ($pendaftaran->tanggal_mulai && $pendaftaran->tanggal_selesai)

                                        @if ($pendaftaran->tanggal_mulai == $pendaftaran->tanggal_selesai)

                                            <div class="date-wrapper">
                                                <div class="date-day">
                                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)
                                                        ->locale('id')
                                                        ->translatedFormat('l') }}
                                                </div>

                                                <div class="date-value">
                                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)
                                                        ->locale('id')
                                                        ->translatedFormat('d F Y') }}
                                                </div>
                                            </div>

                                        @else

                                            <div class="date-wrapper">
                                                <div class="date-value">
                                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)
                                                        ->locale('id')
                                                        ->translatedFormat('d F Y') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)
                                                        ->locale('id')
                                                        ->translatedFormat('d F Y') }}
                                                </div>
                                            </div>

                                        @endif

                                    @else

                                        <div class="date-value">-</div>

                                    @endif

                                </td>

                                {{-- WAKTU --}}
                                <td>

                                    @switch($pendaftaran->kriteria_waktu)

                                        @case('pagi')
                                            <span class="time-badge time-pagi">
                                                <span class="time-name">
                                                    Pagi
                                                </span>

                                                <span class="time-range">
                                                    08.00–13.00
                                                </span>
                                            </span>
                                            @break

                                        @case('siang')
                                            <span class="time-badge time-siang">
                                                <span class="time-name">
                                                    Siang
                                                </span>

                                                <span class="time-range">
                                                    14.00–16.00
                                                </span>
                                            </span>
                                            @break

                                        @case('malam')
                                            <span class="time-badge time-malam">
                                                <span class="time-name">
                                                    Malam
                                                </span>

                                                <span class="time-range">
                                                    18.00–21.00
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
                                        <small>orang</small>
                                    </div>
                                </td>

                                {{-- KEPERLUAN --}}
                                <td>
                                    <div class="purpose">
                                        {{ $pendaftaran->keperluan ?: '-' }}
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
                                            {{ ucfirst($pendaftaran->status) }}
                                        </span>

                                    @endif

                                </td>

                                {{-- AKSI --}}
                                <td>

                                    <a
                                        href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}"
                                        class="detail-btn"
                                    >
                                        Lihat Detail
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="table-note">
                Menampilkan seluruh riwayat pengajuan pemakaian aula yang masuk ke sistem RAPAT.
            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    📋
                </div>

                <h3>
                    Belum Ada Pengajuan
                </h3>

                <p>
                    Belum ada data pengajuan yang sesuai dengan filter.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection