<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class KirimEmailUji extends Command
{
    protected $signature = 'mail:uji {to? : Alamat email tujuan}';

    protected $description = 'Kirim email uji lewat SMTP asli untuk memastikan konfigurasi email berjalan';

    public function handle(): int
    {
        $tujuan = $this->argument('to')
            ?: config('mail.from.address');

        if (empty($tujuan) || str_contains((string) $tujuan, 'example.com')) {
            $this->error('Alamat tujuan belum valid. Jalankan: php artisan mail:uji nama@domain.com');

            return self::FAILURE;
        }

        $mailer = config('mail.default');

        if ($mailer !== 'smtp') {
            $this->warn("MAIL_MAILER saat ini '{$mailer}' (bukan smtp). Email tidak benar-benar terkirim.");
        }

        $this->info("Mengirim email uji ke: {$tujuan} ...");

        try {
            Mail::to($tujuan)->send(
                new \App\Mail\EmailUji($tujuan)
            );
        } catch (\Throwable $e) {
            $this->error('GAGAL mengirim email: ' . $e->getMessage());

            return self::FAILURE;
        }

        $this->info('BERHASIL. Cek inbox (atau folder Spam) alamat tujuan.');

        return self::SUCCESS;
    }
}
