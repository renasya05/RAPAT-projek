@extends('layouts.app')

@section('title', 'Riwayat Pendaftaran | RAPAT')

@section('content')

<div class="admin-history">

    {{-- HEADER --}}
    <div class="page-top">

        <a href="{{ route('admin.dashboard') }}" class="back-link">
            <x-icon name="arrow-left" size="16" />
            Kembali ke Dashboard Admin
        </a>

        <div class="history-header">
            <div>
                <h1>
                    Data Pengajuan Pemakaian Aula
                </h1>

                <p>
                    Lihat, filter, dan proses seluruh pengajuan pemakaian aula.
                </p>
            </div>

            <div class="history-icon">
                <x-icon name="history" />
            </div>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="filter-card">

        <div class="filter-heading">

            <div class="filter-title">
                Filter Status Pengajuan
            </div>

            <span class="filter-description">
                Pilih status untuk menampilkan data tertentu.
            </span>

        </div>

        <div class="filter-buttons">

            <a
                href="{{ route('admin.pendaftaran.index') }}"
                class="filter-btn {{ $statusAktif === 'semua' ? 'active' : '' }}"
            >
                Semua
            </a>

            <a
                href="{{ route('admin.pendaftaran.index', ['status' => 'menunggu']) }}"
                class="filter-btn {{ $statusAktif === 'menunggu' ? 'active' : '' }}"
            >
                <span class="dot yellow"></span>
                Menunggu
            </a>

            <a
                href="{{ route('admin.pendaftaran.index', ['status' => 'disetujui']) }}"
                class="filter-btn {{ $statusAktif === 'disetujui' ? 'active' : '' }}"
            >
                <span class="dot green"></span>
                Disetujui
            </a>

            <a
                href="{{ route('admin.pendaftaran.index', ['status' => 'ditolak']) }}"
                class="filter-btn {{ $statusAktif === 'ditolak' ? 'active' : '' }}"
            >
                <span class="dot red"></span>
                Ditolak
            </a>

            <a
                href="{{ route('admin.pendaftaran.index', ['status' => 'dibatalkan']) }}"
                class="filter-btn {{ $statusAktif === 'dibatalkan' ? 'active' : '' }}"
            >
                <span class="dot gray"></span>
                Dibatalkan
            </a>

        </div>

    </div>


    {{-- DATA --}}
    <div class="data-card">

        <div class="card-header">

            <div>
                <h2>
                    Daftar Pengajuan
                </h2>

                <p>
                    Seluruh pengajuan pemakaian aula yang masuk ke sistem.
                </p>
            </div>

            <div class="total-badge">
                {{ $pendaftarans->count() }} Pengajuan
            </div>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
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

                    @forelse($pendaftarans as $index => $pendaftaran)

                        <tr class="row-{{ $pendaftaran->status }}">

                            @php
                                $asal = $pendaftaran->peserta_asal;

                                if (!$asal) {
                                    if (!$pendaftaran->unit_organisasi) {
                                        $asal = 'eksternal';
                                    } elseif (
                                        $pendaftaran->instansi &&
                                        $pendaftaran->instansi !== 'DISKOMINFO'
                                    ) {
                                        $asal = 'internal_eksternal';
                                    } else {
                                        $asal = 'internal';
                                    }
                                }
                            @endphp

                            {{-- NO --}}
                            <td>
                                <span class="number-cell">
                                    {{ $index + 1 }}
                                </span>
                            </td>


                            {{-- PEMOHON --}}
                            <td>

                                <div class="applicant">

                                    <strong>
                                        {{ $pendaftaran->nama_pemohon }}
                                    </strong>

                                    <span>
                                        {{ $pendaftaran->jabatan }}
                                    </span>

                                </div>

                            </td>


                            {{-- UNIT ORGANISASI --}}
                            <td>

                                @if($pendaftaran->unit_organisasi)

                                    <span class="unit">
                                        {{ $pendaftaran->unit_organisasi }}
                                    </span>

                                    @if($pendaftaran->bagian_seksi)

                                        <small class="section">
                                            {{ $pendaftaran->bagian_seksi }}
                                        </small>

                                    @endif

                                @else

                                    <span class="unit external-unit">
                                        {{ $pendaftaran->instansi ?? 'Eksternal' }}
                                    </span>

                                    <small class="section">
                                        Pemohon Eksternal
                                    </small>

                                @endif

                            </td>


                            {{-- AULA --}}
                            <td>

                                <strong class="aula-name">
                                    {{ $pendaftaran->aula->nama_aula ?? '-' }}
                                </strong>

                                @if($pendaftaran->aula)

                                    <small class="capacity">
                                        Kapasitas:
                                        {{ $pendaftaran->aula->kapasitas }}
                                        orang
                                    </small>

                                @endif

                            </td>


                            {{-- TANGGAL --}}
                            <td>

                                <div class="date-cell">

                                    @if($pendaftaran->tanggal_mulai)

                                        <strong>
                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->translatedFormat('d F Y') }}
                                        </strong>

                                        <span>
                                            s/d
                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai ?? $pendaftaran->tanggal_mulai)->translatedFormat('d F Y') }}
                                        </span>

                                        <small>
                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->translatedFormat('l') }}
                                        </small>

                                    @else

                                        <strong>
                                            -
                                        </strong>

                                    @endif

                                </div>

                            </td>


                            {{-- WAKTU --}}
                            <td>

                                <div class="time-cell">

                                    @switch($pendaftaran->kriteria_waktu)

                                        @case('pagi_siang')
                                            <span class="time-badge pagi">
                                                Pagi
                                                (08.00 – 13.00)
                                            </span>
                                            @break

                                        @case('siang_sore')
                                            <span class="time-badge siang">
                                                Siang
                                                (14.00 – 16.00)
                                            </span>
                                            @break

                                        @case('malam')
                                            <span class="time-badge malam">
                                                Malam
                                                (18.00 – 21.00)
                                            </span>
                                            @break

                                        @case('gabungan_pagi_siang')
                                            <span class="time-badge pagi">
                                                Full Day
                                                (08.00 – 16.00)
                                            </span>
                                            @break

                                        @case('gabungan_siang_malam')
                                            <span class="time-badge siang">
                                                Full Day
                                                (14.00 – 21.00)
                                            </span>
                                            @break

                                        @case('gabungan_pagi_malam')
                                            <span class="time-badge malam">
                                                Full Day
                                                (08.00 – 21.00)
                                            </span>
                                            @break

                                        @default
                                            <span class="time-badge">
                                                -
                                            </span>

                                    @endswitch

                                </div>

                            </td>


                            {{-- PESERTA --}}
                            <td>

                                <div class="participant-cell">

                                    <strong>
                                        {{ $pendaftaran->jumlah_peserta }}
                                    </strong>

                                    <small>
                                        orang
                                    </small>

                                    <span class="asal-badge">
                                        @if($asal === 'internal_eksternal')
                                            Internal & Eksternal
                                        @elseif($asal === 'eksternal')
                                            Eksternal
                                        @elseif($asal === 'internal')
                                            Internal
                                        @else
                                            -
                                        @endif
                                    </span>

                                </div>

                            </td>


                            {{-- KEPERLUAN --}}
                            <td class="purpose">

                                <div class="purpose-text">
                                    {{ $pendaftaran->keperluan }}
                                </div>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                @if($pendaftaran->status === 'disetujui')

                                    <span class="badge badge-success">
                                        Disetujui
                                    </span>

                                @elseif($pendaftaran->status === 'ditolak')

                                    <span class="badge badge-danger">
                                        Ditolak
                                    </span>

                                @elseif($pendaftaran->status === 'dibatalkan')

                                    <span class="badge badge-neutral">
                                        Dibatalkan
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        Menunggu
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <a
                                    href="{{ route('admin.pendaftaran.show', $pendaftaran) }}"
                                    class="detail-btn"
                                >
                                    Detail
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10">

                                <div class="empty">

                                    <div class="empty-icon">
                                        <x-icon name="history" />
                                    </div>

                                    <h3>
                                        Tidak Ada Pengajuan
                                    </h3>

                                    <p>
                                        Belum ada pengajuan dengan status yang dipilih.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>



@endsection