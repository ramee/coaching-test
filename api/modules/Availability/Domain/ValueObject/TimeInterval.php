<?php

declare(strict_types=1);

namespace Modules\Availability\Domain\ValueObject;

class TimeInterval
{
    private Time $start;
    private Time $end;

    public function __construct(Time $start, Time $end)
    {
        $this->assertValues($start, $end);
        $this->start = $start;
        $this->end = $end;
    }

    public function start(): Time
    {
        return $this->start;
    }

    public function end(): Time
    {
        return $this->end;
    }

    private function assertValues(Time $start, Time $end): void
    {
        if (!$start->earlierThan($end)) {
            throw new \InvalidArgumentException(sprintf('%s must be earlier than %s', $start->time(), $end->time()));
        }
    }
}
