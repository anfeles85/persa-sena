<?php

namespace App\Mail;

use App\Models\Permission;
use Dotenv\Util\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailAblePermissionDeclined extends Mailable
{
    use Queueable, SerializesModels;

    public $permission;
    public String $rejeactionReason;
    /**
     * Create a new message instance.
     */
    public function __construct(Permission $permission, String $rejeactionReason)
    {
        $this->permission = $permission;
        $this->rejeactionReason = $rejeactionReason;
        $this->permission->load(['apprentice', 'permissionType', 'location']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de permiso rechazada - Persa Sena',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.permission.declined',
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
