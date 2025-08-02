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
    
    /**
     * Create a new message instance.
     */
    public function __construct(Permission $permission, String $rejeactionReason)
    {
        $this->permission = $permission;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu solicitud de permiso ha sido rechazada - Persa Sena',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.permission_rejected',
            with: [
                'permission' => $this->permission,
                'apprentice' => $this->permission->apprentice,
                'course' => $this->permission->course,
                'reason' => $this->permission->rejeactionReason,
            ],
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
