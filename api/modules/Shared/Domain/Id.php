<?php

declare(strict_types=1);

namespace Modules\Shared\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class Id
{
    private UuidInterface $uuid;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public static function createFromString(string $uuidRaw): static
    {
        $uuid = Uuid::fromString($uuidRaw);

        return new static($uuid);
    }
}