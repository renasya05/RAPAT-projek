@extends('layouts.app')

@section('title', 'Detail Aula | RAPAT')

@section('content')

<div class="page-container">

    <a href="{{ route('admin.aulas.index') }}" class="back-link">
        <x-icon name="arrow-left" size="16" />
        Kembali ke Data Aula
    </a>

    <div class="page-header">

        <div class="page-header-text">

            <h1>
                {{ $aula->nama_aula }}
            </h1>

            <p>
                Informasi detail fasilitas, kapasitas, dan status peminjaman aula.
            </p>

        </div>

        <div class="header-actions">

            <a
                href="{{ route('admin.aulas.edit', $aula->id) }}"
                class="btn btn-secondary"
            >
                <x-icon name="pencil" size="16" />
                Edit Aula
            </a>

            <form
                action="{{ route('admin.aulas.destroy', $aula->id) }}"
                method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus aula ini?')"
            >
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    Hapus
                </button>
            </form>

        </div>

    </div>


    {{-- =====================================================
         DETAIL INFORMASI AULA
    ====================================================== --}}

    <div class="detail-card">

        <div class="card-header">

            <div>

                <h2>
                    Informasi Aula
                </h2>

                <p>
                    Data aula yang tersimpan di sistem.
                </p>

            </div>

            <span class="number-badge">
                #{{ $aula->id }}
            </span>

        </div>


        <div class="detail-grid">

            <div class="detail-section">

                <div class="section-title">

                    <div class="section-icon">
                        <x-icon name="building" />
                    </div>

                    <div>

                        <h3>
                            Data Aula
                        </h3>

                        <span>
                            Nama dan kapasitas
                        </span>

                    </div>

                </div>


                <div class="info-list">

                    <div class="info-item">

                        <span>
                            Nama Aula
                        </span>

                        <strong>
                            {{ $aula->nama_aula }}
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            Kapasitas Maksimal
                        </span>

                        <strong>
                            {{ $aula->kapasitas }} orang
                        </strong>

                    </div>

                </div>

            </div>


            <div class="detail-section">

                <div class="section-title">

                    <div class="section-icon">
                        <x-icon name="info" />
                    </div>

                    <div>

                        <h3>
                            Keterangan dan Fasilitas
                        </h3>

                        <span>
                            Lokasi dan fasilitas aula
                        </span>

                    </div>

                </div>


                <div class="info-list">

                    <div class="info-item">

                        <span>
                            Keterangan / Lokasi
                        </span>

                        <strong>
                            {{ $aula->keterangan ?? 'Belum diisi' }}
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            Fasilitas
                        </span>

                        <strong>
                            {{ $aula->fasilitas ?? 'Belum ada catatan fasilitas khusus.' }}
                        </strong>

                    </div>

                </div>

            </div>


            <div class="detail-section">

                <div class="section-title">

                    <div class="section-icon">
                        <x-icon name="clock" />
                    </div>

                    <div>

                        <h3>
                            Informasi Sistem
                        </h3>

                        <span>
                            Informasi pencatatan sistem
                        </span>

                    </div>

                </div>


                <div class="info-list">

                    <div class="info-item">

                        <span>
                            Tanggal Dibuat
                        </span>

                        <strong>
                            {{ $aula->created_at ? $aula->created_at->format('d F Y, H:i') : '-' }}
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            Terakhir Diperbarui
                        </span>

                        <strong>
                            {{ $aula->updated_at ? $aula->updated_at->format('d F Y, H:i') : '-' }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DAFTAR PENDAFTARAN PADA AULA INI
    ====================================================== --}}

    <div class="data-card">

        <div class="card-header">

            <div>

                <h2>
                    Riwayat Pengajuan Peminjaman pada Aula Ini
                </h2>

                <p>
                    Seluruh pengajuan yang memakai aula ini.
                </p>

            </div>

            <div class="total-badge">
                {{ $aula->pendaftarans->count() }} Pengajuan
            </div>

        </div>


        @if($aula->pendaftarans->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemohon</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Peserta</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($aula->pendaftarans as $index => $pendaftaran)

                            <tr>

                                <td class="number-cell">
                                    {{ $index + 1 }}
                                </td>

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

                                <td>

                                    @if ($pendaftaran->tanggal_mulai && $pendaftaran->tanggal_selesai)

                                        @if ($pendaftaran->tanggal_mulai == $pendaftaran->tanggal_selesai)

                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)
                                                ->locale('id')
                                                ->translatedFormat('d-m-Y') }}

                                        @else

                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)
                                                ->locale('id')
                                                ->translatedFormat('d-m-Y') }}
                                            –
                                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)
                                                ->locale('id')
                                                ->translatedFormat('d-m-Y') }}

                                        @endif

                                    @else
                                        -
                                    @endif

                                </td>

                                <td>

                                    @php
                                        // Kolom jam_mulai/jam_selesai sudah
                                        // dihapus; waktu ada di kriteria_waktu.
                                        $jam = [
                                            'pagi_siang' => '08.00 - 13.00',
                                            'siang_sore' => '14.00 - 16.00',
                                            'malam' => '18.00 - 21.00',
                                            'gabungan_pagi_siang' => '08.00 - 21.00',
                                            'gabungan_siang_malam' => '08.00 - 21.00',
                                            'gabungan_pagi_malam' => '08.00 - 21.00',
                                        ][$pendaftaran->kriteria_waktu] ?? '-';
                                    @endphp

                                    {{ $jam }}

                                </td>

                                <td>
                                    {{ $pendaftaran->jumlah_peserta }} orang
                                </td>

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

                                <td>

                                    <a
                                        href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}"
                                        class="detail-btn"
                                    >
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty">
                Belum ada riwayat pengajuan peminjaman untuk aula ini.
            </div>

        @endif

    </div>

</div>

@endsection
