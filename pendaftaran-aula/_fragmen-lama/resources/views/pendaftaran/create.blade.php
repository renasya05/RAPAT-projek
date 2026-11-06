@extends('layouts.app')
@section('title','Pendaftaran Aula')
@section('content')
<div class="section-title"><h2>📝 Pendaftaran Aula</h2></div>
<div class="card form-card">
<form method="POST" action="{{ route('pendaftaran.store') }}">@csrf
<div class="form-group">
<label>Pilih Aula</label>
<select name="aula_id" id="aula_id" required>
<option value="">-- Pilih Aula --</option>
@foreach($aulas as $aula)
<option value="{{ $aula->id }}" data-capacity="{{ $aula->kapasitas }}" @selected(old('aula_id')==$aula->id)>
{{ $aula->nama_aula }} — kapasitas {{ $aula->kapasitas }} orang
</option>
@endforeach
</select>
</div>
<div id="infoAula" class="alert success" style="display:none"></div>
<div class="two">
<div class="form-group"><label>Tanggal Penggunaan</label><input type="date" name="tanggal" min="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}" required></div>
<div class="form-group"><label>Jumlah Peserta</label><input type="number" id="jumlah_peserta" name="jumlah_peserta" min="1" value="{{ old('jumlah_peserta') }}" required><small id="capacityInfo" style="color:#9a7786"></small></div>
</div>
<div class="two">
<div class="form-group"><label>Jam Mulai</label><input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" required></div>
<div class="form-group"><label>Jam Selesai</label><input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" required></div>
</div>
<div class="form-group"><label>Keperluan / Nama Kegiatan</label><textarea name="keperluan" placeholder="Contoh: Rapat koordinasi bulanan..." required>{{ old('keperluan') }}</textarea></div>
<div class="actions"><button class="btn">Kirim Pendaftaran</button><a class="btn secondary" href="{{ route('dashboard') }}">Kembali</a></div>
</form>
</div>
<script>
const aula=document.getElementById('aula_id'), peserta=document.getElementById('jumlah_peserta'), info=document.getElementById('capacityInfo'), box=document.getElementById('infoAula');
function updateCapacity(){
 const opt=aula.options[aula.selectedIndex];
 const cap=opt?.dataset?.capacity;
 if(cap){info.textContent='Kapasitas maksimal: '+cap+' orang';box.style.display='block';box.textContent='Aula dipilih: '+opt.text;}
 else{info.textContent='';box.style.display='none'}
}
aula.addEventListener('change',updateCapacity); updateCapacity();
</script>
@endsection
