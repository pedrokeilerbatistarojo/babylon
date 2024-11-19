<?php

namespace App\Modules\Shared\Contracts;

interface EventBusInterface
{
    /**
     * Dispatches the given message.
     *
     * @param  string  $channel  The name of the channel to write.
     * @param  object  $message  The message
     */
    public function dispatch(string $channel, object $message): bool;

    /**
     * Subscribes to events with the given name and specifies a callback function to handle them.
     *
     * @param  string  $channel  The name of the channel to subscribe.
     * @param  callable  $callback  The callback function to handle the event.
     */
    public function subscribe(string $channel, callable $callback): void;
}
