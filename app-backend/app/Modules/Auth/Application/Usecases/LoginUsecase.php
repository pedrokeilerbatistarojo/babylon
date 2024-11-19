<?php

namespace App\Modules\Auth\Application\Usecases;

use App\Modules\Auth\Domain\Dtos\LoginResponse;
use App\Modules\Shared\Application\Usecases\TraitHandleResponsePayload;
use App\Modules\Shared\Domain\Exceptions\ValidationException;
use App\Modules\Users\Domain\Models\User;
use App\Modules\Users\Domain\Resources\RoleResource;
use App\Modules\Shared\Contracts\UsecaseInterface;
use Illuminate\Support\Facades\Validator;

class LoginUsecase implements UsecaseInterface
{
    use TraitHandleResponsePayload;

    public function __construct() {}

    /**
     * @throws ValidationException
     * @throws \Exception
     */
    public function execute(): LoginResponse
    {

        $input = $this->payload;

        $validator = Validator::make($input, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors);
        }

        $username = $input['username'];
        $password = $input['password'];

        $token = auth('api')->attempt([
            'username' => $username,
            'password' => $password,
        ]);

        if (! $token) {
            throw new \Exception('Invalid credentials');
        }

        $user = User::query()->where([
            ['username', '=', $username],
            ['enabled', '=', true],
        ])->first();

        if (! $user) {
            throw new \Exception('Invalid user');
        }

//        $user->last_login = Carbon::now();
//        $user->save();

        $dto = new LoginResponse();
        $dto->id = $user->id;
        $dto->name = $user->name;
        $dto->username = $user->username;
        $dto->email = $user->email;
        $dto->token = $token;
        $dto->role = new RoleResource($user->role);

        return $dto;
    }

    public function setPayload(mixed $payload): void
    {
        if (is_array($payload)) {
            $this->payload = $payload;
        }
    }
}
