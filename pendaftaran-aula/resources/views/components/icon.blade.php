{{--
    Ikon SVG sebaris (inline) — menggantikan emoji/karakter simbol.
    Pemakaian: <x-icon name="check" /> atau <x-icon name="bell" size="18" />
    Ukuran mengikuti CSS induknya (mis. .sidebar-icon svg) bila diatur di sana.
--}}

@props(['name', 'size' => 20])

<svg
    {{ $attributes->merge(['class' => 'icon']) }}
    width="{{ $size }}"
    height="{{ $size }}"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.75"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
    focusable="false"
>
    @switch($name)

        {{-- Navigasi --}}
        @case('dashboard')
            <rect x="3" y="3" width="7" height="9" rx="1.5" />
            <rect x="14" y="3" width="7" height="5" rx="1.5" />
            <rect x="14" y="12" width="7" height="9" rx="1.5" />
            <rect x="3" y="16" width="7" height="5" rx="1.5" />
            @break

        @case('building')
            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
            <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
            <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
            <path d="M10 6h4" />
            <path d="M10 10h4" />
            <path d="M10 14h4" />
            <path d="M10 18h4" />
            @break

        @case('history')
            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
            <rect x="8" y="2" width="8" height="4" rx="1" />
            <path d="M12 11h4" />
            <path d="M12 16h4" />
            <path d="M8 11h.01" />
            <path d="M8 16h.01" />
            @break

        @case('checklist')
            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
            <rect x="8" y="2" width="8" height="4" rx="1" />
            <path d="m9 14 2 2 4-4" />
            @break

        @case('chart')
            <path d="M3 3v18h18" />
            <path d="M8 17v-6" />
            <path d="M13 17V7" />
            <path d="M18 17v-3" />
            @break

        @case('info')
            <circle cx="12" cy="12" r="9" />
            <path d="M12 16v-4" />
            <path d="M12 8h.01" />
            @break

        @case('logout')
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <path d="m16 17 5-5-5-5" />
            <path d="M21 12H9" />
            @break

        @case('bell')
            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
            <path d="M13.7 21a2 2 0 0 1-3.4 0" />
            @break

        @case('chevron-down')
            <path d="m6 9 6 6 6-6" />
            @break

        @case('chevron-right')
            <path d="m9 6 6 6-6 6" />
            @break

        @case('menu')
            <path d="M4 6h16" />
            <path d="M4 12h16" />
            <path d="M4 18h16" />
            @break

        @case('arrow-left')
            <path d="M19 12H5" />
            <path d="m12 19-7-7 7-7" />
            @break

        @case('arrow-up')
            <path d="M12 19V5" />
            <path d="m5 12 7-7 7 7" />
            @break

        @case('arrow-right')
            <path d="M5 12h14" />
            <path d="m12 5 7 7-7 7" />
            @break

        @case('calendar')
            <rect x="3" y="5" width="18" height="16" rx="2" />
            <path d="M3 10h18" />
            <path d="M8 3v4" />
            <path d="M16 3v4" />
            @break

        @case('eye')
            <path d="M2.2 12S5.8 5.5 12 5.5 21.8 12 21.8 12 18.2 18.5 12 18.5 2.2 12 2.2 12Z" />
            <circle cx="12" cy="12" r="3" />
            @break

        @case('eye-off')
            <path d="M10.6 6a9.9 9.9 0 0 1 1.4-.1c6.2 0 9.8 6.1 9.8 6.1a17 17 0 0 1-3 3.8" />
            <path d="M6.3 7.9A16.7 16.7 0 0 0 2.2 12S5.8 18.1 12 18.1a9.7 9.7 0 0 0 4.3-1" />
            <path d="m9.9 9.9a3 3 0 0 0 4.2 4.2" />
            <path d="m3 3 18 18" />
            @break

        @case('trash')
            <path d="M4 7h16" />
            <path d="M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
            <path d="M6 7v13a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7" />
            <path d="M10 11v6" />
            <path d="M14 11v6" />
            @break

        @case('save')
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z" />
            <path d="M17 21v-8H7v8" />
            <path d="M7 3v5h8" />
            @break

        @case('filter')
            <path d="M3 5h18l-7 8v6l-4 2v-8Z" />
            @break

        @case('plus')
            <path d="M12 5v14" />
            <path d="M5 12h14" />
            @break

        @case('search')
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-3.5-3.5" />
            @break

        {{-- Status --}}
        @case('check')
            <path d="M20 6 9 17l-5-5" />
            @break

        @case('x')
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
            @break

        @case('clock')
            <circle cx="12" cy="12" r="9" />
            <path d="M12 7v5l3 2" />
            @break

        @case('alert')
            <circle cx="12" cy="12" r="9" />
            <path d="M12 8v4" />
            <path d="M12 16h.01" />
            @break

        @case('check-circle')
            <circle cx="12" cy="12" r="9" />
            <path d="m8.5 12.2 2.4 2.4 4.6-4.8" />
            @break

        @case('x-circle')
            <circle cx="12" cy="12" r="9" />
            <path d="m14.8 9.2-5.6 5.6" />
            <path d="m9.2 9.2 5.6 5.6" />
            @break

        @case('ban')
            <circle cx="12" cy="12" r="9" />
            <path d="m5.6 5.6 12.8 12.8" />
            @break

        @case('inbox')
            <path d="M3 12h5l1.5 3h5L16 12h5" />
            <path d="M4.6 5.6 3 12v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6l-1.6-6.4A2 2 0 0 0 17.5 4h-11a2 2 0 0 0-1.9 1.6Z" />
            @break

        {{-- Data --}}
        @case('users')
            <path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
            <circle cx="9.5" cy="7" r="4" />
            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            @break

        @case('user')
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
            @break

        @case('briefcase')
            <rect x="2" y="7" width="20" height="14" rx="2" />
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
            @break

        @case('map-pin')
            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
            <circle cx="12" cy="10" r="3" />
            @break

        @case('printer')
            <path d="M6 9V3h12v6" />
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
            <rect x="6" y="14" width="12" height="8" rx="1" />
            @break

        @case('pencil')
            <path d="M12 20h9" />
            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
            @break

        @case('megaphone')
            <path d="m3 11 18-5v12L3 14v-3Z" />
            <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />
            @break

        @case('message')
            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
            @break

        @case('mail')
            <rect x="2.5" y="5" width="19" height="14" rx="2" />
            <path d="m3 7 9 6 9-6" />
            @break

        @case('lock')
            <rect x="4" y="10" width="16" height="11" rx="2" />
            <path d="M8 10V7a4 4 0 0 1 8 0v3" />
            <path d="M12 15v2" />
            @break

        @case('key')
            <circle cx="8" cy="15" r="4" />
            <path d="m10.8 12.2 8-8" />
            <path d="m16 5 3 3" />
            <path d="m13.5 7.5 3 3" />
            @break

        {{-- Waktu --}}
        @case('sunrise')
            <path d="M12 3v5" />
            <path d="m9 6 3-3 3 3" />
            <circle cx="12" cy="15" r="4" />
            <path d="M3 22h18" />
            @break

        @case('sun')
            <circle cx="12" cy="12" r="4" />
            <path d="M12 2v2" />
            <path d="M12 20v2" />
            <path d="m4.9 4.9 1.4 1.4" />
            <path d="m17.7 17.7 1.4 1.4" />
            <path d="M2 12h2" />
            <path d="M20 12h2" />
            <path d="m6.3 17.7-1.4 1.4" />
            <path d="m19.1 4.9-1.4 1.4" />
            @break

        @case('sunset')
            <path d="M12 8V3" />
            <path d="m9 5 3 3 3-3" />
            <circle cx="12" cy="15" r="4" />
            <path d="M3 22h18" />
            @break

        @case('moon')
            <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" />
            @break

        @case('day-night')
            <path d="M12 3v4" />
            <path d="m9 5 3-3 3 3" />
            <circle cx="12" cy="13" r="3.5" />
            <path d="M12 21v-4" />
            <path d="m9 19 3 3 3-3" />
            @break

    @endswitch
</svg>
