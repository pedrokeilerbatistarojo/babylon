<?php

namespace App\Shared\Contracts\User;

interface UserServiceInterface
{
    public function register(array $userData): bool;

    public function updateUser(int $userId, array $newUserData): bool;

    public function deleteUser(int $userId): bool;
}
