@extends('layouts.app')

@section('title', 'Struktur Organisasi | RAPAT')

@section('content')

<style>
    .struktur-page { display: grid; gap: 22px; }

    .struktur-page .struktur-intro h1 {
        margin: 0 0 6px;
        color: var(--heading);
        font-size: 1.8rem;
    }

    .struktur-page .struktur-intro p {
        margin: 0;
        color: var(--muted);
        max-width: 760px;
    }

    .struktur-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: 0 6px 18px rgba(18, 42, 94, 0.05);
    }

    .struktur-card.nonaktif { background: var(--surface-alt); }
    .struktur-card.nonaktif .unit-judul { opacity: .65; }

    .struktur-baris {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .struktur-baris form { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin: 0; }
    .struktur-baris .grow { flex: 1 1 280px; min-width: 220px; }
    .struktur-baris .grow input[type="text"],
    .struktur-baris .grow select { width: 100%; }
    .struktur-baris input.urutan { width: 78px; }
    .struktur-baris .aktif-cek { display: inline-flex; align-items: center; gap: 6px; font-size: .88rem; color: var(--muted); white-space: nowrap; }

    .btn-struktur {
        border: 0;
        border-radius: 10px;
        padding: 9px 14px;
        font-weight: 700;
        font-size: .86rem;
        cursor: pointer;
        background: var(--primary);
        color: #fff;
    }

    .btn-struktur.hapus { background: var(--danger-bg); color: var(--danger-fg); }
    .btn-struktur.hapus[disabled] { opacity: .45; cursor: not-allowed; }

    .lencana-pakai {
        font-size: .76rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 999px;
        background: var(--info-bg);
        color: var(--info-fg);
        white-space: nowrap;
    }

    .seksi-daftar {
        margin: 16px 0 0;
        padding: 14px 0 0;
        border-top: 1px dashed var(--border-strong);
        display: grid;
        gap: 10px;
    }

    .seksi-daftar .label-kecil {
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--faint);
    }

    .tambah-baris { margin-top: 6px; }

    .struktur-tambah-unit { border-style: dashed; }
</style>

