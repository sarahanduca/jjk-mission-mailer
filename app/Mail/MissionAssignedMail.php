<?php
namespace App\Mail;

use App\Models\Mission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MissionAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mission;
    public $sorcererName;
    public $userId;

    public function __construct(Mission $mission, string $sorcererName = 'Feiticeiro', $userId = null)
    {
        $this->mission      = $mission;
        $this->sorcererName = $sorcererName;
        $this->userId       = $userId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎯 Nova Missão Atribuída: ' . $this->mission->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.new-mission',
            with: [
                'mission'      => $this->mission,
                'sorcererName' => $this->sorcererName,
                'userId'       => $this->userId,
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
