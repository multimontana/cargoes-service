<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteSystemEntityMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private array $inviteData;

    /**
     * Create a new message instance.
     *
     * @param array $inviteData
     */
    public function __construct(array $inviteData)
    {
        $this->inviteData = $inviteData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.mailers.smtp.from'), 'Via ReSkript')
            ->subject('Via ReSkript')
            ->view('mails.project_invite', [
                'inviteData' => $this->inviteData
            ]);
    }
}
