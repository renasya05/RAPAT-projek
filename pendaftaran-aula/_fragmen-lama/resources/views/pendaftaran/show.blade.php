@extends('layouts.app')
@section('title','Detail Pendaftaran')
@section('content')
<div class="section-title"><h2>📄 Detail Pendaftaran</h2></div>
<div class="card">
<div class="detail-grid">
<div class="detail-item"><small>Nama Pemohon</small><strong>{{ $pendaftaran->user->name }}</strong></div>
<div class="detail-item"><small>Aula</small><strong>{{ $pendaftaran->aula->nama_aula }}</strong></div>
<div class="detail-item"><small>Kapasitas Aula</small><strong>{{ $pendaftaran->aula->kapasitas }} orang</strong></div>
<div class="detail-item"><small>Jumlah Peserta</small><strong>{{ $pendaftaran->jumlah_peserta }} orang</strong></div>
<div class="detail-item"><small>Tanggal</small><strong>{{ \Carbon\Carbon::parse($pendaftaran->tanggal)->format('d F Y') }}</strong></div>
<div class="detail-item"><small>Waktu</small><strong>{{ substr($pendaftaran->jam_mulai,0,5) }} - {{ substr($pendaftaran->jam_selesai,0,5) }}</strong></div>
<div class="detail-item"><small>Status</small><span class="badge {{ $pendaftaran->status }}">{{ ucfirst($pendaftaran->status) }}</span></div>
<div class="detail-item"><small>Dibuat</small><strong>{{ $pendaftaran->created_at->format('d/m/Y H:i') }}</strong></div>
</div>
<div style="margin-top:18px"><strong>Keperluan</strong><p style="margin-top:7px">{{ $pendaftaran->keperluan }}</p></div>
@if($pendaftaran->catatan_admin)<div class="alert success" style="margin-top:18px"><strong>Catatan Admin:</strong><br>{{ $pendaftaran->catatan_admin }}</div>@endif
<div style="margin-top:20px"><a class="btn secondary" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}">Kembali</a></div>
</div>
@endsection
