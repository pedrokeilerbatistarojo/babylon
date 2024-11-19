<?php

namespace App\Modules\Shared\Utils;

use Throwable;

class MarkdownExceptionExporter
{
    /**
     * Exporta una excepción en formato Markdown.
     *
     * @param  Throwable  $exception
     * @return string Markdown que representa la excepción.
     */
    public static function export(Throwable $exception): string
    {
        $markdown = 'Excepción: '.get_class($exception)."\n";
        $markdown .= 'Mensaje:'.$exception->getMessage()."\n";
        $markdown .= 'Código: ```php'.$exception->getCode()."```\n";
        $markdown .= 'Archivo:`'.$exception->getFile()."`\n";
        $markdown .= 'Línea: '.$exception->getLine()."\n";
        $markdown .= 'Fecha y Hora: '.date('Y-m-d H:i:s')."\n\n";

        $markdown .= "Traza\n";
        $markdown .= self::getFormattedTrace($exception);

        if ($exception->getPrevious()) {
            $markdown .= "\n\nExcepción Previa\n";
            $markdown .= self::export($exception->getPrevious());
        }

        return $markdown;
    }

    /**
     * Formatea la traza de la excepción en Markdown.
     *
     * @param  Throwable  $exception
     * @return string Traza de la excepción en formato Markdown.
     */
    private static function getFormattedTrace(Throwable $exception): string
    {
        $trace = $exception->getTrace();
        $formattedTrace = '';

        foreach ($trace as $index => $entry) {
            $formattedTrace .= "{$index}";
            $formattedTrace .= isset($entry['file']) ? '`'.$entry['file'].'`' : '`N/A`';
            $formattedTrace .= ' línea '.($entry['line'] ?? 'N/A')."\n";
            $formattedTrace .= '- Función: '.$entry['function']."\n";
            $formattedTrace .= '- Clase: '.($entry['class'] ?? 'N/A')."\n";
            $formattedTrace .= '- Tipo: '.($entry['type'] ?? '')."\n";
            $formattedTrace .= '- Argumentos: '.implode(', ', array_map([self::class, 'formatArgument'], $entry['args'] ?? []))."\n\n";
        }

        return $formattedTrace;
    }

    /**
     * Formatea un argumento para la traza en Markdown.
     *
     * @param  mixed  $arg
     * @return string Argumento formateado en Markdown.
     */
    private static function formatArgument(mixed $arg): string
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
            return '"'.$arg.'"';
        }

        return (string) $arg;
    }
}
