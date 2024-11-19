<?php

namespace App\Shared\Infrastructure\Jobs;

use Throwable;

trait TraitDefaultJobConf
{
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public int $timeout = 120;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public bool $deleteWhenMissingModels = true;

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        report($exception);
    }
}
