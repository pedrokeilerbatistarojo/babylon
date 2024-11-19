<?php

namespace App\Modules\Auth\Domain\Dtos;

use App\Modules\Users\Domain\Resources\RoleResource;

class LoginResponse
{
    public int $id = -1;

    public string $name = '';

    public string $username = '';

    public string $email = '';

    public mixed $token = '';

    public ?RoleResource $role;

    //public string $accessToken  = '';

    //public string $refreshToken  = '';

    public mixed $last_login = null;
}
