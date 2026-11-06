<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kontak Admin
    |--------------------------------------------------------------------------
    |
    | Isi di .env untuk menampilkan blok "Kontak Admin" pada halaman
    | Informasi. Kosongkan bagian mana pun yang tidak dipakai; blok
    | hanya dirender kalau minimal satu terisi.
    |
    */

    'kontak_admin' => [
        'telepon' => env('SAPA_KONTAK_TELEPON'),
        'email' => env('SAPA_KONTAK_EMAIL'),
        'alamat' => env('SAPA_KONTAK_ALAMAT'),
    ],

];
