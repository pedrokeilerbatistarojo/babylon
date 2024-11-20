<?php

namespace App\Terminals\Infrastructure\Cli;

use App\Terminals\Infrastructure\Jobs\SyncTerminalsJob;
use Illuminate\Console\Command;

class SyncTerminalsCommand extends Command
{
    protected $signature = 'sync:terminals';

    protected $description = 'Command description';

    public function handle(): void
    {
        SyncTerminalsJob::dispatch();
    }
}
