<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $aulas = Aula::orderBy('kapasitas', 'desc')->get();

        $pendaftarans = Pendaftaran::with('aula')
            ->where('user_id', Auth::id())
            ->latest('tanggal')
            ->latest('jam_mulai')
            ->get();

        return view('dashboard', compact('aulas', 'pendaftarans'));
    }
}
