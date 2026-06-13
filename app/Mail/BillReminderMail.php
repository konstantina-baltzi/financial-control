<?php

namespace App\Mail;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BillReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    // Ορίζουμε μια δημόσια μεταβλητή για να μπορούμε να τη δούμε στο view του email
    public $bill;

    /**
     * Create a new message instance.
     */
    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    /**
     * Get the message envelope (Θέμα του email).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Υπενθύμιση: Ο λογαριασμός "' . $this->bill->title . '" λήγει σύντομα!',
        );
    }

    /**
     * Get the message content definition (Ποιο αρχείο HTML θα είναι το σώμα του email).
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.bill-reminder',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
