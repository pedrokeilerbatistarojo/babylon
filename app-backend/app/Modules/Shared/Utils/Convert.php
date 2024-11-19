<?php

namespace App\Modules\Shared\Utils;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\MathException as BrickMathException;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\RoundingMode;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Exceptions\MathException;
use Illuminate\Support\Facades\Date;
use InvalidArgumentException;

class Convert
{
    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string  $type
     * @param  mixed  $value
     * @return mixed
     */
    public static function castTo(string $type, mixed $value): mixed
    {

        if (is_null($value)) {
            return null;
        }

        return match ($type) {
            'int', 'integer' => (int) $value,
            'real', 'float', 'double' => self::fromFloat($value),
            'decimal' => self::asDecimal($value, explode(':', $type, 2)[1]),
            'object', 'array', 'json', 'collection', 'string' => (string) $value,
            'bool', 'boolean' => self::asBoolean($value),
            'date' => self::asDate($value),
            'datetime' => self::asDateTime($value),
            'immutable_date' => self::asDate($value)->toImmutable(),
            'immutable_datetime' => self::asDateTime($value)->toImmutable(),
            'timestamp' => self::asTimestamp($value),
            default => $value,
        };

    }

    /**
     * Decode the given float.
     *
     * @param  mixed  $value
     * @return float
     */
    public static function fromFloat(mixed $value): float
    {
        return match ((string) $value) {
            'Infinity' => INF,
            '-Infinity' => -INF,
            'NaN' => NAN,
            default => (float) $value,
        };
    }

    /**
     * @param  mixed  $value
     * @return bool
     */
    public static function asBoolean(mixed $value): bool
    {

        // Define possible true and false values
        $trueValues = ['true', 'on', 'yes', '1', 1, true];
        $falseValues = ['false', 'off', 'no', '0', 0, false, null];

        // Convert the value to lowercase if it is a string
        if (is_string($value)) {
            $value = strtolower($value);
        }

        // Check if the value is in true or false arrays
        if (in_array($value, $trueValues, true)) {
            return true;
        } elseif (in_array($value, $falseValues, true)) {
            return false;
        }

        // Force convert if the value is not recognized
        return (bool) intval($value);
    }

    /**
     * Return a decimal as string.
     *
     * @param  mixed  $value
     * @param  int  $decimals
     * @return string
     */
    public static function asDecimal(mixed $value, int $decimals): string
    {
        try {
            return (string) BigDecimal::of($value)->toScale($decimals, RoundingMode::HALF_UP);
        } catch (BrickMathException|NumberFormatException|DivisionByZeroException $e) {
            throw new MathException('Unable to cast value to a decimal.', previous: $e);
        }
    }

    /**
     * Return a timestamp as unix timestamp.
     *
     * @param  mixed  $value
     * @return int
     */
    protected function asTimestamp(mixed $value): int
    {
        return $this->asDateTime($value)->getTimestamp();
    }

    /**
     * Return a timestamp as DateTime object with time set to 00:00:00.
     *
     * @param  mixed  $value
     * @return Carbon
     */
    public static function asDate(mixed $value): Carbon
    {
        return self::asDateTime($value)->startOfDay();
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed  $value
     * @return false|Carbon
     */
    public static function asDateTime(mixed $value): false|Carbon
    {

        $format = 'Y-m-d H:i:s';
        $arr = explode(':', $value);
        if (count($arr) === 2) {
            $format = $arr[1];
        }

        // If this value is already a Carbon instance, we shall just return it as is.
        // This prevents us having to re-instantiate a Carbon instance when we know
        // it already is one, which wouldn't be fulfilled by the DateTime check.
        if ($value instanceof CarbonInterface) {
            return Date::instance($value);
        }

        // If the value is already a DateTime instance, we will just skip the rest of
        // these checks since they will be a waste of time, and hinder performance
        // when checking the field. We will just return the DateTime right away.
        if ($value instanceof DateTimeInterface) {
            return Date::parse(
                $value->format('Y-m-d H:i:s.u'), $value->getTimezone()
            );
        }

        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and format a Carbon object from this timestamp. This allows flexibility
        // when defining your date fields as they might be UNIX timestamps here.
        if (is_numeric($value)) {
            return Date::createFromTimestamp($value, date_default_timezone_get());
        }

        // If the value is in simply year, month, day format, we will instantiate the
        // Carbon instances from that format. Again, this provides for simple date
        // fields on the database, while still supporting Carbonized conversion.
        if (self::isStandardDateFormat($value)) {
            return Date::instance(Carbon::createFromFormat('Y-m-d', $value)->startOfDay());
        }

        // Finally, we will just assume this date is in the format used by default on
        // the database connection and use that format to create the Carbon object
        // that is returned back out to the developers after we convert it here.
        try {
            $date = Date::createFromFormat($format, $value);
        } catch (InvalidArgumentException) {
            $date = false;
        }

        return $date ?: Date::parse($value);
    }

    /**
     * Determine if the given value is a standard date format.
     *
     * @param  string  $value
     * @return bool
     */
    public static function isStandardDateFormat(string $value): bool
    {
        return preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value);
    }
}
