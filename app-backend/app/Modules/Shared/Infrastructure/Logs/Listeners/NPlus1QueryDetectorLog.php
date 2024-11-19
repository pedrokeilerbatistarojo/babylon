<?php

namespace App\Shared\Infrastructure\Logs\Listeners;

use BeyondCode\QueryDetector\Outputs\Output;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class NPlus1QueryDetectorLog implements Output
{
    use TraitLogger;

    public function boot()
    {
        //
    }

    public function output(Collection $detectedQueries, Response $response): void
    {
        $this->log('Detected N+1 Query');

        foreach ($detectedQueries as $detectedQuery) {

            $logOutput = 'Model: '.$detectedQuery['model'].PHP_EOL;
            $logOutput .= 'Relation: '.$detectedQuery['relation'].PHP_EOL;
            $logOutput .= 'Num-Called: '.$detectedQuery['count'].PHP_EOL;
            $logOutput .= 'Call-Stack:'.PHP_EOL;

            foreach ($detectedQuery['sources'] as $source) {
                $logOutput .= '#'.$source->index.' '.$source->name.':'.$source->line.PHP_EOL;
            }

            $logOutput .= 'Call-Stack:'.PHP_EOL.PHP_EOL;

            $this->log($logOutput);
        }
    }

    private function log(string $message): void
    {
        $this->storeLog('n1-query-detector', $message);
    }
}
