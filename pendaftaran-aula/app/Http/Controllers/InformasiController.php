<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
    /**
     * Halaman Informasi untuk pengguna:
     * informasi aula, panduan pendaftaran, ketentuan pemakaian,
     * keputusan pengajuan, serta bantuan.
     */
    public function index()
    {
        /*
        |----------------------------------------------------------------------
        | Informasi aula
        |----------------------------------------------------------------------
        |
        | Nama, keterangan, dan id aula diambil dari database.
        | Kapasitas, ukuran, fasilitas, dan foto mengikuti data yang sudah
        | dipakai di Dashboard dan Daftar Aula (dikenali dari nama aula).
        | Aula lain yang mungkin ditambahkan admin tetap tampil memakai
        | data dari database tanpa foto.
        |
        */

        $aulas = Aula::orderBy('nama_aula')->get()->map(function ($aula) {

            $nama = strtolower($aula->nama_aula ?? '');

            if (str_contains($nama, 'kecil')) {

                return [
                    'aula' => $aula,
                    'foto' => asset('images/aula-kecil.jpg'),
                    'kapasitas' => 'Maksimal 30 orang',
                    'ukuran' => 'Sekitar 7,6 × 4 meter',
                    'fasilitas' => 'TV 65 inch',
                ];
            }

            if (str_contains($nama, 'besar')) {

                return [
                    'aula' => $aula,
                    'foto' => asset('images/aula-besar.jpg'),
                    'kapasitas' => 'Lebih dari 100 orang',
                    'ukuran' => 'Sekitar 15 × 10 meter',
                    'fasilitas' => 'Sistem Audio, Videotron, Lighting, Panggung',
                ];
            }

            return [
                'aula' => $aula,
                'foto' => null,
                'kapasitas' => $aula->kapasitas
                    ? $aula->kapasitas . ' orang'
                    : null,
                'ukuran' => null,
                'fasilitas' => $aula->fasilitas,
            ];
        });


        /*
        |----------------------------------------------------------------------
        | Keputusan Pengajuan
        |----------------------------------------------------------------------
        |
        | Notifikasi untuk pengguna yang sedang login: pengajuannya yang
        | sudah diputuskan admin (disetujui atau ditolak), terbaru di atas.
        | Alasan penolakan diambil dari kolom catatan_admin.
        |
        */

        $namaWaktu = [
            'pagi_siang' => 'Pagi (08.00 – 13.00)',
            'siang_sore' => 'Siang (14.00 – 16.00)',
            'malam' => 'Malam (18.00 – 21.00)',
            'gabungan_pagi_siang' => 'Full Day',
            'gabungan_siang_malam' => 'Full Day',
            'gabungan_pagi_malam' => 'Full Day',
        ];

        $keputusans = Pendaftaran::with('aula')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->latest('updated_at')
            ->limit(10)
            ->get()
            ->map(function ($p) use ($namaWaktu) {

                $mulai = $p->tanggal_mulai
                    ? Carbon::parse($p->tanggal_mulai)->locale('id')
                    : null;

                $selesai = $p->tanggal_selesai
                    ? Carbon::parse($p->tanggal_selesai)->locale('id')
                    : null;

                $tanggal = null;

                if ($mulai) {
                    $tanggal = $mulai->translatedFormat('d F Y');

                    if ($selesai && !$selesai->isSameDay($mulai)) {
                        $tanggal .= ' – ' . $selesai->translatedFormat('d F Y');
                    }
                }

                return [
                    'status' => $p->status,
                    'aula' => $p->aula->nama_aula ?? 'Aula',
                    'tanggal' => $tanggal,
                    'waktu' => $namaWaktu[$p->kriteria_waktu] ?? null,
                    'catatan' => $p->status === 'ditolak'
                        ? $p->catatan_admin
                        : null,
                    'diputuskan' => $p->updated_at
                        ? Carbon::parse($p->updated_at)
                            ->locale('id')
                            ->translatedFormat('d F Y, H.i')
                        : null,
                    'url' => route('pendaftaran.show', $p),
                ];
            });


        return view(
            'informasi.index',
            compact('aulas', 'keputusans')
        );
    }
}