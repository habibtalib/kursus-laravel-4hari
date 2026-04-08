<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SelamatDatangMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Cipta instance mel baru.
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Tetapkan sampul mel (subjek, pengirim).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang ke Sistem Zakat Kedah',
        );
    }

    /**
     * Tetapkan kandungan mel.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.selamat-datang',
        );
    }
}
