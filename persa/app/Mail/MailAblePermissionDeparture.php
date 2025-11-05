<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailAblePermissionDeparture extends Mailable
{
    use Queueable, SerializesModels;

    public $permission;
    public $apprentice;
    public $course;

    /**
     * Create a new message instance.
     */
    public function __construct(Permission $permission, User $apprentice, Course $course)
    {
        $this->permission = $permission;
        $this->apprentice = $apprentice;
        $this->course = $course;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Salida Registrada - Permiso Aprobado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.permission_departure',
            with: [
                'permission' => $this->permission,
                'apprentice' => $this->apprentice,
                'course'     => $this->course,
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
