<?php

declare(strict_types=1);

namespace Modules\Availability\Domain\ValueObject;

class AvailabilityList
{
    /** @var Availability[] */
    private array $availabilities;

    public function __construct(Availability ...$availabilities)
    {
        $this->availabilities = $availabilities;
    }

    public function availabilities(): array
    {
        return $this->availabilities;
    }
}