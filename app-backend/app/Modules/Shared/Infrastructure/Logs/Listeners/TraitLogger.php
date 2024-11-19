<?php

namespace App\Shared\Infrastructure\Logs\Listeners;

use App\Shared\Utils\YamlExceptionExporter;
use Illuminate\Support\Facades\File;
use Throwable;

trait TraitLogger
{
    public function storeLog(string $prefix, string $log): void
    {
        $path = storage_path("/logs/$prefix.log");
        File::append($path, $log);
    }

    public function storeLogByDate(string $prefix, string $log): void
    {

        $date = date('Y/m/d');
        $path = storage_path("/logs/$date");
        if (! File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        //$day = str_pad(date('d'), 2);
        $path .= "/$prefix.log";

        File::append($path, $log);
    }

    public function storeException(string $prefix, Throwable $exception, mixed $body): void
    {

        $body = json_encode($body, JSON_PRETTY_PRINT);
        $log = 'File: '.$exception->getFile().PHP_EOL;
        $log .= 'Line:'.$exception->getLine().PHP_EOL;
        $log .= 'Exception:'.$exception::class.PHP_EOL;
        $log .= 'Message:'.$exception->getMessage().PHP_EOL;
        $log .= 'Body:'.PHP_EOL.$body.PHP_EOL.PHP_EOL;

        $this->storeLogByDate($prefix, $log);
    }

    public function storeLogByClass(Throwable $exception): void
    {
        $classNameWithNamespace = get_class($this);
        $prefix = substr($classNameWithNamespace, strrpos($classNameWithNamespace, '\\') + 1);
        $log = YamlExceptionExporter::export($exception);
        $this->storeLogByDate($prefix, $log);
    }
}
