<?php

declare(strict_types=1);

namespace Modules\Shared\Domain;

use Ramsey\Uuid\Uuid;

abstract class Id
{
    private Uuid $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }
}