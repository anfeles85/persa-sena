<?php

namespace App\Mail;

use App\Models\Permission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class MailAblePermissionAcepted extends Mailable
{
    use Queueable, SerializesModels;
    public $permission;

    /**
     * Create a new message instance.
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permiso Aceptado - Persa Sena',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.permission_approved',
            with: [
            'apprentice' => $this->permission->apprentice_user,
            'permission' => $this->permission,
            'course' => $this->permission->apprentice_user->course()->first(),
        ]
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
