<?php

namespace App\Auth\Application\Usecases;

use App\Auth\Domain\Dtos\LoginResponse;
use App\Shared\Domain\Exceptions\ValidationException;
use App\Users\Domain\Models\User;
use App\Users\Domain\Resources\RoleResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class RegisterUsecase
{
    /**
     * @throws ValidationException
     */
    public function execute(array $input): ?LoginResponse
    {

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors);
        }

        $name = $input['name'];
        $email = $input['email'];
        $password = $input['password'];

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $token = Auth::login($user);
        $dto = new LoginResponse;
        $dto->id = $user->id;
        //$dto->name = $user->name;
        $dto->username = $user->username;
        $dto->email = $user->email;
        $dto->token = $token;
        $dto->role = new RoleResource($user->role);

        return $dto;
    }
}
