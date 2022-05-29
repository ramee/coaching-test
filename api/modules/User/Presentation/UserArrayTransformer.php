<?php

declare(strict_types=1);

namespace Modules\User\Presentation;

use Modules\User\Domain\UserEntity;
use Modules\User\Domain\UserList;

final class UserArrayTransformer
{
    public function transformToArray(UserList $users): array
    {
        return array_map(static function(UserEntity $user): array {
            return [
                'id' => $user->id()->uuid()->toString(),
                'name' => $user->name()->name(),
            ];
        }, iterator_to_array($users));
    }
}