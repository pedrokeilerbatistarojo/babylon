<?php

namespace App\Modules\Shared\Utils;

class ExcelHelper
{
    public static function percentToFloat($percentStr): float
    {
        $percentFloat = self::getPercentFloat($percentStr);

        // Convert the percentage to a decimal
        return $percentFloat / 100;
    }

    public static function floatToPercent($decimal): string
    {
        // Convert the decimal to a percentage by multiplying by 100
        $percent = $decimal * 100;

        // Format the result as a string with a percentage symbol
        return number_format($percent, 2).'%';
    }

    public static function getPercentFloat($percentStr): float
    {
        // Remove any whitespace and the percentage symbol
        $percentStr = strval($percentStr);
        $cleanedStr = trim($percentStr);
        $cleanedStr = str_replace('%', '', $cleanedStr);

        // Parse the string as a floating-point number
        return floatval($cleanedStr);
    }

    public static function numberToExcelColumn(int $num)
    {
        $column = '';
        while ($num > 0) {
            $remainder = ($num - 1) % 26;
            $column = chr(65 + $remainder).$column;
            $num = intval(($num - 1) / 26);
        }

        return $column;
    }
}
