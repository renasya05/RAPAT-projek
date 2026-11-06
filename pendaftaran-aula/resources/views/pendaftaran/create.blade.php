@extends('layouts.app')

@section('title', 'Pendaftaran Aula | RAPAT')

@section('content')

    <div class="card form-page">

        {{-- ======================================================
            TOMBOL KEMBALI
        ======================================================= --}}

        <div class="top-action">

            <a
                href="{{ route('aulas') }}"
                class="back-link"
            >
                <x-icon name="arrow-left" size="16" />
                Kembali ke Daftar Aula
            </a>

        </div>


            {{-- ======================================================
                INFO AULA
            ======================================================= --}}

            <div class="aula-info">

                <span class="label">
                    Aula yang Dipilih
                </span>

                <h2>
                    {{ $aula->nama_aula }}
                </h2>

            </div>


            {{-- ======================================================
                ERROR
            ======================================================= --}}

            @if ($errors->any())

                @include('partials.errors')

            @endif


            <form
                action="{{ route('pendaftaran.store') }}"
                method="POST"
                id="formPendaftaran"
            >

                @csrf


                <input
                    type="hidden"
                    name="aula_id"
                    value="{{ $aula->id }}"
                >


                {{-- ======================================================
                    1. DATA PEMOHON
                ======================================================= --}}

                <section class="section">

                    <h2 class="section-title">
                        1. Data Pemohon
                    </h2>

                    @if (!empty($prefill['dari_riwayat']) && !old('nama_pemohon'))
                        <div class="help-text" style="margin-bottom: 14px;">
                            Data di bawah terisi otomatis dari pengajuan Anda sebelumnya.
                            Silakan ubah jika ada yang berbeda.
                        </div>
                    @endif


                    <div class="form-grid">

                        {{-- NAMA LENGKAP --}}

                        <div class="form-group">

                            <label>

                                Nama Lengkap Pemohon

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"
                                name="nama_pemohon"
                                value="{{ old('nama_pemohon', $prefill['nama_pemohon'] ?? ($user->name ?? '')) }}"
                                placeholder="Masukkan nama lengkap pemohon"
                                required
                            >

                        </div>


                        {{-- JABATAN --}}

                        <div class="form-group">

                            <label>

                                Jabatan

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"
                                name="jabatan"
                                value="{{ old('jabatan', $prefill['jabatan'] ?? '') }}"
                                placeholder="Masukkan jabatan"
                                required
                            >

                        </div>


                        {{-- BIDANG / UNIT --}}

                        <div
                            class="form-group"
                            id="unitGroup"
                        >

                            <label>

                                Bidang / Unit

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <select
                                name="unit_organisasi"
                                id="unit_organisasi"
                            >

                                <option value="">
                                    -- Pilih Bidang / Unit --
                                </option>


                                @foreach ($struktur as $unit => $bagianList)

                                    <option
                                        value="{{ $unit }}"
                                        @selected(old('unit_organisasi', $prefill['unit_organisasi'] ?? '') == $unit)
                                    >

                                        {{ $unit }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- SUBBAGIAN / SEKSI --}}

                        <div class="form-group">

                            <label>

                                Subbagian / Seksi

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <select
                                name="bagian_seksi"
                                id="bagian_seksi"
                            >

                                <option value="">
                                    -- Pilih Subbagian / Seksi --
                                </option>


                                @foreach ($struktur as $unit => $bagianList)

                                    <optgroup label="{{ $unit }}">

                                        @foreach ($bagianList as $bagian)

                                            <option
                                                value="{{ $bagian }}"
                                                @selected(old('bagian_seksi', $prefill['bagian_seksi'] ?? '') == $bagian)
                                            >
                                                {{ $bagian }}
                                            </option>

                                        @endforeach

                                    </optgroup>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </section>


                {{-- ======================================================
                    2. KEPERLUAN PEMAKAIAN
                ======================================================= --}}

                <section class="section">

                    <h2 class="section-title">
                        2. Keperluan Pemakaian
                    </h2>


                    <div class="form-group">

                        <textarea
                            name="keperluan"
                            placeholder="Masukkan keperluan pemakaian aula"
                            required
                        >{{ old('keperluan') }}</textarea>

                    </div>

                </section>


                {{-- ======================================================
                    3. DATA PESERTA
                ======================================================= --}}

                <section class="section">

                    <h2 class="section-title">
                        3. Data Peserta
                    </h2>


                    {{-- PESERTA RAPAT --}}

                    <div class="form-group">

                        <label>

                            Peserta Rapat

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="radio-group">


                            {{-- INTERNAL --}}

                            <div class="radio-card">

                                <input
                                    type="radio"
                                    name="peserta_asal"
                                    id="internal"
                                    value="internal"
                                    @checked(old('peserta_asal') === 'internal')
                                    required
                                >


                                <label
                                    for="internal"
                                    class="radio-label"
                                >

                                    Internal

                                </label>

                            </div>


                            {{-- INTERNAL & EKSTERNAL --}}

                            <div class="radio-card">

                                <input
                                    type="radio"
                                    name="peserta_asal"
                                    id="internal_eksternal"
                                    value="internal_eksternal"
                                    @checked(old('peserta_asal') === 'internal_eksternal')
                                >


                                <label
                                    for="internal_eksternal"
                                    class="radio-label"
                                >

                                    Internal & Eksternal

                                </label>

                            </div>


                        </div>

                    </div>


                    <div
                        class="form-grid peserta-grid"
                    >


                        {{-- INSTANSI --}}

                        <div
                            class="form-group hidden"
                            id="instansiGroup"
                        >

                            <label>

                                Nama Instansi / Organisasi

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"
                                name="instansi"
                                id="instansi"
                                value="{{ old('instansi') }}"
                                placeholder="Masukkan nama instansi / organisasi"
                            >

                        </div>


                        {{-- JUMLAH PESERTA --}}

                        <div class="form-group">

                            <label>

                                Jumlah Peserta

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="number"
                                name="jumlah_peserta"
                                id="jumlah_peserta"
                                value="{{ old('jumlah_peserta') }}"
                                min="1"
                                max="{{ (int) $aula->kapasitas }}"
                                data-max="{{ (int) $aula->kapasitas }}"
                                placeholder="Masukkan jumlah peserta"
                                aria-describedby="jumlahPesertaPeringatan"
                                required
                            >

                            {{--
                                Peringatan hanya muncul saat angka melebihi kapasitas aula.
                                Sengaja TIDAK memakai class "error-text": rapat.js menandai
                                semua .error-text sebagai error server saat halaman dibuka.
                            --}}
                            <style>
                                .peringatan-peserta {
                                    display: none;
                                    align-items: flex-start;
                                    gap: 5px;
                                    margin-top: 7px;
                                    font-size: .82rem;
                                    font-weight: 600;
                                    line-height: 1.45;
                                    color: var(--danger-fg, #b91c1c);
                                }

                                .peringatan-peserta.tampil {
                                    display: flex;
                                }

                                .peringatan-peserta::before {
                                    content: "!";
                                    display: grid;
                                    place-items: center;
                                    flex: none;
                                    width: 16px;
                                    height: 16px;
                                    margin-top: 1px;
                                    font-size: .68rem;
                                    font-weight: 700;
                                    border-radius: 999px;
                                    background: var(--danger-bg, #fee2e2);
                                    color: var(--danger, #dc2626);
                                }
                            </style>

                            <div
                                class="peringatan-peserta"
                                id="jumlahPesertaPeringatan"
                                role="alert"
                                aria-live="polite"
                            ></div>

                            <script>
                                (function () {

                                    var input = document.getElementById('jumlah_peserta');
                                    var peringatan = document.getElementById('jumlahPesertaPeringatan');

                                    var batas = parseInt(input.getAttribute('data-max'), 10);
                                    var namaAula = @json($aula->nama_aula);

                                    function periksa() {

                                        var nilai = input.value === '' ? NaN : Number(input.value);

                                        if (!isNaN(nilai) && nilai > batas) {

                                            var pesan =
                                                'Jumlah peserta (' + nilai + ' orang) melebihi batas ' +
                                                batas + ' orang untuk ' + namaAula +
                                                '. Kurangi jumlah peserta atau pilih aula lain.';

                                            peringatan.textContent = pesan;
                                            peringatan.classList.add('tampil');

                                            input.classList.add('is-invalid');
                                            input.setAttribute('aria-invalid', 'true');
                                            input.setCustomValidity(pesan);

                                        } else {

                                            peringatan.textContent = '';
                                            peringatan.classList.remove('tampil');

                                            input.classList.remove('is-invalid');
                                            input.removeAttribute('aria-invalid');
                                            input.setCustomValidity('');

                                        }

                                    }

                                    input.addEventListener('input', periksa);
                                    input.addEventListener('change', periksa);

                                    // Untuk nilai lama setelah form gagal dikirim.
                                    periksa();

                                })();
                            </script>

                        </div>

                        </div>


                    </div>

                </section>


                {{-- ======================================================
                    4. WAKTU
                ======================================================= --}}

                <section class="section">

                    <h2 class="section-title">
                        4. Waktu
                    </h2>


                    <div class="form-grid">


                        {{-- TANGGAL MULAI --}}

                        <div class="form-group">

                            <label>

                                Tanggal Mulai

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="date"
                                name="tanggal_mulai"
                                id="tanggal_mulai"
                                value="{{ old('tanggal_mulai') }}"
                                min="{{ date('Y-m-d') }}"
                                required
                            >


                            <div
                                class="hari-display empty"
                                id="hari_mulai"
                            >

                                Hari akan muncul otomatis

                            </div>

                        </div>


                        {{-- TANGGAL SELESAI --}}

                        <div class="form-group">

                            <label>

                                Tanggal Selesai

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="date"
                                name="tanggal_selesai"
                                id="tanggal_selesai"
                                value="{{ old('tanggal_selesai') }}"
                                min="{{ date('Y-m-d') }}"
                                required
                            >


                            <div
                                class="hari-display empty"
                                id="hari_selesai"
                            >

                                Hari akan muncul otomatis

                            </div>

                        </div>


                    </div>


                    {{-- JAM PEMAKAIAN --}}

                    <div class="waktu-container">

                        <label>

                            Jam Pemakaian

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="waktu-grid">


                            {{-- PAGI - SIANG --}}

                            <div
                                class="waktu-card"
                                data-waktu="pagi_siang"
                                data-slot="pagi"
                            >

                                <input
                                    type="radio"
                                    name="kriteria_waktu"
                                    id="pagi_siang"
                                    value="pagi_siang"
                                    @checked(old('kriteria_waktu') === 'pagi_siang')
                                    required
                                >


                                <label
                                    for="pagi_siang"
                                    class="waktu-label"
                                >

                                    <span class="waktu-icon">
                                        <x-icon name="sunrise" />
                                    </span>


                                    <span class="waktu-content">

                                        <strong>
                                            Pagi
                                        </strong>

                                        <span>
                                            08.00 – 13.00
                                        </span>

                                    </span>

                                </label>

                            </div>


                            {{-- SIANG - SORE --}}

                            <div
                                class="waktu-card"
                                data-waktu="siang_sore"
                                data-slot="siang"
                            >

                                <input
                                    type="radio"
                                    name="kriteria_waktu"
                                    id="siang_sore"
                                    value="siang_sore"
                                    @checked(old('kriteria_waktu') === 'siang_sore')
                                >


                                <label
                                    for="siang_sore"
                                    class="waktu-label"
                                >

                                    <span class="waktu-icon">
                                        <x-icon name="sun" />
                                    </span>


                                    <span class="waktu-content">

                                        <strong>
                                            Siang
                                        </strong>

                                        <span>
                                            14.00 – 16.00
                                        </span>

                                    </span>

                                </label>

                            </div>


                            {{-- MALAM --}}

                            <div
                                class="waktu-card"
                                data-waktu="malam"
                                data-slot="malam"
                            >

                                <input
                                    type="radio"
                                    name="kriteria_waktu"
                                    id="malam"
                                    value="malam"
                                    @checked(old('kriteria_waktu') === 'malam')
                                >


                                <label
                                    for="malam"
                                    class="waktu-label"
                                >

                                    <span class="waktu-icon">
                                        <x-icon name="moon" />
                                    </span>


                                    <span class="waktu-content">

                                        <strong>
                                            Malam
                                        </strong>

                                        <span>
                                            18.00 – 21.00
                                        </span>

                                    </span>

                                </label>

                            </div>


                            

                            {{-- GABUNGAN PAGI - SIANG --}}

                            <div
                                class="waktu-card"
                                data-waktu="gabungan_pagi_siang"
                                data-slot="pagi,siang,malam"
                            >

                                <input
                                    type="radio"
                                    name="kriteria_waktu"
                                    id="gabungan_pagi_siang"
                                    value="gabungan_pagi_siang"
                                    @checked(old('kriteria_waktu') === 'gabungan_pagi_siang')
                                >


                                <label
                                    for="gabungan_pagi_siang"
                                    class="waktu-label"
                                >

                                    <span class="waktu-icon">
                                        <x-icon name="sun" />
                                    </span>


                                    <span class="waktu-content">

                                        <strong>
                                            Full Day
                                        </strong>

                                        <span>
                                            08.00 – 21.00
                                        </span>

                                    </span>

                                </label>

                            </div>


                            

                        </div>

                    </div>

                </section>


                {{-- ======================================================
                    TOMBOL AJUKAN
                ======================================================= --}}

                <div class="button-area">

                    <button
                        type="submit"
                        class="btn-submit"
                    >

                        Ajukan Pendaftaran

                    </button>

                </div>

            </form>

        </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /* ==========================================================
               DATA STRUKTUR ORGANISASI
            ========================================================== */

            const strukturOrganisasi = @json($struktur);


            /* ==========================================================
               ELEMEN FORM
            ========================================================== */

            const form =
                document.getElementById('formPendaftaran');

            const unitSelect =
                document.getElementById('unit_organisasi');

            const bagianSelect =
                document.getElementById('bagian_seksi');

            const unitGroup =
                document.getElementById('unitGroup');

            const instansiGroup =
                document.getElementById('instansiGroup');

            const instansiInput =
                document.getElementById('instansi');

            const tanggalMulai =
                document.getElementById('tanggal_mulai');

            const tanggalSelesai =
                document.getElementById('tanggal_selesai');


            /* ==========================================================
               HARI INDONESIA
            ========================================================== */

            function getNamaHari(tanggal) {

                if (!tanggal) {
                    return '';
                }


                const hari = [
                    'Minggu',
                    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu'
                ];


                const date =
                    new Date(tanggal + 'T00:00:00');


                return hari[date.getDay()];

            }


            function updateHariMulai() {

                const hariElement =
                    document.getElementById('hari_mulai');


                if (!tanggalMulai.value) {

                    hariElement.textContent =
                        'Hari akan muncul otomatis';

                    hariElement.classList.add('empty');

                    return;

                }


                hariElement.textContent =
                    getNamaHari(tanggalMulai.value);

                hariElement.classList.remove('empty');

            }


            function updateHariSelesai() {

                const hariElement =
                    document.getElementById('hari_selesai');


                if (!tanggalSelesai.value) {

                    hariElement.textContent =
                        'Hari akan muncul otomatis';

                    hariElement.classList.add('empty');

                    return;

                }


                hariElement.textContent =
                    getNamaHari(tanggalSelesai.value);

                hariElement.classList.remove('empty');

            }


            /* ==========================================================
               SINKRON UNIT DARI SUBBAGIAN / SEKSI
            ========================================================== */

            function labelUnitBagian() {

                const option =
                    bagianSelect.selectedOptions[0];

                const group =
                    option
                        ? option.closest('optgroup')
                        : null;

                return group
                    ? group.label
                    : '';

            }


            /* ==========================================================
               PESERTA RAPAT
            ========================================================== */

            function ubahPeserta() {

                const peserta =
                    document.querySelector(
                        'input[name="peserta_asal"]:checked'
                    );


                if (!peserta) {

                    return;

                }


                if (peserta.value === 'internal') {

                    unitGroup.classList.remove('hidden');

                    unitSelect.required = true;

                    bagianSelect.required = true;

                    instansiGroup.classList.add('hidden');

                    instansiInput.required = false;

                    instansiInput.value = '';

                }


                else if (
                    peserta.value === 'internal_eksternal'
                ) {

                    unitGroup.classList.remove('hidden');

                    unitSelect.required = true;

                    bagianSelect.required = true;

                    instansiGroup.classList.remove('hidden');

                    instansiInput.required = true;

                }

            }


            /* ==========================================================
               FILTER SUBBAGIAN / SEKSI SESUAI BIDANG / UNIT
            ========================================================== */

            function tampilkanBagian(unit) {

                const terpilih =
                    bagianSelect.value;


                bagianSelect.innerHTML = '';


                const placeholder =
                    document.createElement('option');

                placeholder.value = '';

                placeholder.textContent =
                    '-- Pilih Subbagian / Seksi --';

                bagianSelect.appendChild(placeholder);


                Object.keys(strukturOrganisasi).forEach(
                    function (namaUnit) {

                        if (unit && namaUnit !== unit) {

                            return;

                        }


                        const group =
                            document.createElement('optgroup');

                        group.label = namaUnit;


                        strukturOrganisasi[namaUnit].forEach(
                            function (bagian) {

                                const option =
                                    document.createElement('option');

                                option.value = bagian;

                                option.textContent = bagian;

                                group.appendChild(option);

                            }
                        );


                        bagianSelect.appendChild(group);

                    }
                );


                const masihAda =
                    Array.from(bagianSelect.options).some(
                        function (option) {

                            return option.value === terpilih;

                        }
                    );


                bagianSelect.value =
                    masihAda ? terpilih : '';

            }


            /* ==========================================================
               EVENT BIDANG / UNIT DAN SUBBAGIAN / SEKSI
            ========================================================== */

            bagianSelect.addEventListener(
                'change',
                function () {

                    unitSelect.value =
                        labelUnitBagian();

                }
            );


            unitSelect.addEventListener(
                'change',
                function () {

                    tampilkanBagian(unitSelect.value);

                }
            );


            /* ==========================================================
               EVENT PESERTA RAPAT
            ========================================================== */

            document
                .querySelectorAll(
                    'input[name="peserta_asal"]'
                )
                .forEach(
                    function (radio) {

                        radio.addEventListener(
                            'change',
                            ubahPeserta
                        );

                    }
                );


            /* ==========================================================
               CEK KETERSEDIAAN WAKTU
            ========================================================== */

            // Setiap pengecekan diberi nomor. Kalau tanggal diganti cepat-cepat,
            // respons lama yang datang terlambat diabaikan supaya tidak
            // menimpa status slot untuk tanggal yang sekarang dipilih.
            let nomorCek = 0;

            async function cekKetersediaan() {

                const nomor = ++nomorCek;

                const mulai =
                    tanggalMulai.value;

                const selesai =
                    tanggalSelesai.value;


                if (!mulai || !selesai) {

                    aktifkanSemuaWaktu();

                    return;

                }


                if (selesai < mulai) {

                    aktifkanSemuaWaktu();

                    return;

                }


                try {

                    const url =
                        "{{ route('pendaftaran.availability') }}"
                        + "?aula_id={{ $aula->id }}"
                        + "&tanggal_mulai="
                        + encodeURIComponent(mulai)
                        + "&tanggal_selesai="
                        + encodeURIComponent(selesai);


                    const response =
                        await fetch(
                            url,
                            {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            }
                        );


                    if (!response.ok) {

                        throw new Error(
                            'Gagal mengecek ketersediaan.'
                        );

                    }


                    const data =
                        await response.json();


                    if (nomor !== nomorCek) {

                        return;

                    }


                    const slotTerpakai =
                        data.slotTerpakai || [];


                    document
                        .querySelectorAll('.waktu-card')
                        .forEach(
                            function (card) {

                                const slots =
                                    (card.dataset.slot || '')
                                        .split(',')
                                        .filter(
                                            function (s) {
                                                return s !== '';
                                            }
                                        );


                                const input =
                                    card.querySelector('input');


                                const bentrok =
                                    slots.some(
                                        function (s) {
                                            return slotTerpakai.includes(s);
                                        }
                                    );


                                if (bentrok) {

                                    card.classList.add(
                                        'disabled'
                                    );

                                    input.disabled = true;

                                    input.checked = false;

                                }

                                else {

                                    card.classList.remove(
                                        'disabled'
                                    );

                                    input.disabled = false;

                                }

                            }
                        );


                }

                catch (error) {

                    console.error(error);

                    if (nomor === nomorCek) {

                        aktifkanSemuaWaktu();

                    }

                }

            }


            function aktifkanSemuaWaktu() {

                document
                    .querySelectorAll('.waktu-card')
                    .forEach(
                        function (card) {

                            card.classList.remove(
                                'disabled'
                            );


                            const input =
                                card.querySelector('input');


                            input.disabled = false;

                        }
                    );

            }


            /* ==========================================================
               EVENT TANGGAL MULAI
            ========================================================== */

            tanggalMulai.addEventListener(
                'change',
                function () {

                    tanggalSelesai.min =
                        tanggalMulai.value;


                    if (
                        tanggalSelesai.value &&
                        tanggalSelesai.value <
                        tanggalMulai.value
                    ) {

                        tanggalSelesai.value = '';

                    }


                    updateHariMulai();

                    updateHariSelesai();

                    cekKetersediaan();

                }
            );


            /* ==========================================================
               EVENT TANGGAL SELESAI
            ========================================================== */

            tanggalSelesai.addEventListener(
                'change',
                function () {

                    updateHariSelesai();

                    cekKetersediaan();

                }
            );


            /* ==========================================================
               OLD VALUE
            ========================================================== */

            const oldUnit =
                @json(old('unit_organisasi', $prefill['unit_organisasi'] ?? ''));


            const oldBagian =
                @json(old('bagian_seksi', $prefill['bagian_seksi'] ?? ''));


            if (oldBagian) {

                bagianSelect.value =
                    oldBagian;


                unitSelect.value =
                    labelUnitBagian();

            }


            if (oldUnit) {

                unitSelect.value =
                    oldUnit;

            }


            /* ==========================================================
               INISIALISASI
            ========================================================== */

            tampilkanBagian(unitSelect.value);

            updateHariMulai();

            updateHariSelesai();

            ubahPeserta();


            if (tanggalMulai.value) {

                tanggalSelesai.min =
                    tanggalMulai.value;

            }


            if (
                tanggalMulai.value &&
                tanggalSelesai.value
            ) {

                cekKetersediaan();

            }


            /* ==========================================================
               VALIDASI SUBMIT
            ========================================================== */

            form.addEventListener(
                'submit',
                function (event) {

                    const waktuTerpilih =
                        document.querySelector(
                            'input[name="kriteria_waktu"]:checked'
                        );


                    if (!waktuTerpilih) {

                        event.preventDefault();

                        alert(
                            'Silakan pilih jam pemakaian yang tersedia.'
                        );

                        return;

                    }


                    const card =
                        waktuTerpilih.closest(
                            '.waktu-card'
                        );


                    if (
                        waktuTerpilih.disabled ||
                        card.classList.contains('disabled')
                    ) {

                        event.preventDefault();

                        alert(
                            'Waktu yang dipilih sudah digunakan. Silakan pilih waktu lain.'
                        );

                    }

                }
            );

        });

    </script>

@endsection