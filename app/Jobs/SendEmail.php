<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $mailTo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $mailTo)
    {
        $this->email = $email;
        $this->mailTo = $mailTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->mailTo)->send($this->email);
            Log::info('sent: ' . $this->mailTo);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
