<?php

namespace App\Shared\Infrastructure\Jobs;

use App\Shared\Infrastructure\Logs\Listeners\TraitLogger;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class NotifyViewJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, TraitDefaultJobConf;
    use TraitLogger;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public int $backoff = 5;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 5;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 5;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $channel)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @throws GuzzleException
     */
    public function handle(): void
    {

        try {

            $url = config('modules.websocket.url');
            $url .= 'send/channel/'.$this->channel;
            $client = new Client;
            $client->request('GET', $url);

        } catch (Exception $exception) {
            $this->storeLogByClass($exception);
        }

    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return $this->channel;
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware(): array
    {
        return [/*new WithoutOverlapping($this->channel)*/];
    }
}
