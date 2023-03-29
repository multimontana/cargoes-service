<?php

namespace App\Jobs;

use App\Mail\InviteSystemEntityMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class InviteInSystemEntityJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private array $inviteData;
    protected string $to;

    /**
     * Create a new job instance.
     *
     * @param array $inviteData
     */
    public function __construct(array $inviteData)
    {
        $this->to = $inviteData['email'];
        $this->inviteData = $inviteData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new InviteSystemEntityMail($this->inviteData));
    }
}
