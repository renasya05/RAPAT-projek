<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Pendaftaran;
use App\Models\UnitOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    /**
     * Struktur organisasi dan bagian/seksi.
     *
     * Dibaca dari database (diatur admin di menu Struktur Organisasi).
     * Hanya yang berstatus aktif yang bisa dipilih di formulir.
     *
     * @return array<string, array<int, string>>
     */
    private function strukturOrganisasi(): array
    {
        return UnitOrganisasi::query()
            ->where('aktif', true)
            ->with(['bagianSeksis' => fn ($q) => $q->where('aktif', true)])
            ->orderBy('urutan')
            ->orderBy('id')
            ->get()
            ->mapWithKeys(fn ($unit) => [
                $unit->nama => $unit->bagianSeksis->pluck('nama')->all(),
            ])
            ->all();
    }

    /**
     * Data pemohon dari pengajuan terakhir pengguna, untuk mengisi formulir
     * otomatis. Bidang/seksi hanya diisi jika masih ada di daftar aktif.
     */
    private function prefillPemohon($user, array $struktur): array
    {
        $prefill = [
            'nama_pemohon' => $user->name ?? '',
            'jabatan' => '',
            'unit_organisasi' => '',
            'bagian_seksi' => '',
            'dari_riwayat' => false,
        ];

        if (!$user) {
            return $prefill;
        }

        $terakhir = Pendaftaran::where('user_id', $user->id)
            ->latest('id')
            ->first();

        if (!$terakhir) {
            return $prefill;
        }

        $prefill['dari_riwayat'] = true;

        if (!empty(trim((string) $terakhir->nama_pemohon))) {
            $prefill['nama_pemohon'] = $terakhir->nama_pemohon;
        }

        $jabatan = trim((string) $terakhir->jabatan);

        if ($jabatan !== '' && $jabatan !== '-') {
            $prefill['jabatan'] = $jabatan;
        }

        $unit = $terakhir->unit_organisasi;
        $bagian = $terakhir->bagian_seksi;

        if ($unit && isset($struktur[$unit])) {

            $prefill['unit_organisasi'] = $unit;

            if ($bagian && in_array($bagian, $struktur[$unit], true)) {
                $prefill['bagian_seksi'] = $bagian;
            }
        }

        return $prefill;
    }

    /**
     * Menampilkan form pendaftaran.
     */
    public function create(Aula $aula)
    {
        $struktur = $this->strukturOrganisasi();
        $user = Auth::user();
        $prefill = $this->prefillPemohon($user, $struktur);

        return view(
            'pendaftaran.create',
            compact(
                'aula',
                'struktur',
                'user',
                'prefill'
            )
        );
    }

    /**
     * Menyimpan pendaftaran baru.
     */
    public function store(Request $request)
    {
        /**
         * Validasi data form.
         */
        $validated = $request->validate([
            'aula_id' => [
                'required',
                'exists:aulas,id',
            ],

            'nama_pemohon' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'peserta_asal' => [
                'required',
                'in:internal,internal_eksternal',
            ],

            'unit_organisasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bagian_seksi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'instansi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tanggal_mulai' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai',
            ],

            'kriteria_waktu' => [
                'required',
                'in:pagi_siang,siang_sore,malam,gabungan_pagi_siang,gabungan_siang_malam,gabungan_pagi_malam',
            ],

            'jumlah_peserta' => [
                'required',
                'integer',
                'min:1',
            ],

            'keperluan' => [
                'required',
                'string',
            ],
        ]);

        /**
         * Struktur organisasi.
         */
        $struktur = $this->strukturOrganisasi();

        $pesertaAsal = $validated['peserta_asal'];

        $unitOrganisasi = null;
        $bagianSeksi = null;
        $instansi = null;

        /**
         * Peserta Internal.
         */
        if ($pesertaAsal === 'internal') {

            if (empty($validated['unit_organisasi'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'unit_organisasi' =>
                            'Bidang / Unit wajib dipilih untuk peserta internal.',
                    ]);
            }

            if (empty($validated['bagian_seksi'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'bagian_seksi' =>
                            'Bagian / Seksi wajib dipilih untuk peserta internal.',
                    ]);
            }

            $unitOrganisasi = $validated['unit_organisasi'];

            $bagianSeksi = $validated['bagian_seksi'];

            $instansi = 'DISKOMINFO';
        }

        /**
         * Peserta Eksternal.
         */
        elseif ($pesertaAsal === 'eksternal') {

            if (empty($validated['instansi'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'instansi' =>
                            'Nama Instansi / Organisasi wajib diisi untuk peserta eksternal.',
                    ]);
            }

            $instansi = $validated['instansi'];
        }

        /**
         * Peserta Internal & Eksternal.
         */
        elseif ($pesertaAsal === 'internal_eksternal') {

            if (empty($validated['unit_organisasi'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'unit_organisasi' =>
                            'Bidang / Unit wajib dipilih untuk peserta internal & eksternal.',
                    ]);
            }

            if (empty($validated['bagian_seksi'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'bagian_seksi' =>
                            'Bagian / Seksi wajib dipilih untuk peserta internal & eksternal.',
                    ]);
            }

            if (empty($validated['instansi'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'instansi' =>
                            'Nama Instansi / Organisasi wajib diisi untuk peserta internal & eksternal.',
                    ]);
            }

            $unitOrganisasi = $validated['unit_organisasi'];

            $bagianSeksi = $validated['bagian_seksi'];

            $instansi = $validated['instansi'];
        }

        /**
         * Validasi Unit Organisasi dan Bagian/Seksi.
         */
        if ($unitOrganisasi !== null) {

            if (!array_key_exists($unitOrganisasi, $struktur)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'unit_organisasi' =>
                            'Bidang / Unit yang dipilih tidak valid.',
                    ]);
            }

            if (
                $bagianSeksi !== null &&
                !in_array(
                    $bagianSeksi,
                    $struktur[$unitOrganisasi],
                    true
                )
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'bagian_seksi' =>
                            'Bagian / Seksi tidak sesuai dengan Bidang / Unit yang dipilih.',
                    ]);
            }
        }

        /**
         * Ambil data aula.
         */
        $aula = Aula::findOrFail(
            $validated['aula_id']
        );

        /**
         * Validasi kapasitas aula.
         */
        if (
            $validated['jumlah_peserta']
            >
            $aula->kapasitas
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_peserta' =>
                        'Jumlah peserta melebihi kapasitas maksimum aula (' .
                        $aula->kapasitas .
                        ' orang).',
                ]);
        }

        /**
         * Peta slot waktu untuk mendeteksi bentrok,
         * termasuk opsi waktu gabungan.
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
            $validated['kriteria_waktu']
        ] ?? [];

        $kriteriaBentrok = [];

        foreach ($slotMap as $kriteria => $slots) {
            if (array_intersect($slotDiminta, $slots)) {
                $kriteriaBentrok[] = $kriteria;
            }
        }

        /**
         * Cek bentrok jadwal.
         *
         * Pendaftaran dengan status menunggu
         * atau disetujui dianggap menggunakan jadwal.
         *
         * Cek dan simpan dijalankan dalam satu transaksi sambil
         * mengunci baris aula, supaya dua pengajuan bersamaan untuk
         * slot yang sama tidak bisa dua-duanya lolos cek.
         */
        $bentrok = DB::transaction(function () use ($aula, $validated, $kriteriaBentrok, $instansi, $unitOrganisasi, $bagianSeksi, $pesertaAsal) {

            Aula::whereKey($aula->id)
                ->lockForUpdate()
                ->first();

            $bentrok = Pendaftaran::query()
                ->where(
                    'aula_id',
                    $aula->id
                )
                ->whereIn(
                    'status',
                    [
                        'menunggu',
                        'disetujui',
                    ]
                )
                ->whereNotNull(
                    'tanggal_mulai'
                )
                ->whereNotNull(
                    'tanggal_selesai'
                )
                // whereDate, bukan where: kolom date menyimpan
                // "2026-10-20 00:00:00", sehingga perbandingan
                // string dengan "2026-10-20" selalu salah dan
                // bentrok tidak pernah terdeteksi.
                ->whereDate(
                    'tanggal_mulai',
                    '<=',
                    $validated['tanggal_selesai']
                )
                ->whereDate(
                    'tanggal_selesai',
                    '>=',
                    $validated['tanggal_mulai']
                )
                ->whereIn(
                    'kriteria_waktu',
                    $kriteriaBentrok
                )
                ->exists();

            if ($bentrok) {
                return true;
            }

            /**
             * Simpan pendaftaran.
             *
             * Masih di dalam transaksi yang sama supaya baris
             * baru masuk sebelum lock aula dilepas.
             */
            Pendaftaran::create([
                'user_id' =>
                    Auth::id(),

                'aula_id' =>
                    $aula->id,

                'nama_pemohon' =>
                    $validated['nama_pemohon'],

                'nip' =>
                    '-',

                'jabatan' =>
                    $validated['jabatan'],

                'instansi' =>
                    $instansi,

                'unit_organisasi' =>
                    $unitOrganisasi,

                'bagian_seksi' =>
                    $bagianSeksi,

                'peserta_asal' =>
                    $pesertaAsal,

                'tanggal_mulai' =>
                    $validated['tanggal_mulai'],

                'tanggal_selesai' =>
                    $validated['tanggal_selesai'],

                'kriteria_waktu' =>
                    $validated['kriteria_waktu'],

                'jumlah_peserta' =>
                    $validated['jumlah_peserta'],

                'keperluan' =>
                    $validated['keperluan'],

                'status' =>
                    'menunggu',

                'catatan_admin' =>
                    null,
            ]);

            return false;
        });

        /**
         * Jika jadwal bentrok.
         */
        if ($bentrok) {

            $namaWaktu = [
                'pagi_siang' =>
                    'Pagi (08.00–13.00)',

                'siang_sore' =>
                    'Siang (14.00–16.00)',

                'malam' =>
                    'Malam (18.00–21.00)',

                'gabungan_pagi_siang' =>
                    'Full Day (1 hari penuh)',

                'gabungan_siang_malam' =>
                    'Full Day (1 hari penuh)',

                'gabungan_pagi_malam' =>
                    'Full Day (1 hari penuh)',
            ];

            return back()
                ->withInput()
                ->withErrors([
                    'kriteria_waktu' =>
                        'Waktu ' .
                        $namaWaktu[
                            $validated['kriteria_waktu']
                        ] .
                        ' sudah digunakan pada rentang tanggal tersebut. Silakan pilih waktu lain.',
                ]);
        }

        /**
         * Redirect ke riwayat.
         */
        return redirect()
            ->route(
                'pendaftaran.history'
            )
            ->with(
                'success',
                'Pendaftaran aula berhasil dikirim dan sedang menunggu persetujuan admin.'
            );
    }

    /**
     * Mengecek ketersediaan waktu.
     */
    public function availability(
        Request $request
    ) {
        $validated = $request->validate([
            'aula_id' => [
                'required',
                'exists:aulas,id',
            ],

            'tanggal_mulai' => [
                'required',
                'date',
            ],

            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai',
            ],
        ]);

        /**
         * Ambil waktu yang sudah digunakan.
         */
        $kriteriaTerpakai = Pendaftaran::query()
            ->where(
                'aula_id',
                $validated['aula_id']
            )
            ->whereIn(
                'status',
                [
                    'menunggu',
                    'disetujui',
                ]
            )
            ->whereNotNull(
                'tanggal_mulai'
            )
            ->whereNotNull(
                'tanggal_selesai'
            )
            // whereDate, bukan where: kolom date menyimpan
            // "2026-10-20 00:00:00", sehingga perbandingan string
            // dengan "2026-10-20" selalu salah.
            ->whereDate(
                'tanggal_mulai',
                '<=',
                $validated['tanggal_selesai']
            )
            ->whereDate(
                'tanggal_selesai',
                '>=',
                $validated['tanggal_mulai']
            )
            ->pluck(
                'kriteria_waktu'
            )
            ->unique()
            ->values()
            ->toArray();

        /**
         * Petakan ke slot waktu agar opsi gabungan
         * ikut terdeteksi bentrok.
         */
        $slotMap = [
            'pagi_siang' => ['pagi'],
            'siang_sore' => ['siang'],
            'malam' => ['malam'],
            'gabungan_pagi_siang' => ['pagi', 'siang', 'malam'],
            'gabungan_siang_malam' => ['pagi', 'siang', 'malam'],
            'gabungan_pagi_malam' => ['pagi', 'siang', 'malam'],
        ];

        $slotTerpakai = [];

        foreach ($kriteriaTerpakai as $kriteria) {
            foreach ($slotMap[$kriteria] ?? [] as $slot) {
                $slotTerpakai[$slot] = true;
            }
        }

        return response()->json([
            'terpakai' => $kriteriaTerpakai,
            'slotTerpakai' => array_keys($slotTerpakai),
        ]);
    }

    /**
     * Riwayat pendaftaran milik user.
     */
    public function history()
    {
        $pendaftarans = Pendaftaran::with(
            'aula'
        )
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->get();

        return view(
            'pendaftaran.history',
            compact(
                'pendaftarans'
            )
        );
    }

    /**
     * Detail pendaftaran milik user.
     */
    public function show(
        Pendaftaran $pendaftaran
    ) {
        /**
         * Pastikan user hanya dapat melihat
         * pendaftarannya sendiri.
         */
        if (
            $pendaftaran->user_id
            !==
            Auth::id()
        ) {
            abort(403);
        }

        $pendaftaran->load(
            'aula'
        );

        return view(
            'pendaftaran.show',
            compact(
                'pendaftaran'
            )
        );
    }


    /**
     * Batalkan pengajuan milik user sendiri
     * selama status masih Menunggu.
     */
    public function cancel(Pendaftaran $pendaftaran)
    {
        if (
            $pendaftaran->user_id
            !==
            Auth::id()
        ) {
            abort(403);
        }


        if ($pendaftaran->status !== 'menunggu') {
            return redirect()
                ->route('pendaftaran.show', $pendaftaran)
                ->with(
                    'error',
                    'Pengajuan hanya dapat dibatalkan selama status Menunggu.'
                );
        }


        /*
         * Update bersyarat: kalau admin sudah menyetujui antara
         * pengecekan di atas dan update ini, tidak ada baris yang
         * berubah dan pembatalan ditolak.
         */
        $dibatalkan = Pendaftaran::whereKey($pendaftaran->id)
            ->where('status', 'menunggu')
            ->update([
                'status' => 'dibatalkan',
            ]);

        if ($dibatalkan === 0) {
            return redirect()
                ->route('pendaftaran.show', $pendaftaran)
                ->with(
                    'error',
                    'Pengajuan hanya dapat dibatalkan selama status Menunggu.'
                );
        }


        return redirect()
            ->route('pendaftaran.history')
            ->with(
                'success',
                'Pengajuan berhasil dibatalkan.'
            );
    }
}