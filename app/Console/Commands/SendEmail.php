<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $formattedMessage = "\nEmail To: task_schedule@gmail.com" . "\n\n\nMessage: This is from Task Scheduling";

        // Send the email using Mailtrap
        Mail::raw($formattedMessage, function ($message) {
            $message->to('task_schedule@gmail.com')
                    ->subject('Mailing Service From Task Scheduling');
        });
    }
}
