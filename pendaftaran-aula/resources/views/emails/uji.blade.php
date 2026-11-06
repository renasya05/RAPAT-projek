<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Uji</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9; padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px; background:#ffffff; border-radius:14px; overflow:hidden; border:1px solid #dbe3ec;">
                    <tr>
                        <td style="background:#12355b; padding:22px 26px;">
                            <div style="color:#93c5fd; font-size:12px; letter-spacing:1px; text-transform:uppercase;">&#9993; Uji Konfigurasi Email</div>
                            <div style="color:#ffffff; font-size:20px; font-weight:bold; margin-top:6px;">{{ config('app.name') }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:26px;">
                            <p style="margin:0 0 14px; color:#1e293b; font-size:15px; line-height:1.6;">
                                Selamat! Email ini berhasil dikirim melalui <strong>SMTP asli</strong>.
                                Artinya konfigurasi email aplikasi Anda sudah berjalan.
                            </p>
                            <p style="margin:0 0 14px; color:#475569; font-size:14px; line-height:1.6;">
                                Email ini dikirim ke: <strong>{{ $tujuan }}</strong>
                            </p>
                            <p style="margin:0; color:#94a3b8; font-size:12px; line-height:1.6;">
                                Waktu kirim: {{ now()->format('d/m/Y H:i') }} WITA
                            </p>
                        </td>
                    </tr>
                </table>
                <div style="color:#94a3b8; font-size:11px; margin-top:14px;">
                    Email otomatis &mdash; mohon jangan dibalas.
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
