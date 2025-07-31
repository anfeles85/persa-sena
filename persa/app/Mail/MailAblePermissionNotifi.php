<?php

namespace App\Mail;

use App\Models\Permission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailAblePermission extends Mailable
{
    use Queueable, SerializesModels;
    public $permission;
    
    /**
     * Create a new message instance.
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
        $this->permission->load(['apprentice', 'permissionType','location']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de permiso enviada - Persa Sena',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.permission.requested',
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
