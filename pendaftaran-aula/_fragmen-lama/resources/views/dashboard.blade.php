@extends('layouts.app')
@section('title','Dashboard Pengguna')
@section('content')
<div class="hero">
    <h1>Halo, {{ auth()->user()->name }} 👋</h1>
    <p>Silakan pilih aula dan lakukan pendaftaran untuk kegiatan kantor.</p>
</div>

<div class="section-title"><h2>🏛️ Pilihan Aula</h2><a class="btn" href="{{ route('pendaftaran.create') }}">+ Daftar Aula</a></div>
<div class="grid">
@foreach($aulas as $aula)
<div class="card aula-card">
    <div class="aula-icon">{{ $aula->kapasitas >= 50 ? '🏛️' : '🏠' }}</div>
    <h3>{{ $aula->nama_aula }}</h3>
    <span class="capacity">👥 {{ $aula->kapasitas }} orang</span>
    <p>{{ $aula->keterangan }}</p>
    @if($aula->fasilitas)<p style="margin-top:10px;font-size:13px;color:#806572"><strong>Fasilitas:</strong> {{ $aula->fasilitas }}</p>@endif
</div>
@endforeach
</div>

<div class="section-title"><h2>📋 Pendaftaran Saya</h2></div>
<div class="card table-wrap">
@if($pendaftarans->count())
<table><thead><tr><th>Aula</th><th>Tanggal</th><th>Waktu</th><th>Peserta</th><th>Status</th><th>Aksi</th></tr></thead>
<tbody>@foreach($pendaftarans as $p)
<tr>
<td><strong>{{ $p->aula->nama_aula }}</strong><br><small>{{ Str::limit($p->keperluan,40) }}</small></td>
<td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
<td>{{ substr($p->jam_mulai,0,5) }} - {{ substr($p->jam_selesai,0,5) }}</td>
<td>{{ $p->jumlah_peserta }}</td>
<td><span class="badge {{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
<td><a class="btn secondary" href="{{ route('pendaftaran.show',$p) }}">Detail</a>
@if($p->status==='menunggu')<form action="{{ route('pendaftaran.cancel',$p) }}" method="POST" style="display:inline">@csrf<button class="btn danger" onclick="return confirm('Batalkan pendaftaran ini?')">Batal</button></form>@endif</td>
</tr>@endforeach</tbody></table>
@else<div class="empty">Belum ada pendaftaran aula.</div>@endif
</div>
@endsection
