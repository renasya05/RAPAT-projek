<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pendaftaran Aula | SAPA</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-sapa.svg') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        /* NAVBAR */
        .navbar {
            background: #12355b;
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 22px;
            font-weight: bold;
        }

        .brand span {
            display: block;
            font-size: 12px;
            font-weight: normal;
            margin-top: 3px;
            opacity: 0.9;
        }

        .back-link {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* CONTAINER */
        .container {
            max-width: 1000px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h1 {
            color: #12355b;
            font-size: 28px;
            margin-bottom: 6px;
        }

        .page-title p {
            color: #6b7280;
        }

        /* AULA INFO */
        .aula-card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 25px;
            border-left: 5px solid #12355b;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        .aula-card h2 {
            color: #12355b;
            margin-bottom: 12px;
        }

        .aula-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .aula-info-item {
            background: #f4f6f9;
            padding: 12px;
            border-radius: 8px;
        }

        .aula-info-item strong {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        /* FORM */
        .form-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        .section-title {
            color: #12355b;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .form-section {
            margin-bottom: 35px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            margin-bottom: 4px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 7px;
            color: #374151;
        }

        .required {
            color: #dc2626;
        }

        .form-control {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
            outline: none;
            background: white;
        }

        .form-control:focus {
            border-color: #12355b;
            box-shadow: 0 0 0 2px rgba(18, 53, 91, 0.08);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 110px;
        }

        /* RADIO */
        .radio-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .radio-option {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            background: white;
            transition: 0.2s;
        }

        .radio-option:hover {
            border-color: #12355b;
            background: #f8fafc;
        }

        .radio-option input {
            accent-color: #12355b;
        }

        /* DYNAMIC BOX */
        .dynamic-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            margin-top: 18px;
        }

        .dynamic-box h3 {
            color: #12355b;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .hidden {
            display: none !important;
        }

        /* DATE */
        .date-wrapper {
            display: grid;
            grid-template-columns: 1fr 150px;
            gap: 10px;
        }

        .day-display {
            background: #eef2f7;
            color: #374151;
        }

        /* ERROR */
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error ul {
            margin-left: 20px;
        }

        /* BUTTON */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            border: none;
            border-radius: 7px;
            padding: 12px 22px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-primary {
            background: #12355b;
            color: white;
        }

        .btn-primary:hover {
            background: #0d2947;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            padding: 25px;
            color: #6b7280;
            font-size: 13px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .navbar {
                padding: 16px 20px;
            }

            .container {
                margin-top: 25px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .aula-info {
                grid-template-columns: 1fr;
            }

            .date-wrapper {
                grid-template-columns: 1fr;
            }

            .form-card {
                padding: 20px;
            }

            .radio-group {
                flex-direction: column;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="brand">
            <img
                src="{{ asset('images/logo-sapa.svg') }}"
                alt=""
                width="40"
                height="40"
            >
            <div>
                RAPAT
                <span>REGISTRASI ADMINITRASI PENGGUNAAN AULA TERKONTROL</span>
            </div>
        </div>

        <a href="{{ route('aulas') }}" class="back-link">
            ← Kembali ke Daftar Aula
        </a>
    </nav>


    <div class="container">

        <!-- JUDUL -->
        <div class="page-title">
            <h1>Pendaftaran Penggunaan Aula</h1>
            <p>Silakan lengkapi data pengajuan penggunaan aula.</p>
        </div>


        <!-- INFORMASI AULA -->
        <div class="aula-card">

            <h2>{{ $aula->nama_aula }}</h2>

            <div class="aula-info">

                <div class="aula-info-item">
                    <strong>Kapasitas</strong>
                    {{ $aula->kapasitas }} orang
                </div>

                <div class="aula-info-item">
                    <strong>Keterangan</strong>
                    {{ $aula->keterangan }}
                </div>

                <div class="aula-info-item">
                    <strong>Fasilitas</strong>
                    {{ $aula->fasilitas ?? '-' }}
                </div>

            </div>

        </div>


        <!-- ERROR -->
        @if ($errors->any())
            <div class="alert-error">
                <strong>Terdapat kesalahan:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- FORM -->
        <div class="form-card">

            <form
                action="{{ route('pendaftaran.store') }}"
                method="POST"
                id="formPendaftaran"
            >

                @csrf

                <!-- PENTING: ID AULA -->
                <input
                    type="hidden"
                    name="aula_id"
                    value="{{ $aula->id }}"
                >


                <!-- ========================= -->
                <!-- DATA PEMOHON -->
                <!-- ========================= -->

                <div class="form-section">

                    <div class="section-title">
                        1. Data Pemohon
                    </div>

                    <div class="form-grid">

                        <div class="form-group">
                            <label>
                                Nama Pemohon <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="nama_pemohon"
                                class="form-control"
                                value="{{ old('nama_pemohon', $user->name ?? '') }}"
                                required
                            >
                        </div>


                        <div class="form-group">
                            <label>
                                Email <span class="required">*</span>
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', $user->email ?? '') }}"
                                required
                            >
                        </div>


                        <div class="form-group">
                            <label>
                                NIP <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="nip"
                                class="form-control"
                                value="{{ old('nip') }}"
                                placeholder="Masukkan NIP"
                                required
                            >
                        </div>


                        <div class="form-group">
                            <label>
                                Jabatan <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="jabatan"
                                class="form-control"
                                value="{{ old('jabatan') }}"
                                placeholder="Masukkan jabatan"
                                required
                            >
                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- INSTANSI -->
                <!-- ========================= -->

                <div class="form-section">

                    <div class="section-title">
                        2. Instansi / Organisasi
                    </div>


                    <div class="form-group">

                        <label>
                            Jenis Pemohon <span class="required">*</span>
                        </label>

                        <div class="radio-group">

                            <!-- INTERNAL -->
                            <label class="radio-option">

                                <input
                                    type="radio"
                                    name="jenis_pemohon"
                                    value="internal"
                                    {{ old('jenis_pemohon', 'internal') === 'internal' ? 'checked' : '' }}
                                >

                                Internal

                            </label>


                            <!-- EKSTERNAL -->
                            <label class="radio-option">

                                <input
                                    type="radio"
                                    name="jenis_pemohon"
                                    value="eksternal"
                                    {{ old('jenis_pemohon') === 'eksternal' ? 'checked' : '' }}
                                >

                                Eksternal

                            </label>


                            <!-- INTERNAL + EKSTERNAL -->
                            <label class="radio-option">

                                <input
                                    type="radio"
                                    name="jenis_pemohon"
                                    value="internal_eksternal"
                                    {{ old('jenis_pemohon') === 'internal_eksternal' ? 'checked' : '' }}
                                >

                                Internal & Eksternal

                            </label>

                        </div>

                    </div>


                    <!-- INTERNAL -->
                    <div
                        id="formInternal"
                        class="dynamic-box"
                    >

                        <h3>
                            Data Internal DISKOMINFO
                        </h3>

                        <div class="form-grid">

                            <div class="form-group">

                                <label>
                                    Unit Organisasi <span class="required">*</span>
                                </label>

                                <select
                                    name="unit_organisasi"
                                    id="unit_organisasi"
                                    class="form-control"
                                >

                                    <option value="">
                                        -- Pilih Unit Organisasi --
                                    </option>

                                    @foreach ($strukturOrganisasi as $unit => $bagianList)

                                        <option
                                            value="{{ $unit }}"
                                            {{ old('unit_organisasi') === $unit ? 'selected' : '' }}
                                        >
                                            {{ $unit }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="form-group">

                                <label>
                                    Bagian / Seksi <span class="required">*</span>
                                </label>

                                <select
                                    name="bagian_seksi"
                                    id="bagian_seksi"
                                    class="form-control"
                                >

                                    <option value="">
                                        -- Pilih Bagian / Seksi --
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <!-- EKSTERNAL -->
                    <div
                        id="formEksternal"
                        class="dynamic-box hidden"
                    >

                        <h3>
                            Data Instansi / Organisasi Pihak Luar
                        </h3>

                        <div class="form-group">

                            <label>
                                Nama Instansi / Organisasi
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="instansi"
                                id="instansi"
                                class="form-control"
                                value="{{ old('instansi') }}"
                                placeholder="Contoh: Universitas Lambung Mangkurat"
                            >

                        </div>

                    </div>


                    <!-- INFO INTERNAL + EKSTERNAL -->
                    <div
                        id="infoGabungan"
                        class="dynamic-box hidden"
                    >

                        <h3>
                            Pemohon Internal & Eksternal
                        </h3>

                        <p style="font-size:14px;color:#6b7280;line-height:1.6;">
                            Untuk pilihan ini, silakan lengkapi
                            <strong>Unit Organisasi dan Bagian/Seksi</strong>
                            dari pihak internal serta
                            <strong>Nama Instansi/Organisasi pihak luar</strong>.
                        </p>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- WAKTU -->
                <!-- ========================= -->

                <div class="form-section">

                    <div class="section-title">
                        3. Waktu Penggunaan
                    </div>

                    <div class="form-grid">

                        <div class="form-group">

                            <label>
                                Tanggal Mulai <span class="required">*</span>
                            </label>

                            <div class="date-wrapper">

                                <input
                                    type="date"
                                    name="tanggal_mulai"
                                    id="tanggal_mulai"
                                    class="form-control"
                                    value="{{ old('tanggal_mulai') }}"
                                    required
                                >

                                <input
                                    type="text"
                                    id="hari_mulai"
                                    class="form-control day-display"
                                    placeholder="Hari"
                                    readonly
                                >

                            </div>

                        </div>


                        <div class="form-group">

                            <label>
                                Tanggal Selesai <span class="required">*</span>
                            </label>

                            <div class="date-wrapper">

                                <input
                                    type="date"
                                    name="tanggal_selesai"
                                    id="tanggal_selesai"
                                    class="form-control"
                                    value="{{ old('tanggal_selesai') }}"
                                    required
                                >

                                <input
                                    type="text"
                                    id="hari_selesai"
                                    class="form-control day-display"
                                    placeholder="Hari"
                                    readonly
                                >

                            </div>

                        </div>


                        <div class="form-group">

                            <label>
                                Jam Mulai <span class="required">*</span>
                            </label>

                            <input
                                type="time"
                                name="jam_mulai"
                                id="jam_mulai"
                                class="form-control"
                                value="{{ old('jam_mulai') }}"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Jam Selesai <span class="required">*</span>
                            </label>

                            <input
                                type="time"
                                name="jam_selesai"
                                id="jam_selesai"
                                class="form-control"
                                value="{{ old('jam_selesai') }}"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- DETAIL KEGIATAN -->
                <!-- ========================= -->

                <div class="form-section">

                    <div class="section-title">
                        4. Detail Kegiatan
                    </div>

                    <div class="form-grid">

                        <div class="form-group">

                            <label>
                                Jumlah Peserta
                                <span class="required">*</span>
                            </label>

                            <input
                                type="number"
                                name="jumlah_peserta"
                                id="jumlah_peserta"
                                class="form-control"
                                value="{{ old('jumlah_peserta') }}"
                                min="1"
                                max="{{ $aula->kapasitas }}"
                                required
                            >

                            <small style="display:block;margin-top:6px;color:#6b7280;">
                                Kapasitas maksimal:
                                {{ $aula->kapasitas }} orang
                            </small>

                        </div>


                        <div class="form-group">

                            <label>
                                Peserta Pihak Luar
                                <span class="required">*</span>
                            </label>

                            <select
                                name="peserta_pihak_luar"
                                class="form-control"
                                required
                            >

                                <option
                                    value="tidak"
                                    {{ old('peserta_pihak_luar', 'tidak') === 'tidak' ? 'selected' : '' }}
                                >
                                    Tidak Ada
                                </option>

                                <option
                                    value="ada"
                                    {{ old('peserta_pihak_luar') === 'ada' ? 'selected' : '' }}
                                >
                                    Ada
                                </option>

                            </select>

                        </div>


                        <div class="form-group full">

                            <label>
                                Keperluan
                                <span class="required">*</span>
                            </label>

                            <textarea
                                name="keperluan"
                                class="form-control"
                                placeholder="Jelaskan keperluan penggunaan aula..."
                                required
                            >{{ old('keperluan') }}</textarea>

                        </div>

                    </div>

                </div>


                <!-- BUTTON -->
                <div class="form-actions">

                    <a
                        href="{{ route('aulas') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Kirim Pengajuan
                    </button>

                </div>

            </form>

        </div>

    </div>


    <div class="footer">
        © {{ date('Y') }} RAPAT — REGISTRASI ADMINITRASI PENGGUNAAN AULA TERKONTROL
    </div>


    <!-- ========================= -->
    <!-- JAVASCRIPT -->
    <!-- ========================= -->

    <script>

        const strukturOrganisasi = @json($strukturOrganisasi);

        const jenisPemohon = document.querySelectorAll(
            'input[name="jenis_pemohon"]'
        );

        const formInternal = document.getElementById(
            'formInternal'
        );

        const formEksternal = document.getElementById(
            'formEksternal'
        );

        const infoGabungan = document.getElementById(
            'infoGabungan'
        );

        const unitOrganisasi = document.getElementById(
            'unit_organisasi'
        );

        const bagianSeksi = document.getElementById(
            'bagian_seksi'
        );

        const instansi = document.getElementById(
            'instansi'
        );


        function updateBagianSeksi(selectedValue = '') {

            const unit = unitOrganisasi.value;

            bagianSeksi.innerHTML =
                '<option value="">-- Pilih Bagian / Seksi --</option>';

            if (
                unit &&
                strukturOrganisasi[unit]
            ) {

                strukturOrganisasi[unit].forEach(
                    function (bagian) {

                        const option =
                            document.createElement('option');

                        option.value = bagian;

                        option.textContent = bagian;

                        if (bagian === selectedValue) {
                            option.selected = true;
                        }

                        bagianSeksi.appendChild(option);

                    }
                );
            }
        }


        function updateJenisPemohon() {

            let selected = 'internal';

            jenisPemohon.forEach(
                function (radio) {

                    if (radio.checked) {
                        selected = radio.value;
                    }

                }
            );


            /* RESET */

            formInternal.classList.add('hidden');

            formEksternal.classList.add('hidden');

            infoGabungan.classList.add('hidden');

            unitOrganisasi.disabled = true;

            bagianSeksi.disabled = true;

            instansi.disabled = true;

            unitOrganisasi.removeAttribute('required');

            bagianSeksi.removeAttribute('required');

            instansi.removeAttribute('required');


            /* INTERNAL */

            if (selected === 'internal') {

                formInternal.classList.remove('hidden');

                unitOrganisasi.disabled = false;

                bagianSeksi.disabled = false;

                unitOrganisasi.required = true;

                bagianSeksi.required = true;

                instansi.value = '';

                updateBagianSeksi(
                    '{{ old('bagian_seksi') }}'
                );

            }


            /* EKSTERNAL */

            else if (selected === 'eksternal') {

                formEksternal.classList.remove('hidden');

                instansi.disabled = false;

                instansi.required = true;

                unitOrganisasi.value = '';

                bagianSeksi.innerHTML =
                    '<option value="">-- Pilih Bagian / Seksi --</option>';

            }


            /* INTERNAL + EKSTERNAL */

            else if (
                selected === 'internal_eksternal'
            ) {

                formInternal.classList.remove('hidden');

                formEksternal.classList.remove('hidden');

                infoGabungan.classList.remove('hidden');

                unitOrganisasi.disabled = false;

                bagianSeksi.disabled = false;

                instansi.disabled = false;

                unitOrganisasi.required = true;

                bagianSeksi.required = true;

                instansi.required = true;

                updateBagianSeksi(
                    '{{ old('bagian_seksi') }}'
                );

            }

        }


        /* RADIO EVENT */

        jenisPemohon.forEach(
            function (radio) {

                radio.addEventListener(
                    'change',
                    updateJenisPemohon
                );

            }
        );


        /* UNIT EVENT */

        unitOrganisasi.addEventListener(
            'change',
            function () {

                updateBagianSeksi();

            }
        );


        /* ========================= */
        /* HARI */
        /* ========================= */

        function updateHari(
            dateInputId,
            dayInputId
        ) {

            const dateInput =
                document.getElementById(dateInputId);

            const dayInput =
                document.getElementById(dayInputId);

            if (!dateInput.value) {

                dayInput.value = '';

                return;
            }

            const date =
                new Date(
                    dateInput.value + 'T00:00:00'
                );

            const hari = [
                'Minggu',
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu'
            ];

            dayInput.value =
                hari[date.getDay()];
        }


        document.getElementById(
            'tanggal_mulai'
        ).addEventListener(
            'change',
            function () {

                updateHari(
                    'tanggal_mulai',
                    'hari_mulai'
                );

                document.getElementById(
                    'tanggal_selesai'
                ).min = this.value;

            }
        );


        document.getElementById(
            'tanggal_selesai'
        ).addEventListener(
            'change',
            function () {

                updateHari(
                    'tanggal_selesai',
                    'hari_selesai'
                );

            }
        );


        /* ========================= */
        /* VALIDASI JAM */
        /* ========================= */

        document.getElementById(
            'formPendaftaran'
        ).addEventListener(
            'submit',
            function (event) {

                const jamMulai =
                    document.getElementById(
                        'jam_mulai'
                    ).value;

                const jamSelesai =
                    document.getElementById(
                        'jam_selesai'
                    ).value;

                const jumlahPeserta =
                    parseInt(
                        document.getElementById(
                            'jumlah_peserta'
                        ).value
                    );

                const kapasitas =
                    {{ $aula->kapasitas }};


                if (
                    jamMulai &&
                    jamSelesai &&
                    jamSelesai <= jamMulai
                ) {

                    event.preventDefault();

                    alert(
                        'Jam selesai harus lebih besar dari jam mulai.'
                    );

                    return;
                }


                if (
                    jumlahPeserta &&
                    jumlahPeserta > kapasitas
                ) {

                    event.preventDefault();

                    alert(
                        'Jumlah peserta melebihi kapasitas aula yaitu ' +
                        kapasitas +
                        ' orang.'
                    );

                }

            }
        );


        /* ========================= */
        /* INITIAL LOAD */
        /* ========================= */

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                updateBagianSeksi(
                    '{{ old('bagian_seksi') }}'
                );

                updateHari(
                    'tanggal_mulai',
                    'hari_mulai'
                );

                updateHari(
                    'tanggal_selesai',
                    'hari_selesai'
                );

                const tanggalMulai =
                    document.getElementById(
                        'tanggal_mulai'
                    ).value;

                if (tanggalMulai) {

                    document.getElementById(
                        'tanggal_selesai'
                    ).min = tanggalMulai;

                }

                updateJenisPemohon();

            }
        );

    </script>

</body>
</html>