{{-- =====================================================================
     Ringkasan kesalahan validasi formulir.
     Pemakaian: @include('partials.errors')
====================================================================== --}}

@if($errors->any())

    <div class="alert alert-danger" role="alert">

        <span class="alert-icon">
            <x-icon name="x-circle" size="19" />
        </span>

        <div class="alert-body">

            <strong>
                @if($errors->count() === 1)
                    Terdapat 1 isian yang perlu diperbaiki:
                @else
                    Terdapat {{ $errors->count() }} isian yang perlu diperbaiki:
                @endif
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

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
