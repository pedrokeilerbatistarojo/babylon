<?php

namespace App\Modules\Auth\Application\Usecases;

use App\Modules\Auth\Domain\Dtos\LoginResponse;
use App\Modules\Shared\Contracts\UsecaseInterface;
use App\Modules\Users\Domain\Models\User;
use App\Modules\Users\Domain\Resources\RoleResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RefreshTokenUsecase implements UsecaseInterface
{
    private ?User $user = null;

    public function execute(): ?LoginResponse
    {

        $user = $this->user;
        $user->save();

        $dto = new LoginResponse;
        $dto->id = $user->id;
        $dto->name = $user->name;
        $dto->username = $user->username;
        $dto->email = $user->email;
        $dto->token = Auth::refresh();
        $dto->role = new RoleResource($user->role);

        return $dto;
    }

    /**
     * @throws \Exception
     */
    public function setPayload(mixed $payload): void
    {
        if (! $payload instanceof User) {
            throw new \Exception('payload must be a instance of User');
        }

        $this->user = $payload;
    }
}
