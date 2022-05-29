<?php

declare(strict_types=1);

namespace Modules\User\Domain\ValueObject;

final class Name
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}