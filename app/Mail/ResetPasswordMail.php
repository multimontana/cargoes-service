<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $link;

    /**
     * Create a new message instance.
     *
     * @param string $link
     */
    public function __construct(string $link)
    {
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.mailers.smtp.from'), 'Reset Password')
            ->subject('Reset Password')
            ->view('mails.reset_password', [
                'link' => $this->link
            ]);
    }
}
