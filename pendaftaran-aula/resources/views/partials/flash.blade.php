{{-- =====================================================================
     Pesan kilat (flash) dari session: success, error, info, warning.
     Pemakaian: @include('partials.flash')
====================================================================== --}}

@php
    $flashPesan = [
        'success' => ['success', 'check-circle', 'status'],
        'error'   => ['danger',  'x-circle',     'alert'],
        'warning' => ['warning', 'alert',        'alert'],
        'info'    => ['info',    'info',         'status'],
    ];
@endphp

@foreach ($flashPesan as $kunci => [$jenis, $ikon, $peran])

    @if(session($kunci))

        <div
            class="alert alert-{{ $jenis }}"
            role="{{ $peran }}"
            data-autohide="{{ $jenis === 'danger' ? 10000 : 7000 }}"
        >

            <span class="alert-icon">
                <x-icon :name="$ikon" size="19" />
            </span>

            <div class="alert-body">
                {{ session($kunci) }}
            </div>

            <button
                type="button"
                class="alert-close"
                data-alert-close
                aria-label="Tutup pesan"
            >
                <x-icon name="x" size="16" />
            </button>

        </div>

    @endif

@endforeach
