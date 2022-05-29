<?php

declare(strict_types=1);

namespace Modules\User\Domain;

use Traversable;

final class UserList implements \IteratorAggregate
{
    /** @var UserEntity[] $users */
    private array $users;

    public function __construct(UserEntity ...$users)
    {
        $this->users = $users;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->users);
    }
}