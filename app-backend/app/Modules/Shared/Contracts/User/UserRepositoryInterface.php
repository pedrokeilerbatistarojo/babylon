<?php

namespace App\Shared\Contracts\User;

use App\Users\Domain\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByUsername(string $username): ?User;

    public function findAll(): Collection;

    public function save(User $user): bool;

    public function delete(User $user): bool;
}
