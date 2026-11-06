@extends('layouts.app')
@section('title','Dashboard Admin')
@section('content')
<div class="hero"><h1>Dashboard Admin 🛠️</h1><p>Kelola pendaftaran dan penggunaan aula kantor.</p></div>
<div class="stats">
<div class="stat"><small>Total Pendaftaran</small><strong>{{ $stats['total'] }}</strong></div>
<div class="stat"><small>Menunggu</small><strong>{{ $stats['menunggu'] }}</strong></div>
<div class="stat"><small>Disetujui</small><strong>{{ $stats['disetujui'] }}</strong></div>
<div class="stat"><small>Ditolak</small><strong>{{ $stats['ditolak'] }}</strong></div>
</div>
<div class="section-title"><h2>📋 Data Pendaftaran</h2><a class="btn secondary" href="{{ route('admin.history') }}">Riwayat</a></div>
<div class="card table-wrap">
<table><thead><tr><th>Pemohon</th><th>Aula</th><th>Jadwal</th><th>Peserta</th><th>Status</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($pendaftarans as $p)
<tr>
<td><strong>{{ $p->user->name }}</strong><br><small>{{ $p->user->email }}</small></td>
<td>{{ $p->aula->nama_aula }}</td>
<td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}<br>{{ substr($p->jam_mulai,0,5) }} - {{ substr($p->jam_selesai,0,5) }}</td>
<td>{{ $p->jumlah_peserta }}</td>
<td><span class="badge {{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
<td>
<div class="actions">
<a class="btn secondary" href="{{ route('pendaftaran.show',$p) }}">Detail</a>
@if($p->status==='menunggu')
<form method="POST" action="{{ route('admin.pendaftaran.approve',$p) }}">@csrf<button class="btn success" onclick="return confirm('Setujui pendaftaran ini?')">Setujui</button></form>
<form method="POST" action="{{ route('admin.pendaftaran.reject',$p) }}">@csrf<input type="hidden" name="catatan_admin" value="Pendaftaran ditolak oleh admin."><button class="btn danger" onclick="return confirm('Tolak pendaftaran ini?')">Tolak</button></form>
@endif
</div>
</td>
</tr>
@empty<tr><td colspan="6" class="empty">Belum ada pendaftaran.</td></tr>@endforelse
</tbody></table>
<div style="padding:15px">{{ $pendaftarans->links() }}</div>
</div>
@endsection
