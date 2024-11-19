<?php

namespace App\Modules\Shared\Utils;

use Illuminate\Support\Carbon;

class DatetimeHelper
{
    // Method to get the first DateTime of the current month
    public static function getFirstDateTimeOfMonth(): Carbon
    {
        return new Carbon('first day of this month midnight');
    }

    // Method to get the last DateTime of the current month
    public static function getLastDateTimeOfMonth(): Carbon
    {
        return new Carbon('last day of this month 23:59:59');
    }

    public static function getMonthRange(): array
    {
        return [self::getFirstDateTimeOfMonth(), self::getLastDateTimeOfMonth()];
    }

    public static function formatMilliseconds(float $milliseconds): string
    {

        $milliseconds = intval($milliseconds);

        // Calculate components
        $seconds = floor($milliseconds / 1000);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);

        // Remainders
        $milliseconds = $milliseconds % 1000;
        $seconds = $seconds % 60;
        $minutes = $minutes % 60;
        $hours = $hours % 24;

        // Construct human-readable string
        $formatted = '';
        if ($days > 0) {
            $formatted .= $days.'d ';
        }
        if ($hours > 0) {
            $formatted .= $hours.'h ';
        }
        if ($minutes > 0) {
            $formatted .= $minutes.'m ';
        }
        if ($seconds > 0) {
            $formatted .= $seconds.'s ';
        }
        if ($milliseconds > 0) {
            $formatted .= $milliseconds.'ms';
        }

        return trim($formatted);
    }

    public static function getBatchDatetimeRange(): array
    {
        $currentDay = date('N'); // Get the current day of the week
        $startDatetime = Carbon::now(); // Get the current datetime
        $endDatetime = Carbon::now(); // End of the current day
        $startDatetime->setTime(0, 0, 0); // Start of the current day
        $endDatetime->setTime(23, 59, 59); // Adjust to the end of the current day

        if (in_array($currentDay, [5, 6, 7])) {
            // If today is Friday, Saturday, or Sunday
            $endDatetime = new Carbon('next Sunday 23:59:59'); // End of Sunday
        }

        return [$startDatetime, $endDatetime];
    }

    public static function getMonthNameInSpanish(int $monthNumber)
    {

        $months = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return $months[$monthNumber] ?? 'Mes inválido';
    }
}
