<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#131F72; padding:30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">Sistem Zakat Kedah</h1>
                            <p style="color:#a0aec0; margin:5px 0 0; font-size:14px;">Lembaga Zakat Negeri Kedah</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 30px;">
                            <h2 style="color:#131F72; margin:0 0 20px;">Assalamualaikum, {{ $user->name }}!</h2>
                            <p style="color:#333; font-size:16px; line-height:1.6;">
                                Selamat datang ke <strong>Sistem Pengurusan Zakat Kedah</strong>. Akaun anda telah berjaya didaftarkan.
                            </p>
                            <p style="color:#333; font-size:16px; line-height:1.6;">
                                Anda kini boleh menggunakan sistem ini untuk:
                            </p>
                            <ul style="color:#555; font-size:15px; line-height:2;">
                                <li>Mendaftar dan mengurus maklumat pembayar zakat</li>
                                <li>Merekod pembayaran zakat</li>
                                <li>Melihat laporan kutipan</li>
                            </ul>
                            <table cellpadding="0" cellspacing="0" style="margin:30px 0;">
                                <tr>
                                    <td style="background-color:#30AE20; border-radius:6px; padding:12px 30px;">
                                        <a href="{{ url('/') }}" style="color:#ffffff; text-decoration:none; font-size:16px; font-weight:bold;">
                                            Log Masuk Sekarang
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="color:#999; font-size:13px;">
                                Jika anda tidak mendaftar akaun ini, sila abaikan e-mel ini.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8f9fa; padding:20px 30px; text-align:center; border-top:1px solid #e2e8f0;">
                            <p style="color:#999; font-size:12px; margin:0;">
                                &copy; {{ date('Y') }} Lembaga Zakat Negeri Kedah. Hak Cipta Terpelihara.<br>
                                <em>Zakat Anda Kami Agih</em>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
