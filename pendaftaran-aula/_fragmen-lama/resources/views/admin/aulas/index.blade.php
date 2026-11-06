@extends('layouts.app')
@section('title','Data Aula')
@section('content')
<div class="section-title"><h2>🏛️ Data Aula</h2><a class="btn" href="{{ route('admin.aulas.create') }}">+ Tambah Aula</a></div>
<div class="grid">
@foreach($aulas as $aula)
<div class="card">
<div class="aula-icon">{{ $aula->kapasitas >= 50 ? '🏛️' : '🏠' }}</div>
<h3>{{ $aula->nama_aula }}</h3><span class="capacity">{{ $aula->kapasitas }} orang</span>
<p>{{ $aula->keterangan }}</p>
@if($aula->fasilitas)<p style="margin-top:10px;font-size:13px"><strong>Fasilitas:</strong> {{ $aula->fasilitas }}</p>@endif
<div class="actions" style="margin-top:18px"><a class="btn secondary" href="{{ route('admin.aulas.edit',$aula) }}">Edit</a>
<form method="POST" action="{{ route('admin.aulas.destroy',$aula) }}">@csrf @method('DELETE')<button class="btn danger" onclick="return confirm('Hapus aula ini?')">Hapus</button></form></div>
</div>
@endforeach
</div>
@endsection
