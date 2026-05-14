<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationResult extends Mailable
{
    use Queueable, SerializesModels;
    public $applicant;
    public $status;
    /**
     * Create a new message instance.
     */
    public function __construct($applicant, $status)
    {
        $this->applicant = $applicant;
        $this->status = $status;
    }
    public function build()
    {
        return $this->view('emails.application_result'); // ĐỔI Ở ĐÂY
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Result',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.application_result', // ĐỔI Ở ĐÂY
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
