<?php

namespace App\Shared\Infrastructure\Logs\Listeners;

use App\Shared\Utils\DatetimeHelper;
use Illuminate\Database\Events\QueryExecuted;
use PDO;
use PDOException;
use Throwable;

class QueryExecutedListener
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
     * @throws Throwable
     */
    public function handle(QueryExecuted $query): void
    {

        $allowLog = config('modules.log.query');
        if ($allowLog) {

            //skips laravel jobs
            $skips = [
                //'select * from `jobs`',
                //'insert into `jobs`',
                '`jobs`',
                'telescope_',
                'pulse_',
            ];

            foreach ($skips as $skip) {
                if (str_contains($query->sql, $skip)) {
                    return;
                }
            }

            //'time' => number_format($query->time, 2, '.', ''),
            $time = $query->time;
            $formatted_time = DatetimeHelper::formatMilliseconds($time);
            $params = json_encode($query->bindings);
            $log = '['.date('Y-m-d H:i:s').']'.PHP_EOL;
            $log .= 'Execution time: '.$formatted_time.PHP_EOL;
            $log .= $query->sql.PHP_EOL;
            $log .= 'Params: '.$params.PHP_EOL;
            $log .= 'Full query: '.$this->replaceBindings($query).PHP_EOL.PHP_EOL;

            $this->storeLog('query', $log);

        }

    }

    /**
     * Format the given bindings to strings.
     *
     * @param  QueryExecuted  $event
     * @return array
     */
    protected function formatBindings(QueryExecuted $event): array
    {
        return $event->connection->prepareBindings($event->bindings);
    }

    /**
     * Replace the placeholders with the actual bindings.
     *
     * @param  QueryExecuted  $event
     * @return string
     *
     * @throws Throwable
     */
    public function replaceBindings(QueryExecuted $event): string
    {
        $sql = $event->sql;

        foreach ($this->formatBindings($event) as $key => $binding) {
            $regex = is_numeric($key)
                ? "/\?(?=(?:[^'\\\']*'[^'\\\']*')*[^'\\\']*$)/"
                : "/:{$key}(?=(?:[^'\\\']*'[^'\\\']*')*[^'\\\']*$)/";

            if ($binding === null) {
                $binding = 'null';
            } elseif (! is_int($binding) && ! is_float($binding)) {
                $binding = $this->quoteStringBinding($event, $binding);
            }

            $sql = preg_replace(
                $regex,
                $binding,
                $sql,
                is_numeric($key) ? 1 : -1
            );
        }

        return $sql;
    }

    /**
     * Add quotes to string bindings.
     *
     * @param  QueryExecuted  $event
     * @param  string  $binding
     * @return string
     *
     * @throws Throwable
     */
    protected function quoteStringBinding($event, $binding)
    {
        try {
            $pdo = $event->connection->getPdo();

            if ($pdo instanceof PDO) {
                return $pdo->quote($binding);
            }
        } catch (PDOException $e) {
            throw_if($e->getCode() !== 'IM001', $e);
        }

        // Fallback when PDO::quote function is missing...
        $binding = \strtr($binding, [
            chr(26) => '\\Z',
            chr(8) => '\\b',
            '"' => '\"',
            "'" => "\'",
            '\\' => '\\\\',
        ]);

        return "'".$binding."'";
    }
}
