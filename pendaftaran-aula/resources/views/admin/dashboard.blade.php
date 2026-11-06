@extends('layouts.app')

@section('title', 'Dashboard Admin | RAPAT')

@section('content')


<div class="admin-dashboard">

    {{-- HERO --}}
    <section class="admin-hero">
        <h1>Dashboard Admin</h1>

        <p>
            Selamat datang di panel administrator RAPAT
            Kelola pengajuan penggunaan aula, data aula,
            dan laporan melalui halaman ini.
        </p>
    </section>

    {{-- STATISTIK --}}
    <div class="section-title section-title-month">
        <div>
            <h2>Ringkasan Pengajuan</h2>
            <p>Data untuk bulan {{ $judulBulanRingkasan }}.</p>
        </div>
        <div class="month-nav-buttons">
            @if($bulanSebelumnya)
                <a class="btn btn-secondary month-prev-btn" href="{{ route('admin.dashboard', ['bulan' => $bulanSebelumnya, 'tahun' => $tahunSebelumnya]) }}"><x-icon name="arrow-left" size="16" /> Bulan Sebelumnya</a>
            @else
                <span class="btn btn-secondary month-prev-btn is-disabled" aria-disabled="true"><x-icon name="arrow-left" size="16" /> Bulan Sebelumnya</span>
            @endif
            @if($bulanBerikutnya)
                <a class="btn btn-primary month-next-btn" href="{{ route('admin.dashboard', ['bulan' => $bulanBerikutnya, 'tahun' => $tahunBerikutnya]) }}">Bulan Selanjutnya <x-icon name="arrow-right" size="16" /></a>
            @else
                <span class="btn btn-primary month-next-btn is-disabled" aria-disabled="true">Bulan Selanjutnya <x-icon name="arrow-right" size="16" /></span>
            @endif
        </div>
    </div>

    <div class="stats-grid" id="ringkasan-pengajuan">

        <div class="stat-card stat-total">
            <div class="stat-icon">
                <x-icon name="dashboard" />
            </div>

            <div class="stat-number">
                {{ $stats['totalPendaftar'] }}
            </div>

            <div class="stat-label">
                Total Pendaftaran
            </div>
        </div>

        <div class="stat-card stat-waiting">
            <div class="stat-icon">
                <x-icon name="clock" />
            </div>

            <div class="stat-number">
                {{ $stats['menunggu'] }}
            </div>

            <div class="stat-label">
                Menunggu Persetujuan
            </div>
        </div>

        <div class="stat-card stat-approved">
            <div class="stat-icon">
                <x-icon name="check" />
            </div>

            <div class="stat-number">
                {{ $stats['disetujui'] }}
            </div>

            <div class="stat-label">
                Disetujui
            </div>
        </div>

        <div class="stat-card stat-rejected">
            <div class="stat-icon">
                <x-icon name="alert" />
            </div>

            <div class="stat-number">
                {{ $stats['ditolak'] }}
            </div>

            <div class="stat-label">
                Ditolak
            </div>
        </div>

    </div>

    {{-- NOTIFIKASI PENGAJUAN BARU --}}
    <div class="section-title">
        <h2>Notifikasi Pengajuan Baru</h2>

        <p>
            Pengajuan yang baru masuk dan menunggu persetujuan.
            Klik untuk melihat detail.
        </p>
    </div>

    <div class="notif-card">

        @forelse($notifikasi as $item)

            @php
                $labelWaktu = [
                    'pagi_siang' => 'Pagi (08.00 - 13.00)',
                    'siang_sore' => 'Siang (14.00 - 16.00)',
                    'malam' => 'Malam (18.00 - 21.00)',
                    'gabungan_pagi_siang' => 'Full Day ',
                    'gabungan_siang_malam' => 'Full Day ',
                    'gabungan_pagi_malam' => 'Full Day ',
                ][$item->kriteria_waktu] ?? $item->kriteria_waktu;
            @endphp

            <a
                href="{{ route('admin.pendaftaran.show', $item) }}"
                class="notif-item"
            >
                <div class="notif-icon">
                    <x-icon name="bell" />
                </div>

                <div class="notif-body">
                    <div class="notif-title">
                        {{ $item->nama_pemohon }}
                    </div>

                    <div class="notif-meta">
                        {{ $item->aula?->nama_aula }}
                        ·
                        {{ \Illuminate\Support\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                        ·
                        {{ $labelWaktu }}
                    </div>
                </div>

                <div class="notif-time">
                    {{ $item->created_at->format('d/m/Y H:i') }}
                </div>
            </a>

        @empty

            <div class="notif-empty">
                Tidak ada pengajuan baru saat ini.
            </div>

        @endforelse

    </div>

    <div class="admin-info">
        <strong>Informasi:</strong>
        Pengajuan baru akan memiliki status
        <strong>Menunggu</strong> sampai diperiksa dan
        diproses oleh administrator.
    </div>

</div>

@endsection