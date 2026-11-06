<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Pendaftaran;
use App\Services\RekapKetersediaan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Kriteria Waktu
    |--------------------------------------------------------------------------
    */
    private function kriteriaWaktu(): array
    {
        return [
            'pagi_siang' => [
                'nama' => 'Pagi',
                'jam' => '08.00 – 13.00',
            ],

            'siang_sore' => [
                'nama' => 'Siang',
                'jam' => '14.00 – 16.00',
            ],

            'malam' => [
                'nama' => 'Malam',
                'jam' => '18.00 – 21.00',
            ],

            'gabungan_pagi_siang' => [
                'nama' => 'Full Day',
                'jam' => '1 hari penuh',
            ],

            'gabungan_siang_malam' => [
                'nama' => 'Full Day',
                'jam' => '1 hari penuh',
            ],

            'gabungan_pagi_malam' => [
                'nama' => 'Full Day',
                'jam' => '1 hari penuh',
            ],
        ];
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

    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin
    |--------------------------------------------------------------------------
    */
    public function dashboard(Request $request)
    {
        $periode = $this->periodeBulan(
            $request->query('bulan'),
            $request->query('tahun')
        );

        $bulanPilihan = $periode['bulan'];
        $tahunPilihan = $periode['tahun'];

        $tanggalRingkasan = $periode['tanggal'];
        $bulanBerikutnya = $periode['berikutnya']['bulan'] ?? null;
        $tahunBerikutnya = $periode['berikutnya']['tahun'] ?? null;
        $bulanSebelumnya = $periode['sebelumnya']['bulan'] ?? null;
        $tahunSebelumnya = $periode['sebelumnya']['tahun'] ?? null;
        // Rekap mengikuti bulan pemakaian aula, bukan tanggal data dibuat.
        $queryBulan = Pendaftaran::whereYear('tanggal_mulai', $tahunPilihan)
            ->whereMonth('tanggal_mulai', $bulanPilihan);

        $stats = [
            'totalPendaftar' => (clone $queryBulan)->count(),
            'menunggu' => (clone $queryBulan)->where('status', 'menunggu')->count(),
            'disetujui' => (clone $queryBulan)->where('status', 'disetujui')->count(),
            'ditolak' => (clone $queryBulan)->where('status', 'ditolak')->count(),
            'aulas' => Aula::count(),
        ];


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI PENGAJUAN BARU
        |--------------------------------------------------------------------------
        |
        | Pengajuan berstatus menunggu (pendaftaran baru)
        | ditampilkan sebagai notifikasi di dashboard admin.
        |
        */

        $notifikasi = Pendaftaran::with('aula')
            ->whereYear('tanggal_mulai', $tahunPilihan)
            ->whereMonth('tanggal_mulai', $bulanPilihan)
            ->where('status', 'menunggu')
            ->latest('created_at')
            ->limit(6)
            ->get();


        return view('admin.dashboard', [
            'stats' => $stats,
            'notifikasi' => $notifikasi,
            'bulanPilihan' => $bulanPilihan,
            'tahunPilihan' => $tahunPilihan,
            'bulanBerikutnya' => $bulanBerikutnya,
            'tahunBerikutnya' => $tahunBerikutnya,
            'bulanSebelumnya' => $bulanSebelumnya,
            'tahunSebelumnya' => $tahunSebelumnya,
            'judulBulanRingkasan' => $tanggalRingkasan->locale('id')->translatedFormat('F Y'),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Riwayat Pendaftaran Admin
    |--------------------------------------------------------------------------
    */
    public function history(Request $request)
    {
        $query = Pendaftaran::with([
            'user',
            'aula',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        |
        | Nilai divalidasi ke daftar status yang ada, jadi ?status=
        | kosong atau ?status=ngawur tidak membuat tombol filter
        | kehilangan penanda aktif.
        |
        */
        $statusTersedia = [
            'menunggu',
            'disetujui',
            'ditolak',
            'dibatalkan',
        ];

        $statusAktif = in_array(
            $request->query('status'),
            $statusTersedia,
            true
        )
            ? $request->query('status')
            : 'semua';

        if ($statusAktif !== 'semua') {
            $query->where(
                'status',
                $statusAktif
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Data
        |--------------------------------------------------------------------------
        */
        $pendaftarans = $query
            ->orderByDesc('created_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Kirim ke Blade
        |--------------------------------------------------------------------------
        */
        return view('admin.history', [
            'pendaftarans' => $pendaftarans,

            'statusAktif' => $statusAktif,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Detail Pendaftaran
    |--------------------------------------------------------------------------
    */
    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load([
            'user',
            'aula',
        ]);

        return view(
            'admin.pendaftaran.show',
            [
                'pendaftaran' => $pendaftaran,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Approve Pendaftaran
    |--------------------------------------------------------------------------
    */
    public function approve(Pendaftaran $pendaftaran)
    {
        /*
        |--------------------------------------------------------------------------
        | Hanya pengajuan menunggu yang dapat diproses
        |--------------------------------------------------------------------------
        */
        if ($pendaftaran->status !== 'menunggu') {
            return back()->with(
                'error',
                'Pengajuan ini sudah diproses sebelumnya.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Cek Bentrok Jadwal
        |--------------------------------------------------------------------------
        */
        $slotMap = [
            'pagi_siang' => ['pagi'],
            'siang_sore' => ['siang'],
            'malam' => ['malam'],
            'gabungan_pagi_siang' => ['pagi', 'siang', 'malam'],
            'gabungan_siang_malam' => ['pagi', 'siang', 'malam'],
            'gabungan_pagi_malam' => ['pagi', 'siang', 'malam'],
        ];

        $slotDiminta = $slotMap[
            $pendaftaran->kriteria_waktu
        ] ?? [];

        /*
        | kriteria_waktu kosong/tak dikenal membuat whereIn di bawah
        | menerima array kosong (menjadi "0 = 1"), sehingga cek
        | bentrok selalu lolos dan aula yang sudah terpakai ikut
        | disetujui. Tolak saja pengajuan yang tidak punya slot.
        */
        if (empty($slotDiminta)) {
            return back()->with(
                'error',
                'Pengajuan tidak dapat diproses karena kriteria waktunya tidak dikenal.'
            );
        }

        $kriteriaBentrok = [];

        foreach ($slotMap as $kriteria => $slots) {
            if (array_intersect($slotDiminta, $slots)) {
                $kriteriaBentrok[] = $kriteria;
            }
        }

        $bentrok = Pendaftaran::where(
                'id',
                '!=',
                $pendaftaran->id
            )
            ->where(
                'aula_id',
                $pendaftaran->aula_id
            )
            ->where(
                'status',
                'disetujui'
            )
            ->whereNotNull('tanggal_mulai')
            ->whereNotNull('tanggal_selesai')
            // whereDate, bukan where: kolom date menyimpan
            // "2026-10-20 00:00:00", sehingga perbandingan string
            // dengan "2026-10-20" selalu salah.
            ->whereDate(
                'tanggal_mulai',
                '<=',
                $pendaftaran->tanggal_selesai
            )
            ->whereDate(
                'tanggal_selesai',
                '>=',
                $pendaftaran->tanggal_mulai
            )
            ->whereIn(
                'kriteria_waktu',
                $kriteriaBentrok
            )
            ->exists();


        /*
        |--------------------------------------------------------------------------
        | Jika Bentrok
        |--------------------------------------------------------------------------
        */
        if ($bentrok) {

            $namaWaktu = [
                'pagi_siang' => 'Pagi',
                'siang_sore' => 'Siang',
                'malam' => 'Malam',
                'gabungan_pagi_siang' => 'Full Day',
                'gabungan_siang_malam' => 'Full Day',
                'gabungan_pagi_malam' => 'Full Day',
            ];

            $waktu = $namaWaktu[
                $pendaftaran->kriteria_waktu
            ] ?? 'waktu tersebut';

            return back()->with(
                'error',
                'Pengajuan tidak dapat disetujui karena jadwal '
                . $waktu
                . ' pada aula dan tanggal tersebut sudah digunakan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Setujui
        |--------------------------------------------------------------------------
        */
        $pendaftaran->update([
            'status' => 'disetujui',
            'catatan_admin' => null,
        ]);


        return back()->with(
            'success',
            'Pengajuan berhasil disetujui.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Reject Pendaftaran
    |--------------------------------------------------------------------------
    */
    public function reject(
        Request $request,
        Pendaftaran $pendaftaran
    ) {
        /*
        |--------------------------------------------------------------------------
        | Hanya pengajuan menunggu yang dapat diproses
        |--------------------------------------------------------------------------
        |
        | Tanpa guard ini, pengajuan yang sudah disetujui atau
        | dibatalkan user bisa ditolak, sehingga aula terbuang
        | padahal pemohon sudah diberi tahu bookings-nya.
        |
        */
        if ($pendaftaran->status !== 'menunggu') {
            return back()->with(
                'error',
                'Pengajuan ini sudah diproses sebelumnya.'
            );
        }


        $validated = $request->validate(
            [
                'catatan_admin' => [
                    'required',
                    'string',
                    'max:1000',
                ],
            ],
            [
                'catatan_admin.required' =>
                    'Alasan penolakan wajib diisi.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Tolak Pengajuan
        |--------------------------------------------------------------------------
        */
        $pendaftaran->update([
            'status' => 'ditolak',
            'catatan_admin' =>
                $validated['catatan_admin'],
        ]);


        return back()->with(
            'success',
            'Pengajuan berhasil ditolak.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */
    public function laporan(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Data Aula
        |--------------------------------------------------------------------------
        */
        $aulas = Aula::orderBy(
            'nama_aula'
        )->get();

        $aulaTerpilih = $aulas->firstWhere(
            'id',
            (int) $request->input('aula')
        ) ?? $aulas->first();


        /*
        |--------------------------------------------------------------------------
        | Bulan & Tahun Laporan
        |--------------------------------------------------------------------------
        |
        | Default bulan berjalan. Lihat method periodeBulan().
        |
        */
        $periode = $this->periodeBulan(
            $request->input('bulan'),
            $request->input('tahun')
        );

        $bulan = $periode['bulan'];
        $tahun = $periode['tahun'];

        $rekap = RekapKetersediaan::build(
            $aulaTerpilih?->id,
            $tahun,
            [$bulan],
            ['menunggu', 'disetujui', 'ditolak']
        );

        return view('admin.laporan', [
            'aulas' => $aulas,

            'aulaTerpilih' => $aulaTerpilih,

            'rekapBulanan' => $rekap['rekapBulanan'],

            'bulan' => $bulan,

            'tahun' => $tahun,

            'judulBulan' => $rekap['rekapBulanan'][0]['judul'],

            'periode' => $periode,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Data Aula
    |--------------------------------------------------------------------------
    */
    public function aulas()
    {
        $aulas = Aula::latest()->get();

        return view(
            'admin.aulas.index',
            [
                'aulas' => $aulas,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Aula
    |--------------------------------------------------------------------------
    */
    public function createAula()
    {
        return view(
            'admin.aulas.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Aula
    |--------------------------------------------------------------------------
    */
    public function storeAula(Request $request)
    {
        $validated = $request->validate([
            'nama_aula' => [
                'required',
                'string',
                'max:255',
            ],

            'kapasitas' => [
                'required',
                'integer',
                'min:1',
            ],

            'keterangan' => [
                'required',
                'string',
            ],

            'fasilitas' => [
                'nullable',
                'string',
            ],
        ]);


        Aula::create($validated);


        return redirect()
            ->route('admin.aulas.index')
            ->with(
                'success',
                'Data aula berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Aula
    |--------------------------------------------------------------------------
    */
    public function showAula(Aula $aula)
    {
        return view(
            'admin.aulas.show',
            [
                'aula' => $aula,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Aula
    |--------------------------------------------------------------------------
    */
    public function editAula(Aula $aula)
    {
        return view(
            'admin.aulas.edit',
            [
                'aula' => $aula,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Aula
    |--------------------------------------------------------------------------
    */
    public function updateAula(
        Request $request,
        Aula $aula
    ) {
        $validated = $request->validate([
            'nama_aula' => [
                'required',
                'string',
                'max:255',
            ],

            'kapasitas' => [
                'required',
                'integer',
                'min:1',
            ],

            'keterangan' => [
                'required',
                'string',
            ],

            'fasilitas' => [
                'nullable',
                'string',
            ],
        ]);


        $aula->update($validated);


        return redirect()
            ->route('admin.aulas.index')
            ->with(
                'success',
                'Data aula berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Aula
    |--------------------------------------------------------------------------
    */
    public function destroyAula(
        Aula $aula
    ) {
        $aula->delete();


        return redirect()
            ->route('admin.aulas.index')
            ->with(
                'success',
                'Data aula berhasil dihapus.'
            );
    }
}