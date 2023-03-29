<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthVerifyMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $code;

    /**
     * Create a new message instance.
     *
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.mailers.smtp.from'), 'Auth')
            ->subject('Verification')
            ->view('mails.verification', [
                'code' => $this->code
            ]);
    }
}
