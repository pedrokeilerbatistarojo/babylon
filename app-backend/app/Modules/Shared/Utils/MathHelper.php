<?php

namespace App\Modules\Shared\Utils;

class MathHelper
{
    public static function calcPercent(mixed $amount, mixed $commission): string
    {
        //return bcdiv(bcmul($amount, $commission, APP_ROUND_DECIMALS), '100', APP_ROUND_DECIMALS);
        return bcmul($amount, $commission, APP_ROUND_DECIMALS);
    }

    public static function sumArray(array $commissions): string
    {
        return array_reduce($commissions, function ($carry, $item) {
            return bcadd($carry, $item, APP_ROUND_DECIMALS);
        });
    }

    public static function sum(): string
    {
        $args = func_get_args();  // Get all passed arguments
        $total = '0';  // Initialize the total as a string

        foreach ($args as $arg) {
            $total = bcadd($total, $arg, APP_ROUND_DECIMALS);  // Sum with bcadd, precision of 8 decimal places
        }

        return $total;
    }
}
