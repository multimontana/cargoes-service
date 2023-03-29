<?php

namespace App\Jobs;

use App\Mail\AuthVerifyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AuthVerifyJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string $code;
    protected string $to;

    /**
     * Create a new job instance.
     *
     * @param $email
     * @param string $code
     */
    public function __construct(string $email, string $code)
    {
        $this->to = $email;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new AuthVerifyMail($this->code));
    }
}
