<?php

namespace App\Shared\Infrastructure\Services;

use App\Shared\Contracts\EventBusInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Throwable;

class EventBus implements EventBusInterface
{
    /**
     * {@inheritDoc}
     */
    public function dispatch(string $channel, object $message): bool
    {

        try {
            Redis::publish($channel, json_encode($message));
        } catch (Throwable $ex) {

            $m = __METHOD__;
            Log::error("Error in {$m} with message: {$ex->getMessage()}");

            return false;
        }

        return true;
    }

    public function subscribe(string $channel, callable $callback): void
    {
        $redis = Redis::connection('events');
        $redis->subscribe([$channel], function ($message, $channel) use ($callback) {

            try {
                // Parse JSON message
                $data = json_decode($message, $assoc = false, $depth = 512, JSON_THROW_ON_ERROR);
                $callback($data);

            } catch (Throwable $ex) {
                Log::error("Error processing domain event, message: {$ex->getMessage()}");
            }

        });
    }
}
