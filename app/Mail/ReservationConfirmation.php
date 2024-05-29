<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Visite;
use App\Models\Immobilier;
class ReservationConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $visite;
    public $immobil;
    /**
     * Create a new message instance.
     */
    public function __construct(Visite $visite, Immobilier $immobil)
    {
        $this->visite= $visite;
        $this->immobil=$immobil;
    }
    public function build()
    {
        return $this->view('reservation-confirmation')
                    ->subject('Confirmation de réservation');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reservation Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'reservation-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
