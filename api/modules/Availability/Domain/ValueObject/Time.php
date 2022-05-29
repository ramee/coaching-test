<?php

declare(strict_types=1);

namespace Modules\Availability\Domain\ValueObject;

final class Time
{
    public const PATTERN = '/^(([0-1]\d|2[0-3]):[0-5]\d(:[0-5]\d)?)$/';
    private string $time;

    public function __construct(string $time)
    {
        $this->assertValue($time);
        $this->time = $time;
    }

    public function time(): string
    {
        return $this->time;
    }

    public function earlierThan(Time $anotherTime): bool
    {
        return $this->time() < $anotherTime->time();
    }

    private function assertValue(string $time): void
    {
        if (!preg_match(self::PATTERN, $time)) {
            throw new \InvalidArgumentException(sprintf('%s is invalid time', $time));
        }
    }
}
