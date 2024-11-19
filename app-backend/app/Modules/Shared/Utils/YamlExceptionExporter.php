<?php

namespace App\Modules\Shared\Utils;

use Throwable;

class YamlExceptionExporter
{
    /**
     * Exporta una excepción en formato YAML.
     *
     * @param  Throwable  $exception
     * @return string YAML que representa la excepción.
     */
    public static function export(Throwable $exception): string
    {
        $yaml = "Exception:\n";
        $yaml .= '  timestamp: "'.date('Y-m-d H:i:s')."\"\n";
        $yaml .= '  type: '.get_class($exception)."\n";
        $yaml .= '  message: "'.self::escapeString($exception->getMessage())."\"\n";
        $yaml .= '  code: '.$exception->getCode()."\n";
        $yaml .= '  file: "'.$exception->getFile()."\"\n";
        $yaml .= '  line: '.$exception->getLine()."\n";

        /*
        $yaml .= "  trace:\n" . self::getFormattedTrace($exception);
        if ($exception->getPrevious()) {
            $yaml .= "  previous:\n" . self::export($exception->getPrevious());
        }
        */

        return $yaml;
    }

    /**
     * Formatea la traza de la excepción en YAML.
     *
     * @param  Throwable  $exception
     * @return string Traza de la excepción en formato YAML.
     */
    public static function getFormattedTrace(Throwable $exception): string
    {
        $trace = $exception->getTrace();
        $formattedTrace = '';

        foreach ($trace as $index => $entry) {
            $formattedTrace .= '    - step: '.$index."\n";
            $formattedTrace .= '      file: "'.($entry['file'] ?? 'N/A')."\"\n";
            $formattedTrace .= '      line: '.($entry['line'] ?? 'N/A')."\n";
            $formattedTrace .= '      function: '.$entry['function']."\n";
            $formattedTrace .= '      class: "'.($entry['class'] ?? 'N/A')."\"\n";
            $formattedTrace .= '      type: "'.($entry['type'] ?? '')."\"\n";
            $formattedTrace .= '      args: ['.implode(', ', array_map([self::class, 'formatArgument'], $entry['args'] ?? []))."]\n";
        }

        return $formattedTrace;
    }

    /**
     * Formatea un argumento para la traza en YAML.
     *
     * @param  mixed  $arg
     * @return string Argumento formateado en YAML.
     */
    public static function formatArgument($arg): string
    {
        if (is_object($arg)) {
            return 'Object('.get_class($arg).')';
        } elseif (is_array($arg)) {
            return 'Array('.count($arg).')';
        } elseif (is_null($arg)) {
            return 'null';
        } elseif (is_bool($arg)) {
            return $arg ? 'true' : 'false';
        } elseif (is_string($arg)) {
            return '"'.self::escapeString($arg).'"';
        }

        return (string) $arg;
    }

    /**
     * Escapa caracteres especiales en una cadena para el formato YAML.
     *
     * @param  string  $string
     * @return string Cadena escapada.
     */
    private static function escapeString(string $string): string
    {
        return str_replace(["\n", "\r", '"'], ['\n', '\r', '\"'], $string);
    }
}
