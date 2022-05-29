<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure;

use App\Models\User;
use Modules\User\Domain\RoleEnum;
use Modules\User\Domain\UserEntity;
use Modules\User\Domain\UserList;
use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Domain\ValueObject\Name;
use Modules\User\Domain\ValueObject\UserId;
use Ramsey\Uuid\Uuid;

final class UserEloquentRepository implements UserRepositoryInterface
{
    public function findAllCoaches(): UserList
    {
        $users = User::where('role', RoleEnum::Coach->value)->get()->transform(static function (User $model): UserEntity {
            return new UserEntity(
                new UserId(Uuid::fromString($model->id)),
                new Name($model->name),
            );
        });

        return new UserList(...$users);
    }
}