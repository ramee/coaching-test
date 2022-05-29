<?php

declare(strict_types=1);

namespace Modules\Availability\Domain\ValueObject;

use Modules\Availability\Domain\DayEnum;

class Availability
{
    private DayEnum $day;
    private TimeInterval $timeInterval;

    public function __construct(DayEnum $day, TimeInterval $timeInterval)
    {
        $this->day = $day;
        $this->timeInterval = $timeInterval;
    }

    public function day(): DayEnum
    {
        return $this->day;
    }

    public function timeInterval(): TimeInterval
    {
        return $this->timeInterval;
    }
}
