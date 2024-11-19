<?php

namespace App\Shared\Infrastructure\Cli;

use App\Logs\Infrastructure\Jobs\SendLogsJob;
use App\Shared\Utils\MarkdownHelper;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class NotifyDiskUsageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-disk-usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify disk usage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): void
    {

        $directoryPath = storage_path('app/transactions/');
        $filename = storage_path('app/transactions/disk.info');

        // Check if the directory already exists
        if (! File::exists($directoryPath)) {
            // Create the directory tree
            if (! File::makeDirectory($directoryPath, 0755, true)) {
                throw new Exception('Error creating key directory');
            }
        }

        $disk = '/';
        $freeSpace = disk_free_space($disk);
        $totalSpace = disk_total_space($disk);
        $diskPercent = floor(100 * $freeSpace / $totalSpace);
        $diskPercent = intval($diskPercent);
        $bot_channel = config('modules.telegram.bot_logger_channel');

        if ($diskPercent > 25) {
            return;
        }

        $base = 1024;
        $bytes = disk_free_space('/');
        $unit = ['B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB'];
        $class = min((int) log($bytes, $base), count($unit) - 1);
        $diskHuman = sprintf('%1.2f', $bytes / $base ** $class).' '.$unit[$class];

        $data = [
            [
                'text' => 'Espacio libre',
                'value' => "$diskHuman - $diskPercent%",
            ],
        ];

        if (file_exists($filename)) {
            $oldData = file_get_contents($filename);
            $oldData = unserialize($oldData);

            if ($data === $oldData) {
                return;
            }
        }

        foreach ($data as $item) {
            //Log::info($msg);
            //$msg = MarkdownHelper::escapeMarkdown($item['value']);
            SendLogsJob::dispatch($bot_channel, $item['text'], $item['value']);
        }

        $oldData = serialize($data);
        file_put_contents($filename, $oldData);
    }
}
