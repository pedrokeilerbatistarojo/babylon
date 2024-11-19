<?php

namespace App\Modules\Shared\Domain\Validation;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FloatValidation implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (filter_var($value, FILTER_VALIDATE_FLOAT) === false) {
            $fail('The :attribute must be a float number.');
        }

        /*if($value < 0){
            $fail('The :attribute must be a positive number.');
        }*/
    }
}
