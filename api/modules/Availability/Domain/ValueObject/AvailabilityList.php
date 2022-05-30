<?php

declare(strict_types=1);

namespace Modules\Availability\Domain\ValueObject;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<Availability>
 */
class AvailabilityList implements IteratorAggregate, Countable
{
    /** @var Availability[] */
    private array $availabilities;

    public function __construct(Availability ...$availabilities)
    {
        $this->availabilities = $availabilities;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->availabilities);
    }

    public function count(): int
    {
        return count($this->availabilities);
    }
}