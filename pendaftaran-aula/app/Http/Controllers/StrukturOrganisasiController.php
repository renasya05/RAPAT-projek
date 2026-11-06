<?php

namespace App\Http\Controllers;

use App\Models\BagianSeksi;
use App\Models\Pendaftaran;
use App\Models\UnitOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Admin mengelola Bidang/Unit dan Subbagian/Seksi.
 *
 * Pengajuan menyimpan nama bidang/seksi sebagai teks, jadi ketika nama atau
 * induk sebuah seksi diubah, pengajuan lama ikut diperbarui ke nama baru
 * (dalam satu transaksi) supaya riwayat, laporan, dan isian otomatis
 * formulir tetap sinkron.
 */
class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $daftarUnit = UnitOrganisasi::with('bagianSeksis')
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        // Jumlah pengajuan per (bidang, seksi) untuk menandai yang sedang dipakai.
        $pakaiUnit = [];
        $pakaiSeksi = [];

        Pendaftaran::query()
            ->selectRaw('unit_organisasi, bagian_seksi, COUNT(*) as total')
            ->whereNotNull('unit_organisasi')
            ->groupBy('unit_organisasi', 'bagian_seksi')
            ->get()
            ->each(function ($baris) use (&$pakaiUnit, &$pakaiSeksi) {
                $pakaiUnit[$baris->unit_organisasi] =
                    ($pakaiUnit[$baris->unit_organisasi] ?? 0) + (int) $baris->total;

                $pakaiSeksi[$baris->unit_organisasi . '|' . $baris->bagian_seksi] =
                    (int) $baris->total;
            });

        return view('admin.struktur.index', compact(
            'daftarUnit',
            'pakaiUnit',
            'pakaiSeksi'
        ));
    }

    /* ------------------------------------------------------------------
     | Bidang / Unit
     | ------------------------------------------------------------------ */

    public function storeUnit(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:unit_organisasis,nama'],
        ], [
            'nama.required' => 'Nama Bidang / Unit wajib diisi.',
            'nama.unique' => 'Nama Bidang / Unit sudah ada.',
        ]);

        UnitOrganisasi::create([
            'nama' => trim($data['nama']),
            'urutan' => ((int) UnitOrganisasi::max('urutan')) + 1,
            'aktif' => true,
        ]);

        return back()->with('success', 'Bidang / Unit berhasil ditambahkan.');
    }

    public function updateUnit(Request $request, UnitOrganisasi $unit)
    {
        $data = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('unit_organisasis', 'nama')->ignore($unit->id),
            ],
            'urutan' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ], [
            'nama.required' => 'Nama Bidang / Unit wajib diisi.',
            'nama.unique' => 'Nama Bidang / Unit sudah ada.',
        ]);

        $namaLama = $unit->nama;
        $namaBaru = trim($data['nama']);

        $diperbarui = DB::transaction(function () use ($request, $unit, $data, $namaLama, $namaBaru) {

            $unit->update([
                'nama' => $namaBaru,
                'urutan' => (int) ($data['urutan'] ?? $unit->urutan),
                'aktif' => $request->boolean('aktif'),
            ]);

            if ($namaLama === $namaBaru) {
                return 0;
            }

            return Pendaftaran::where('unit_organisasi', $namaLama)
                ->update(['unit_organisasi' => $namaBaru]);
        });

        $pesan = 'Bidang / Unit berhasil disimpan.';

        if ($diperbarui > 0) {
            $pesan .= " {$diperbarui} pengajuan lama ikut diperbarui ke nama baru.";
        }

        return back()->with('success', $pesan);
    }

    public function destroyUnit(UnitOrganisasi $unit)
    {
        $dipakai = Pendaftaran::where('unit_organisasi', $unit->nama)->count();

        if ($dipakai > 0) {
            return back()->with(
                'error',
                "Bidang / Unit tidak dapat dihapus karena dipakai {$dipakai} pengajuan. "
                . 'Nonaktifkan saja agar tidak muncul lagi di formulir.'
            );
        }

        $unit->delete();

        return back()->with('success', 'Bidang / Unit berhasil dihapus.');
    }

    /* ------------------------------------------------------------------
     | Subbagian / Seksi
     | ------------------------------------------------------------------ */

    public function storeSeksi(Request $request, UnitOrganisasi $unit)
    {
        $data = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bagian_seksis', 'nama')
                    ->where('unit_organisasi_id', $unit->id),
            ],
        ], [
            'nama.required' => 'Nama Subbagian / Seksi wajib diisi.',
            'nama.unique' => 'Subbagian / Seksi itu sudah ada di bidang ini.',
        ]);

        $unit->bagianSeksis()->create([
            'nama' => trim($data['nama']),
            'urutan' => ((int) $unit->bagianSeksis()->max('urutan')) + 1,
            'aktif' => true,
        ]);

        return back()->with('success', 'Subbagian / Seksi berhasil ditambahkan.');
    }

    public function updateSeksi(Request $request, BagianSeksi $seksi)
    {
        $data = $request->validate([
            'unit_organisasi_id' => ['required', 'integer', 'exists:unit_organisasis,id'],
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bagian_seksis', 'nama')
                    ->where('unit_organisasi_id', $request->input('unit_organisasi_id'))
                    ->ignore($seksi->id),
            ],
            'urutan' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ], [
            'unit_organisasi_id.required' => 'Bidang / Unit wajib dipilih.',
            'unit_organisasi_id.exists' => 'Bidang / Unit tidak valid.',
            'nama.required' => 'Nama Subbagian / Seksi wajib diisi.',
            'nama.unique' => 'Subbagian / Seksi itu sudah ada di bidang tujuan.',
        ]);

        $unitLama = $seksi->unit->nama;
        $namaLama = $seksi->nama;

        $unitBaru = UnitOrganisasi::findOrFail($data['unit_organisasi_id']);
        $namaBaru = trim($data['nama']);

        $diperbarui = DB::transaction(function () use ($request, $seksi, $data, $unitBaru, $unitLama, $namaLama, $namaBaru) {

            $seksi->update([
                'unit_organisasi_id' => $unitBaru->id,
                'nama' => $namaBaru,
                'urutan' => (int) ($data['urutan'] ?? $seksi->urutan),
                'aktif' => $request->boolean('aktif'),
            ]);

            if ($unitLama === $unitBaru->nama && $namaLama === $namaBaru) {
                return 0;
            }

            return Pendaftaran::where('unit_organisasi', $unitLama)
                ->where('bagian_seksi', $namaLama)
                ->update([
                    'unit_organisasi' => $unitBaru->nama,
                    'bagian_seksi' => $namaBaru,
                ]);
        });

        $pesan = 'Subbagian / Seksi berhasil disimpan.';

        if ($diperbarui > 0) {
            $pesan .= " {$diperbarui} pengajuan lama ikut diperbarui.";
        }

        return back()->with('success', $pesan);
    }

    public function destroySeksi(BagianSeksi $seksi)
    {
        $dipakai = Pendaftaran::where('unit_organisasi', $seksi->unit->nama)
            ->where('bagian_seksi', $seksi->nama)
            ->count();

        if ($dipakai > 0) {
            return back()->with(
                'error',
                "Subbagian / Seksi tidak dapat dihapus karena dipakai {$dipakai} pengajuan. "
                . 'Nonaktifkan saja agar tidak muncul lagi di formulir.'
            );
        }

        $seksi->delete();

        return back()->with('success', 'Subbagian / Seksi berhasil dihapus.');
    }
}