<div class="struktur-page">

    <div class="struktur-intro">
        <h1>Struktur Organisasi</h1>
        <p>
            Kelola daftar Bidang / Unit dan Subbagian / Seksi yang muncul di formulir
            pendaftaran. Jika nama diubah, pengajuan lama otomatis ikut memakai nama baru.
            Yang sudah pernah dipakai tidak bisa dihapus, hanya dinonaktifkan.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">
                @foreach ($errors->all() as $pesan)
                    <div>{{ $pesan }}</div>
                @endforeach
            </div>
        </div>
    @endif


    {{-- TAMBAH BIDANG / UNIT --}}
    <div class="struktur-card struktur-tambah-unit">
        <form method="POST" action="{{ route('admin.struktur.unit.store') }}" class="struktur-baris">
            @csrf
            <div class="grow">
                <input type="text" name="nama" placeholder="Nama Bidang / Unit baru" maxlength="255" required>
            </div>
            <button type="submit" class="btn-struktur">
                <x-icon name="plus" size="15" /> Tambah Bidang / Unit
            </button>
        </form>
    </div>


    @foreach ($daftarUnit as $unit)

        @php
            $jumlahPakaiUnit = $pakaiUnit[$unit->nama] ?? 0;
        @endphp

        <div class="struktur-card {{ $unit->aktif ? '' : 'nonaktif' }}">

            {{-- BARIS BIDANG / UNIT --}}
            <div class="struktur-baris unit-judul">

                <form method="POST" action="{{ route('admin.struktur.unit.update', $unit) }}" class="grow" style="flex-wrap:nowrap">
                    @csrf
                    @method('PUT')

                    <div class="grow">
                        <input type="text" name="nama" value="{{ $unit->nama }}" maxlength="255" required aria-label="Nama Bidang / Unit">
                    </div>

                    <input type="number" name="urutan" class="urutan" value="{{ $unit->urutan }}" min="0" max="9999" title="Urutan tampil" aria-label="Urutan">

                    <label class="aktif-cek">
                        <input type="hidden" name="aktif" value="0">
                        <input type="checkbox" name="aktif" value="1" @checked($unit->aktif)>
                        Aktif
                    </label>

                    <button type="submit" class="btn-struktur">Simpan</button>
                </form>

                @if ($jumlahPakaiUnit > 0)
                    <span class="lencana-pakai">Dipakai {{ $jumlahPakaiUnit }} pengajuan</span>
                @endif

                <form
                    method="POST"
                    action="{{ route('admin.struktur.unit.destroy', $unit) }}"
                    onsubmit="return confirm('Hapus Bidang / Unit ini beserta semua seksinya?')"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn-struktur hapus"
                        @disabled($jumlahPakaiUnit > 0)
                        @if ($jumlahPakaiUnit > 0) title="Sudah dipakai pengajuan, nonaktifkan saja" @endif
                    >
                        <x-icon name="trash" size="15" /> Hapus
                    </button>
                </form>

            </div>


            {{-- DAFTAR SUBBAGIAN / SEKSI --}}
            <div class="seksi-daftar">

                <div class="label-kecil">Subbagian / Seksi</div>

                @forelse ($unit->bagianSeksis as $seksi)

                    @php
                        $jumlahPakaiSeksi = $pakaiSeksi[$unit->nama . '|' . $seksi->nama] ?? 0;
                    @endphp

                    <div class="struktur-baris">

                        <form method="POST" action="{{ route('admin.struktur.seksi.update', $seksi) }}" class="grow" style="flex-wrap:nowrap">
                            @csrf
                            @method('PUT')

                            <div class="grow">
                                <input type="text" name="nama" value="{{ $seksi->nama }}" maxlength="255" required aria-label="Nama Subbagian / Seksi">
                            </div>

                            <div class="grow" style="flex-basis:220px">
                                <select name="unit_organisasi_id" aria-label="Bidang / Unit induk">
                                    @foreach ($daftarUnit as $pilihan)
                                        <option value="{{ $pilihan->id }}" @selected($pilihan->id === $seksi->unit_organisasi_id)>
                                            {{ $pilihan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="number" name="urutan" class="urutan" value="{{ $seksi->urutan }}" min="0" max="9999" title="Urutan tampil" aria-label="Urutan">

                            <label class="aktif-cek">
                                <input type="hidden" name="aktif" value="0">
                                <input type="checkbox" name="aktif" value="1" @checked($seksi->aktif)>
                                Aktif
                            </label>

                            <button type="submit" class="btn-struktur">Simpan</button>
                        </form>

                        @if ($jumlahPakaiSeksi > 0)
                            <span class="lencana-pakai">Dipakai {{ $jumlahPakaiSeksi }} pengajuan</span>
                        @endif

                        <form
                            method="POST"
                            action="{{ route('admin.struktur.seksi.destroy', $seksi) }}"
                            onsubmit="return confirm('Hapus Subbagian / Seksi ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn-struktur hapus"
                                @disabled($jumlahPakaiSeksi > 0)
                                @if ($jumlahPakaiSeksi > 0) title="Sudah dipakai pengajuan, nonaktifkan saja" @endif
                            >
                                <x-icon name="trash" size="15" /> Hapus
                            </button>
                        </form>

                    </div>

                @empty
                    <p style="margin:0;color:var(--muted)">Belum ada Subbagian / Seksi.</p>
                @endforelse


                {{-- TAMBAH SEKSI --}}
                <form method="POST" action="{{ route('admin.struktur.seksi.store', $unit) }}" class="struktur-baris tambah-baris">
                    @csrf
                    <div class="grow">
                        <input type="text" name="nama" placeholder="Tambah Subbagian / Seksi baru" maxlength="255" required>
                    </div>
                    <button type="submit" class="btn-struktur">
                        <x-icon name="plus" size="15" /> Tambah
                    </button>
                </form>

            </div>

        </div>

    @endforeach

</div>

@endsection