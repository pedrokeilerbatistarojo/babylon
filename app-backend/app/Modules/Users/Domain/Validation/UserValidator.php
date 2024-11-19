<?php

namespace App\Modules\Users\Domain\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as FacadeValidator;

class UserValidator
{
    public static function getValidator(array $input): Validator
    {

        $filter = '';
        $isUpdate = isset($input['user_id']);

        if ($isUpdate) {
            $filter = ','.intval($input['user_id']);
        }

        $rules = [
            'name' => 'required|string|max:255|regex:/^[a-z][a-z0-9_-]+$/|unique:users,name'.$filter,
            'email' => 'required|string|email|max:255|unique:users,email'.$filter,
            'phone' => 'required|string|max:255|unique:users,phone'.$filter, //todo: validate number
            'role_id' => 'required|int|exists:roles,id',
            'password' => 'required|string|min:6',
        ];

        if ($isUpdate) {
            $rules['user_id'] = 'nullable|int|exists:users,id';
            $rules['password'] = 'sometimes|string|min:6';
            unset($rules['role_id']);
        }

        return FacadeValidator::make($input, $rules);
    }
}
