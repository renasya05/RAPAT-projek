@extends('layouts.app')
@section('title','Tambah Aula')
@section('content')
<div class="section-title"><h2>🏛️ Tambah Aula</h2></div>
<div class="card form-card">
<form method="POST" action="{{ route('admin.aulas.store') }}">
@csrf 
<div class="form-group"><label>Nama Aula</label><input name="nama_aula" value="{{ old('nama_aula') }}" required></div>
<div class="form-group"><label>Kapasitas (orang)</label><input type="number" name="kapasitas" min="1" value="{{ old('kapasitas') }}" required></div>
<div class="form-group"><label>Keterangan</label><textarea name="keterangan" required>{{ old('keterangan') }}</textarea></div>
<div class="form-group"><label>Fasilitas</label><textarea name="fasilitas">{{ old('fasilitas') }}</textarea></div>
<div class="actions"><button class="btn">Simpan</button><a class="btn secondary" href="{{ route('admin.aulas') }}">Batal</a></div>
</form>
</div>
@endsection
