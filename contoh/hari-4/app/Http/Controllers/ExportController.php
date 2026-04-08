<?php

namespace App\Http\Controllers;

use App\Models\Pembayar;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Eksport senarai pembayar ke CSV.
     */
    public function pembayar(): StreamedResponse
    {
        $fileName = 'pembayar_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            // Tajuk lajur
            fputcsv($handle, [
                'ID', 'Nama', 'No. IC', 'Alamat', 'No. Tel',
                'E-mel', 'Pekerjaan', 'Pendapatan Bulanan', 'Tarikh Daftar',
            ]);

            // Data
            Pembayar::orderBy('nama')->chunk(100, function ($pembayars) use ($handle) {
                foreach ($pembayars as $p) {
                    fputcsv($handle, [
                        $p->id,
                        $p->nama,
                        $p->no_ic,
                        $p->alamat,
                        $p->no_tel,
                        $p->email ?? '',
                        $p->pekerjaan ?? '',
                        $p->pendapatan_bulanan ?? 0,
                        $p->created_at->format('d/m/Y'),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Eksport senarai pembayaran ke CSV.
     */
    public function pembayaran(Request $request): StreamedResponse
    {
        $fileName = 'pembayaran_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($request) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'No. Resit', 'Pembayar', 'No. IC', 'Jenis Zakat',
                'Jumlah (RM)', 'Tarikh Bayar', 'Cara Bayar', 'Status',
            ]);

            $query = Pembayaran::with(['pembayar', 'jenisZakat'])->orderBy('tarikh_bayar', 'desc');

            // Tapis mengikut status jika ada
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            $query->chunk(100, function ($pembayarans) use ($handle) {
                foreach ($pembayarans as $b) {
                    fputcsv($handle, [
                        $b->no_resit,
                        $b->pembayar->nama,
                        $b->pembayar->no_ic,
                        $b->jenisZakat->nama,
                        number_format($b->jumlah, 2),
                        $b->tarikh_bayar->format('d/m/Y'),
                        ucfirst($b->cara_bayar),
                        ucfirst($b->status),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
