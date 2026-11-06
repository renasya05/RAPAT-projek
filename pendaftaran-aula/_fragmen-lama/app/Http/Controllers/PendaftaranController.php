<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    private function jadwalBentrok(int $aulaId, string $tanggal, string $mulai, string $selesai, ?int $ignoreId = null): bool
    {
        return Pendaftaran::where('aula_id', $aulaId)
            ->whereDate('tanggal', $tanggal)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where(function ($q) use ($mulai, $selesai) {
                $q->where('jam_mulai', '<', $selesai)
                  ->where('jam_selesai', '>', $mulai);
            })
            ->exists();
    }

    public function create()
    {
        $aulas = Aula::orderBy('kapasitas', 'desc')->get();

        return view('pendaftaran.create', compact('aulas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'aula_id' => ['required', 'exists:aulas,id'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'jumlah_peserta' => ['required', 'integer', 'min:1'],
            'keperluan' => ['required', 'string', 'max:1000'],
        ], [
            'tanggal.after_or_equal' => 'Tanggal penggunaan tidak boleh sebelum hari ini.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        $aula = Aula::findOrFail($data['aula_id']);

        if ($data['jumlah_peserta'] > $aula->kapasitas) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_peserta' => "Jumlah peserta melebihi kapasitas {$aula->nama_aula} ({$aula->kapasitas} orang)."
                ]);
        }

        if ($this->jadwalBentrok(
            $aula->id,
            $data['tanggal'],
            $data['jam_mulai'],
            $data['jam_selesai']
        )) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal' => 'Jadwal aula sudah digunakan pada tanggal dan jam tersebut.'
                ]);
        }

        Pendaftaran::create([
            ...$data,
            'user_id' => Auth::id(),
            'status' => 'menunggu',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran aula berhasil dikirim dan menunggu persetujuan admin.');
    }

    public function show(Pendaftaran $pendaftaran)
    {
        abort_unless(
            $pendaftaran->user_id === Auth::id() || Auth::user()->isAdmin(),
            403
        );

        $pendaftaran->load(['aula', 'user']);

        return view('pendaftaran.show', compact('pendaftaran'));
    }

    public function cancel(Pendaftaran $pendaftaran)
    {
        abort_unless($pendaftaran->user_id === Auth::id(), 403);

        if ($pendaftaran->status !== 'menunggu') {
            return back()->withErrors(['status' => 'Pendaftaran yang sudah diproses tidak dapat dibatalkan.']);
        }

        $pendaftaran->update(['status' => 'dibatalkan']);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
