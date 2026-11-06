@extends('layouts.app')
@section('title','Edit Aula')
@section('content')
<div class="section-title"><h2>🏛️ Edit Aula</h2></div>
<div class="card form-card">
<form method="POST" action="{{ $aula->exists ? route('admin.aulas.update',$aula) : route('admin.aulas.store') }}">
@csrf @if($aula->exists) @method('PUT') @endif
<div class="form-group"><label>Nama Aula</label><input name="nama_aula" value="{{ old('nama_aula',$aula->nama_aula) }}" required></div>
<div class="form-group"><label>Kapasitas (orang)</label><input type="number" name="kapasitas" min="1" value="{{ old('kapasitas',$aula->kapasitas) }}" required></div>
<div class="form-group"><label>Keterangan</label><textarea name="keterangan" required>{{ old('keterangan',$aula->keterangan) }}</textarea></div>
<div class="form-group"><label>Fasilitas</label><textarea name="fasilitas">{{ old('fasilitas',$aula->fasilitas) }}</textarea></div>
<div class="actions"><button class="btn">Simpan</button><a class="btn secondary" href="{{ route('admin.aulas') }}">Batal</a></div>
</form>
</div>
@endsection
