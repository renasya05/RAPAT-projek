<?php

namespace App\Services;

use App\Models\Pendaftaran;
use Carbon\Carbon;

class RekapKetersediaan
{
    /*
    |--------------------------------------------------------------------------
    | TAHUN AKTIF DARI INPUT
    |--------------------------------------------------------------------------
    */

    public static function tahunAktif($input): int
    {
        $tahun = (int) $input;

        if ($tahun < 2000 || $tahun > 2100) {
            return (int) now()->format('Y');
        }

        return $tahun;
    }


    /*
    |--------------------------------------------------------------------------
    | REKAP HARIAN PER BULAN UNTUK SATU TAHUN
    |--------------------------------------------------------------------------
    |
    | Menghasilkan 12 blok bulan, masing-masing berisi baris
    | harian dengan isi sel singkatan unit pemakai waktu.
    |
    */

    public static function build(?int $aulaId, int $tahun, ?array $bulanList = null, ?array $statusList = null): array
    {
        $bulanList = $bulanList ?? range(1, 12);

        $statusList = $statusList ?? [
            'menunggu',
            'disetujui',
        ];

        $awalTahun = Carbon::create(
            $tahun,
            1,
            1,
            0,
            0,
            0
        )->startOfDay();

        $akhirTahun = $awalTahun->copy()->endOfYear();


        /*
        |----------------------------------------------------------------------
        | Pendaftaran yang memakai jadwal
        |----------------------------------------------------------------------
        */

        $pendaftarans = Pendaftaran::whereIn('status', $statusList)
            ->where('aula_id', $aulaId)
            ->whereNotNull('tanggal_mulai')
            ->whereNotNull('tanggal_selesai')
            ->whereDate(
                'tanggal_mulai',
                '<=',
                $akhirTahun
            )
            ->whereDate(
                'tanggal_selesai',
                '>=',
                $awalTahun
            )
            ->whereIn('kriteria_waktu', [
                'pagi_siang',
                'siang_sore',
                'malam',
                'gabungan_pagi_siang',
                'gabungan_siang_malam',
                'gabungan_pagi_malam',
                'full_day',
            ])
            ->get();


        /*
        |----------------------------------------------------------------------
        | Pemetaan unit dan waktu
        |----------------------------------------------------------------------
        */

        $unitSingkat = [
            'Sekretariat' => 'Sekretariat',

            'Bidang Informasi Publik dan Statistik' =>
                'Inpub',

            'Bidang Komunikasi Publik' =>
                'Konpub',

            'Bidang Aplikasi Informatika' =>
                'Aptika',

            'Bidang Persandian dan Keamanan Informasi' =>
                'Sandikami',
        ];

        $slotWaktu = [
            'pagi_siang' => ['pagi'],
            'siang_sore' => ['siang'],
            'malam' => ['malam'],
            'gabungan_pagi_siang' => ['full_day'],
            'gabungan_siang_malam' => ['full_day'],
            'gabungan_pagi_malam' => ['full_day'],
            'full_day' => ['full_day'],
        ];


        /*
        |----------------------------------------------------------------------
        | Booking per tanggal dan waktu
        |----------------------------------------------------------------------
        */

        $booking = [];
        $slotTerpakai = [];

        foreach ($pendaftarans as $pendaftaran) {
            $slots = $slotWaktu[
                $pendaftaran->kriteria_waktu
            ] ?? [];

            if (empty($slots)) {
                continue;
            }

            $unit = $pendaftaran->unit_organisasi
                ?: ($pendaftaran->instansi
                    ?: 'Instansi Lain');

            $label = $unitSingkat[$unit] ?? $unit;

            $mulai = Carbon::parse(
                $pendaftaran->tanggal_mulai
            )->startOfDay();

            $selesai = Carbon::parse(
                $pendaftaran->tanggal_selesai
            )->startOfDay();

            $mulaiEfektif = $mulai->lessThan($awalTahun)
                ? $awalTahun->copy()
                : $mulai;

            $selesaiEfektif = $selesai->greaterThan($akhirTahun)
                ? $akhirTahun->copy()
                : $selesai;

            for (
                $tanggal = $mulaiEfektif->copy();
                $tanggal->lte($selesaiEfektif);
                $tanggal->addDay()
            ) {
                $tanggalKey = $tanggal->format('Y-m-d');

                foreach ($slots as $slot) {
                    $booking[$tanggalKey][$slot][] = [
                        'label' => $label,
                        'status' => $pendaftaran->status,
                    ];

                    if (in_array(
                        $pendaftaran->status,
                        ['menunggu', 'disetujui'],
                        true
                    )) {
                        $slotTerpakai[$tanggalKey][$slot] = true;
                    }
                }
            }
        }


        /*
        |----------------------------------------------------------------------
        | Susun baris harian untuk setiap bulan
        |----------------------------------------------------------------------
        */

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $namaHari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        $rekapBulanan = [];

        $renderSlot = function ($entries) {
            if (empty($entries)) {
                return ['', ''];
            }

            $labels = array_column($entries, 'label');
            $labelStr = implode(', ', array_unique($labels));

            $statuses = array_column($entries, 'status');

            if (in_array('disetujui', $statuses, true)) {
                $st = 'disetujui';
            } elseif (in_array('menunggu', $statuses, true)) {
                $st = 'menunggu';
            } else {
                $st = 'ditolak';
            }

            return [$labelStr, $st];
        };

        foreach ($bulanList as $bulanIdx) {
            $awalBulan = Carbon::create(
                $tahun,
                $bulanIdx,
                1,
                0,
                0,
                0
            )->startOfDay();

            $akhirBulan = $awalBulan->copy()->endOfMonth();

            $rows = [];

            for (
                $tanggal = $awalBulan->copy();
                $tanggal->lte($akhirBulan);
                $tanggal->addDay()
            ) {
                $tanggalKey = $tanggal->format('Y-m-d');

                $sel = $booking[$tanggalKey] ?? [];

                $jumlahSlot = count(
                    $slotTerpakai[$tanggalKey] ?? []
                );

                if ($jumlahSlot === 0) {
                    $status = 'empty';
                } elseif ($jumlahSlot >= 4) {
                    $status = 'full';
                } else {
                    $status = 'used';
                }

                [$pagiLabel, $pagiStatus] =
                    $renderSlot($sel['pagi'] ?? []);

                [$siangLabel, $siangStatus] =
                    $renderSlot($sel['siang'] ?? []);

                [$malamLabel, $malamStatus] =
                    $renderSlot($sel['malam'] ?? []);

                [$fullDayLabel, $fullDayStatus] =
                    $renderSlot($sel['full_day'] ?? []);

                $adaDitolak = in_array(
                    'ditolak',
                    [$pagiStatus, $siangStatus, $malamStatus, $fullDayStatus],
                    true
                );

                $adaDisetujui = in_array(
                    'disetujui',
                    [$pagiStatus, $siangStatus, $malamStatus, $fullDayStatus],
                    true
                );

                $adaMenunggu = in_array(
                    'menunggu',
                    [$pagiStatus, $siangStatus, $malamStatus, $fullDayStatus],
                    true
                );

                $adaBooking = ($pagiLabel !== '' || $siangLabel !== '' || $malamLabel !== '' || $fullDayLabel !== '');

                $rows[] = [
                    'key' => $tanggalKey,

                    'tanggal' => $tanggal->format('d/m/Y'),

                    'hari' => $namaHari[
                        $tanggal->dayOfWeekIso
                    ],

                    'status' => $status,

                    'pagi' => $pagiLabel,

                    'siang' => $siangLabel,

                    'malam' => $malamLabel,

                    'pagiStatus' => $pagiStatus,

                    'siangStatus' => $siangStatus,

                    'malamStatus' => $malamStatus,

                    'fullDay' => $fullDayLabel,
                    'fullDayStatus' => $fullDayStatus,

                    'adaDitolak' => $adaDitolak,

                    'adaDisetujui' => $adaDisetujui,

                    'adaMenunggu' => $adaMenunggu,

                    'adaBooking' => $adaBooking,
                ];
            }

            $rekapBulanan[] = [
                'judul' => $namaBulan[$bulanIdx]
                    . ' '
                    . $tahun,

                'rows' => $rows,
            ];
        }


        return [
            'rekapBulanan' => $rekapBulanan,
            'tahun' => $tahun,
            'tahunSebelumnya' => $tahun - 1,
            'tahunBerikutnya' => $tahun + 1,
        ];
    }
}
