<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Pendaftaran;
use App\Services\RekapKetersediaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $periode = $this->periodeBulan(
            $request->query('bulan'),
            $request->query('tahun')
        );

        $bulanPilihan = $periode['bulan'];
        $tahun = $periode['tahun'];


        /*
        |--------------------------------------------------------------------------
        | STATISTIK PENDAFTARAN USER
        |--------------------------------------------------------------------------
        */

        $totalQuery = Pendaftaran::where('user_id', $user->id)
            ->whereYear('tanggal_mulai', $tahun)
            ->whereMonth('tanggal_mulai', $bulanPilihan);

        $totalPendaftaran = (clone $totalQuery)->count();
        $menunggu = (clone $totalQuery)->where('status', 'menunggu')->count();
        $disetujui = (clone $totalQuery)->where('status', 'disetujui')->count();
        $ditolak = (clone $totalQuery)->where('status', 'ditolak')->count();

        /*
        |--------------------------------------------------------------------------
        | BULAN BERJALAN (REALTIME)
        |--------------------------------------------------------------------------
        |
        | Rekap harian hanya menampilkan bulan yang sedang
        | berjalan saat ini, mengikuti tanggal sistem.
        |
        */

        $tanggalRekap = $periode['tanggal'];
        $bulanBerikutnya = $periode['berikutnya']['bulan'] ?? null;
        $tahunBerikutnya = $periode['berikutnya']['tahun'] ?? null;
        $bulanSebelumnya = $periode['sebelumnya']['bulan'] ?? null;
        $tahunSebelumnya = $periode['sebelumnya']['tahun'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | DATA AULA
        |--------------------------------------------------------------------------
        */

        $aulas = Aula::orderBy('nama_aula')->get();

        $aulaTerpilih = $aulas->firstWhere(
            'id',
            (int) $request->input('aula')
        ) ?? $aulas->first();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK PER AULA (MILIK USER)
        |--------------------------------------------------------------------------
        */

        $statistikAula = [];

        foreach ($aulas as $aulaItem) {
            $statistikAula[$aulaItem->id] = [
                'total' => Pendaftaran::where('user_id', $user->id)
                    ->where('aula_id', $aulaItem->id)
                    ->whereYear('tanggal_mulai', $tahun)
                    ->whereMonth('tanggal_mulai', $bulanPilihan)
                    ->count(),

                'menunggu' => Pendaftaran::where('user_id', $user->id)
                    ->where('aula_id', $aulaItem->id)
                    ->whereYear('tanggal_mulai', $tahun)
                    ->whereMonth('tanggal_mulai', $bulanPilihan)
                    ->where('status', 'menunggu')
                    ->count(),

                'disetujui' => Pendaftaran::where('user_id', $user->id)
                    ->where('aula_id', $aulaItem->id)
                    ->whereYear('tanggal_mulai', $tahun)
                    ->whereMonth('tanggal_mulai', $bulanPilihan)
                    ->where('status', 'disetujui')
                    ->count(),

                'ditolak' => Pendaftaran::where('user_id', $user->id)
                    ->where('aula_id', $aulaItem->id)
                    ->whereYear('tanggal_mulai', $tahun)
                    ->whereMonth('tanggal_mulai', $bulanPilihan)
                    ->where('status', 'ditolak')
                    ->count(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | REKAP HARIAN BULAN INI
        |--------------------------------------------------------------------------
        */

        $rekap = RekapKetersediaan::build(
            $aulaTerpilih?->id,
            $tahun,
            [$bulanPilihan],
            ['menunggu', 'disetujui', 'ditolak']
        );

        $rekapBulanIni = $rekap['rekapBulanan'][0] ?? null;


        /*
        |--------------------------------------------------------------------------
        | VIEW DASHBOARD PENGGUNA
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard',
            compact(
                'totalPendaftaran',
                'menunggu',
                'disetujui',
                'ditolak',
                'aulas',
                'aulaTerpilih',
                'tahun',
                'bulanPilihan',
                'bulanBerikutnya',
                'tahunBerikutnya',
                'bulanSebelumnya',
                'tahunSebelumnya',
                'rekapBulanIni',
                'statistikAula'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR AULA
    |--------------------------------------------------------------------------
    */

    public function aulas()
    {
        $aulas = Aula::latest()->get();

        return view(
            'aulas.index',
            [
                'aulas' => $aulas,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Periode Bulan (realtime)
    |--------------------------------------------------------------------------
    |
    | Tanpa parameter yang tampil adalah bulan berjalan, jadi otomatis
    | berganti tiap awal bulan. Bisa maju/mundur lewat tombol.
    | Mundur sampai Oktober 2026, maju sampai 24 bulan dari bulan berjalan.
    |
    */
    private function periodeBulan($bulan = null, $tahun = null): array
    {
        $sekarang = now()->startOfMonth();
        $awal = \Carbon\Carbon::create(2026, 10, 1)->startOfDay();
        $akhir = $sekarang->copy()->addMonthsNoOverflow(24);

        $b = (int) $bulan;
        $t = (int) $tahun;

        $dipilih = ($b >= 1 && $b <= 12 && $t >= 2000 && $t <= 2100)
            ? \Carbon\Carbon::create($t, $b, 1)->startOfDay()
            : $sekarang->copy();

        if ($dipilih->lt($awal)) {
            $dipilih = $awal->copy();
        }

        if ($dipilih->gt($akhir)) {
            $dipilih = $akhir->copy();
        }

        $sebelumnya = $dipilih->copy()->subMonthNoOverflow();
        $berikutnya = $dipilih->copy()->addMonthNoOverflow();

        return [
            'bulan' => (int) $dipilih->month,
            'tahun' => (int) $dipilih->year,
            'tanggal' => $dipilih,
            'judul' => $dipilih->copy()->locale('id')->translatedFormat('F Y'),
            'bulanIni' => $dipilih->equalTo($sekarang),
            'sebelumnya' => $sebelumnya->gte($awal)
                ? ['bulan' => (int) $sebelumnya->month, 'tahun' => (int) $sebelumnya->year]
                : null,
            'berikutnya' => $berikutnya->lte($akhir)
                ? ['bulan' => (int) $berikutnya->month, 'tahun' => (int) $berikutnya->year]
                : null,
            'sekarang' => [
                'bulan' => (int) $sekarang->month,
                'tahun' => (int) $sekarang->year,
            ],
        ];
    }
}