@extends('layouts.app')

@section('title', 'Data Aula | RAPAT')

@section('content')



<div class="admin-aula-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="admin-aula-header">

        <div class="header-content">

            <h1>
                Data Aula
            </h1>

            <p>
                Kelola informasi aula yang tersedia untuk pemakaian
                dan pastikan data aula selalu diperbarui.
            </p>

        </div>


        <div class="header-action">

            <a
                href="{{ route('admin.aulas.create') }}"
                class="add-btn"
            >
                <x-icon name="plus" size="17" />
                Tambah Aula
            </a>

        </div>

    </div>


    {{-- =====================================================
         SUMMARY
    ====================================================== --}}

    <div class="summary-card">

        <div class="summary-icon">
            <x-icon name="building" />
        </div>

        <div>

            <span>
                Total Aula
            </span>

            <strong>
                {{ $aulas->count() }}
            </strong>

        </div>

    </div>


    {{-- =====================================================
         DATA CARD
    ====================================================== --}}

    <div class="data-card">

        <div class="card-header">

            <div>

                <h2>
                    Daftar Aula
                </h2>

                <p>
                    Informasi aula yang tersedia dalam sistem RAPAT.
                </p>

            </div>

            <div class="total-badge">
                {{ $aulas->count() }} Aula
            </div>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th class="col-no">
                            No
                        </th>
                        <th>Nama Aula</th>
                        <th>Kapasitas</th>
                        <th>Keterangan</th>
                        <th>Fasilitas</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($aulas as $index => $aula)

                        <tr>

                            {{-- NOMOR --}}
                            <td class="number-cell">
                                {{ $index + 1 }}
                            </td>


                            {{-- NAMA AULA --}}
                            <td>

                                <strong class="aula-name">
                                    {{ $aula->nama_aula }}
                                </strong>

                            </td>


                            {{-- KAPASITAS --}}
                            <td>

                                <span class="capacity">
                                    {{ str_contains(strtolower($aula->nama_aula ?? ''), 'kecil') ? '< 30 orang' : '> 30 orang' }}
                                </span>

                            </td>


                            {{-- KETERANGAN --}}
                            <td class="description-cell">

                                {{ $aula->keterangan }}

                            </td>


                            {{-- FASILITAS --}}
                            <td class="facility-cell">

                                @if($aula->fasilitas)

                                    {{ $aula->fasilitas }}

                                @else

                                    <span class="empty-value">
                                        Belum diisi
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="action-buttons">

                                    <a
                                        href="{{ route('admin.aulas.show', $aula) }}"
                                        class="action-detail"
                                    >
                                        Detail
                                    </a>


                                    <a
                                        href="{{ route('admin.aulas.edit', $aula) }}"
                                        class="action-edit"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.aulas.destroy', $aula) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus aula ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-delete"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="empty">

                                    <div class="empty-icon">
                                        <x-icon name="building" />
                                    </div>

                                    <h3>
                                        Belum Ada Data Aula
                                    </h3>

                                    <p>
                                        Silakan tambahkan data aula baru
                                        melalui tombol Tambah Aula.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection