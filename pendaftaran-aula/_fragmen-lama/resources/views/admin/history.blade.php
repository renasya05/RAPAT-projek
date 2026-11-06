@extends('layouts.app')
@section('title','Riwayat Pendaftaran')
@section('content')
<div class="section-title"><h2>🗂️ Riwayat Pendaftaran</h2><a class="btn secondary" href="{{ route('admin.dashboard') }}">Kembali</a></div>
<div class="card table-wrap">
<table><thead><tr><th>Pemohon</th><th>Aula</th><th>Tanggal</th><th>Waktu</th><th>Peserta</th><th>Status</th><th>Catatan</th></tr></thead>
<tbody>@forelse($pendaftarans as $p)
<tr><td>{{ $p->user->name }}</td><td>{{ $p->aula->nama_aula }}</td><td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td><td>{{ substr($p->jam_mulai,0,5) }} - {{ substr($p->jam_selesai,0,5) }}</td><td>{{ $p->jumlah_peserta }}</td><td><span class="badge {{ $p->status }}">{{ ucfirst($p->status) }}</span></td><td>{{ $p->catatan_admin ?? '-' }}</td></tr>
@empty<tr><td colspan="7" class="empty">Belum ada riwayat.</td></tr>@endforelse</tbody>
</table><div style="padding:15px">{{ $pendaftarans->links() }}</div>
</div>
@endsection
