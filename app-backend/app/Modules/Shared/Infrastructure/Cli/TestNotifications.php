<?php

namespace App\Shared\Infrastructure\Cli;

use App\Shared\Contracts\NotificationInterface;
use Illuminate\Console\Command;
use Random\RandomException;

class TestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @throws RandomException
     */
    public function handle(NotificationInterface $notification): void
    {
        $rand = random_int(1, 100);
        $subject = "Test message $rand";
        $message = fake()->paragraph();
        $bot_channel = config('modules.telegram.bot_logger_channel');
        $notification->send($bot_channel, $subject, $message);
    }
}
