<?php

declare(strict_types=1);

namespace Modules\User\Domain;

interface UserRepositoryInterface
{
    public function findAllCoaches(): UserList;
}