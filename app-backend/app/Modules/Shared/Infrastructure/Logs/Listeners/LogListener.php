<?php

namespace App\Shared\Infrastructure\Logs\Listeners;

use Illuminate\Log\Events\MessageLogged;

class LogListener
{
    use TraitLogger;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(MessageLogged $event)
    {

        $msg = $event->message;
        if (! str_contains($msg, 'Telescope')) {
            return;
        }

        $log = '['.date('Y-m-d H:i:s').']'.PHP_EOL;
        $log .= $msg.PHP_EOL.PHP_EOL;

        $this->storeLog('log', $log);

    }
}
