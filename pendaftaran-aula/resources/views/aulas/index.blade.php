@extends('layouts.app')

@section('title', 'Daftar Aula | RAPAT')

@section('content')

<div class="aulas-page">

    <div class="page-header">

        <div class="header-left">

            <a
                href="{{ route('dashboard') }}"
                class="back-link"
            >
                <x-icon name="arrow-left" size="16" />
                Kembali
            </a>

            <h1>
                Daftar Aula
            </h1>

            <p>
                Pilih aula yang sesuai dengan kebutuhan kegiatan Anda,
                lalu ajukan pemakaian melalui formulir pendaftaran.
            </p>

        </div>

        <div class="header-action">

            <a
                href="{{ route('informasi') }}#ketentuan-pemakaian"
                class="back-btn"
            >
                <x-icon name="info" size="17" />
                Ketentuan Pemakaian
            </a>

        </div>

    </div>


    {{-- ======================================================
         DAFTAR AULA
    ======================================================= --}}

    @if($aulas->count() > 0)

        <div class="aula-list">

            @foreach ($aulas as $aula)

                @php

                    $namaAula = strtolower(
                        $aula->nama_aula ?? ''
                    );

                    if (str_contains($namaAula, 'kecil')) {

                        $foto = asset('images/aula-kecil.jpg');

                        $kapasitas = '< 30 orang';
                        $ukuran = '7,6 x 4 m';

                        $fasilitas = 'TV 65 inch';

                    } else {

                        $foto = asset('images/aula-besar.jpg');

                        // DIUBAH: kapasitas Aula Besar
                        $kapasitas = '> 30 orang, maksimal 100 orang';
                        $ukuran = '15 x 10 m';

                        $fasilitas = 'Audio System, Videotron, Lighting, Panggung';

                    }

                @endphp


                <article class="aula-card">

                    {{-- FOTO --}}

                    <div class="aula-photo">

                        <img
                            src="{{ $foto }}"
                            alt="{{ $aula->nama_aula }}"
                            loading="lazy"
                        >

                    </div>


                    {{-- INFO AULA --}}

                    <div class="aula-body">

                        <div class="aula-meta">

                            <span>
                                <x-icon name="users" size="15" />
                                Kapasitas {{ $kapasitas }}
                            </span>

                        </div>


                        <div class="aula-desc">

                            <p>
                                <x-icon name="check" size="16" />
                                <span>Fasilitas: {{ $fasilitas }}</span>
                            </p>

                        </div>


                        <div class="aula-action">

                            <a
                                href="{{ route('pendaftaran.create', $aula) }}"
                                class="btn-pilih"
                            >
                                Daftar {{ $aula->nama_aula }}
                                <x-icon name="arrow-right" size="17" />
                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                <x-icon name="building" />
            </div>

            <h3>
                Belum Ada Aula
            </h3>

            <p>
                Data aula belum tersedia. Silakan hubungi administrator.
            </p>

        </div>

    @endif

</div>

@endsection