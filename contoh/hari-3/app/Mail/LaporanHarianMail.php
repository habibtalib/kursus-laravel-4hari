<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanHarianMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Cipta instance mel baru.
     */
    public function __construct(
        public array $laporan
    ) {}

    /**
     * Tetapkan sampul mel.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Harian Zakat Kedah - ' . now()->format('d/m/Y'),
        );
    }

    /**
     * Tetapkan kandungan mel.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.laporan-harian',
        );
    }
}
