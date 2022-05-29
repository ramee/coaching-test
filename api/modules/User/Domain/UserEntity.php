<?php

declare(strict_types=1);

namespace Modules\User\Domain;

use Modules\User\Domain\ValueObject\Name;
use Modules\User\Domain\ValueObject\UserId;

final class UserEntity
{
    private UserId $id;
    private Name $name;

    public function __construct(UserId $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }


}