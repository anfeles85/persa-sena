<?php

namespace App\Mail;

use App\Models\Permission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailAblePermissionNotifi extends Mailable
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
            subject: 'Registro de salida de permiso - Persa Sena',
            cc:[ 
               new Address($this->permission->instructor_user->email, $this->permission->instructor_user->fullname),
            ]
        
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.permission_requested',
            with: [
                'permission' => $this->permission,
                'apprentice' => $this->permission->apprentice_user,
                'course' => $this->permission->apprentice_user->courses->first(),
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
