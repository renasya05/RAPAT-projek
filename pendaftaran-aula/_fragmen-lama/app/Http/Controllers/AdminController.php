<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function adminOnly(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }

    public function dashboard()
    {
        $this->adminOnly();

        $stats = [
            'total' => Pendaftaran::count(),
            'menunggu' => Pendaftaran::where('status', 'menunggu')->count(),
            'disetujui' => Pendaftaran::where('status', 'disetujui')->count(),
            'ditolak' => Pendaftaran::where('status', 'ditolak')->count(),
        ];

        $pendaftarans = Pendaftaran::with(['user', 'aula'])
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('stats', 'pendaftarans'));
    }

    public function approve(Pendaftaran $pendaftaran)
    {
        $this->adminOnly();

        if ($pendaftaran->status !== 'menunggu') {
            return back()->withErrors(['status' => 'Pendaftaran ini sudah diproses.']);
        }

        $aula = $pendaftaran->aula;

        $bentrok = Pendaftaran::where('id', '!=', $pendaftaran->id)
            ->where('aula_id', $aula->id)
            ->whereDate('tanggal', $pendaftaran->tanggal)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where('jam_mulai', '<', $pendaftaran->jam_selesai)
            ->where('jam_selesai', '>', $pendaftaran->jam_mulai)
            ->exists();

        if ($pendaftaran->jumlah_peserta > $aula->kapasitas) {
            return back()->withErrors(['status' => 'Jumlah peserta melebihi kapasitas aula.']);
        }

        if ($bentrok) {
            return back()->withErrors(['status' => 'Tidak dapat menyetujui karena jadwal aula bentrok.']);
        }

        $pendaftaran->update([
            'status' => 'disetujui',
            'catatan_admin' => 'Pendaftaran disetujui oleh admin.',
        ]);

        return back()->with('success', 'Pendaftaran berhasil disetujui.');
    }

    public function reject(Request $request, Pendaftaran $pendaftaran)
    {
        $this->adminOnly();

        $data = $request->validate([
            'catatan_admin' => ['nullable', 'string', 'max:500'],
        ]);

        $pendaftaran->update([
            'status' => 'ditolak',
            'catatan_admin' => $data['catatan_admin'] ?? 'Pendaftaran ditolak oleh admin.',
        ]);

        return back()->with('success', 'Pendaftaran berhasil ditolak.');
    }

    public function history()
    {
        $this->adminOnly();

        $pendaftarans = Pendaftaran::with(['user', 'aula'])
            ->whereIn('status', ['disetujui', 'ditolak', 'dibatalkan'])
            ->latest()
            ->paginate(15);

        return view('admin.history', compact('pendaftarans'));
    }

    public function aulas()
    {
        $this->adminOnly();

        $aulas = Aula::latest()->get();

        return view('admin.aulas.index', compact('aulas'));
    }

    public function createAula()
    {
        $this->adminOnly();

        return view('admin.aulas.create');
    }

    public function storeAula(Request $request)
    {
        $this->adminOnly();

        $data = $request->validate([
            'nama_aula' => ['required', 'string', 'max:100'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'keterangan' => ['required', 'string', 'max:500'],
            'fasilitas' => ['nullable', 'string', 'max:500'],
        ]);

        Aula::create($data);

        return redirect()->route('admin.aulas')->with('success', 'Data aula berhasil ditambahkan.');
    }

    public function editAula(Aula $aula)
    {
        $this->adminOnly();

        return view('admin.aulas.edit', compact('aula'));
    }

    public function updateAula(Request $request, Aula $aula)
    {
        $this->adminOnly();

        $data = $request->validate([
            'nama_aula' => ['required', 'string', 'max:100'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'keterangan' => ['required', 'string', 'max:500'],
            'fasilitas' => ['nullable', 'string', 'max:500'],
        ]);

        $aula->update($data);

        return redirect()->route('admin.aulas')->with('success', 'Data aula berhasil diperbarui.');
    }

    public function destroyAula(Aula $aula)
    {
        $this->adminOnly();

        if ($aula->pendaftarans()->exists()) {
            return back()->withErrors(['aula' => 'Aula tidak dapat dihapus karena sudah memiliki riwayat pendaftaran.']);
        }

        $aula->delete();

        return back()->with('success', 'Aula berhasil dihapus.');
    }
}
