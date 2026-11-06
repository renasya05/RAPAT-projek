@extends('layouts.app')

@section('title', 'Edit Aula | RAPAT')

@section('content')


<div class="page-container">

    <a href="{{ route('admin.aulas.index') }}" class="back-link">
        <x-icon name="arrow-left" size="16" />
        Kembali ke Data Aula
    </a>

    <div class="page-header">
        <div class="page-header-text">
            <h1>Edit Data Aula</h1>

            <p>
                Perbarui informasi data aula
                <strong>{{ $aula->nama_aula }}</strong>.
            </p>
        </div>
    </div>

    <div class="form-card">

        <div class="form-card-header">
            <h2>Informasi Aula</h2>
            <p>Sesuaikan data aula lalu simpan perubahan.</p>
        </div>

        <div class="form-body">

            @include('partials.errors')

            <form action="{{ route('admin.aulas.update', $aula->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- NAMA AULA --}}
                <div class="form-group">

                    <label for="nama_aula">
                        Nama Aula <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="nama_aula"
                        name="nama_aula"
                        value="{{ old('nama_aula', $aula->nama_aula) }}"
                        class="form-control"
                        placeholder="Contoh: Aula Serbaguna, Aula Pertemuan Lantai 2"
                        required
                        autofocus
                    >

                    @error('nama_aula')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>

                {{-- KAPASITAS --}}
                <div class="form-group">

                    <label for="kapasitas">
                        Kapasitas (orang) <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        id="kapasitas"
                        name="kapasitas"
                        value="{{ old('kapasitas', $aula->kapasitas) }}"
                        class="form-control"
                        min="1"
                        placeholder="Contoh: 100"
                        required
                    >

                    <div class="help-text">
                        Jumlah kapasitas maksimal peserta yang dapat ditampung.
                    </div>

                    @error('kapasitas')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>

                {{-- KETERANGAN --}}
                <div class="form-group">

                    <label for="keterangan">
                        Keterangan <span class="required">*</span>
                    </label>

                    <textarea
                        id="keterangan"
                        name="keterangan"
                        class="form-control"
                        placeholder="Deskripsi aula, peruntukan kegiatan, dan lokasi..."
                        required
                    >{{ old('keterangan', $aula->keterangan) }}</textarea>

                    @error('keterangan')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>

                {{-- FASILITAS --}}
                <div class="form-group">

                    <label for="fasilitas">
                        Fasilitas
                    </label>

                    <textarea
                        id="fasilitas"
                        name="fasilitas"
                        class="form-control"
                        placeholder="Contoh: AC, Sound System, Proyektor, Meja, Kursi, Podium..."
                    >{{ old('fasilitas', $aula->fasilitas) }}</textarea>

                    <div class="help-text">
                        Daftar fasilitas yang disediakan (opsional).
                    </div>

                    @error('fasilitas')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>

                {{-- BUTTON --}}
                <div class="button-area">

                    <a
                        href="{{ route('admin.aulas.index') }}"
                        class="btn btn-secondary">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
