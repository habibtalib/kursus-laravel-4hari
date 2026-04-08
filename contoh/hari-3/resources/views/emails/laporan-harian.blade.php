<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#131F72; padding:25px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:20px;">Laporan Harian Zakat Kedah</h1>
                            <p style="color:#a0aec0; margin:5px 0 0; font-size:14px;">{{ $laporan['tarikh'] }}</p>
                        </td>
                    </tr>
                    <!-- Stats -->
                    <tr>
                        <td style="padding:30px;">
                            <h3 style="color:#131F72; margin:0 0 15px;">Ringkasan Hari Ini</h3>
                            <table width="100%" cellpadding="10" cellspacing="0" style="border:1px solid #e2e8f0; border-radius:6px;">
                                <tr style="background-color:#f8f9fa;">
                                    <td style="font-weight:bold; color:#555; border-bottom:1px solid #e2e8f0;">Transaksi Hari Ini</td>
                                    <td style="text-align:right; color:#131F72; font-weight:bold; border-bottom:1px solid #e2e8f0;">{{ $laporan['transaksi_hari_ini'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#555; border-bottom:1px solid #e2e8f0;">Kutipan Hari Ini</td>
                                    <td style="text-align:right; color:#30AE20; font-weight:bold; font-size:18px; border-bottom:1px solid #e2e8f0;">RM {{ number_format($laporan['kutipan_hari_ini'], 2) }}</td>
                                </tr>
                                <tr style="background-color:#f8f9fa;">
                                    <td style="font-weight:bold; color:#555; border-bottom:1px solid #e2e8f0;">Jumlah Transaksi Keseluruhan</td>
                                    <td style="text-align:right; color:#131F72; border-bottom:1px solid #e2e8f0;">{{ $laporan['jumlah_transaksi'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#555;">Jumlah Kutipan Keseluruhan</td>
                                    <td style="text-align:right; color:#131F72; font-weight:bold; font-size:18px;">RM {{ number_format($laporan['jumlah_kutipan'], 2) }}</td>
                                </tr>
                            </table>
                            <p style="color:#999; font-size:13px; margin-top:20px;">
                                Laporan ini dijana secara automatik oleh Sistem Zakat Kedah.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8f9fa; padding:15px; text-align:center; border-top:1px solid #e2e8f0;">
                            <p style="color:#999; font-size:12px; margin:0;">
                                &copy; {{ date('Y') }} Lembaga Zakat Negeri Kedah
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
