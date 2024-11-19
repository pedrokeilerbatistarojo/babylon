<?php

namespace App\Shared\Infrastructure\Cli;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearTelescope extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-telescope';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::statement('TRUNCATE TABLE telescope_entries');
        DB::statement('TRUNCATE TABLE telescope_entries_tags');
        DB::statement('TRUNCATE TABLE telescope_monitoring');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
