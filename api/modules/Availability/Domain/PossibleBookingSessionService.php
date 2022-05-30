<?php

declare(strict_types=1);

namespace Modules\Availability\Domain;

use DateTimeImmutable;
use Exception;
use Modules\Availability\Domain\ValueObject\AvailabilityList;
use Modules\Availability\Domain\ValueObject\PossibleBookingSession;

final class PossibleBookingSessionService
{
    /**
     * @return PossibleBookingSession[]
     * @throws Exception
     */
    public function generateRecurring(
        AvailabilityList $availabilityList,
        DateTimeImmutable $from,
        DateTimeImmutable $to
    ): array {
        if (count($availabilityList) === 0) {
            return [];
        }

        $possibleBookingSessions = [];

        $clonedFrom = clone $from;

        while ($clonedFrom < $to) {
            foreach ($availabilityList as $availability) {
                $nextStartDate = $clonedFrom->modify(
                    sprintf(
                        'next %s %s',
                        $availability->day()->value,
                        $availability->timeInterval()->start()->time(),
                    )
                );
                $nextEndDate = $clonedFrom->modify(
                    sprintf(
                        'next %s %s',
                        $availability->day()->value,
                        $availability->timeInterval()->end()->time(),
                    )
                );

                if ($nextEndDate <= $to) {
                    $possibleBookingSessions[] = new PossibleBookingSession($nextStartDate, $nextEndDate);
                }
            }

            $clonedFrom = $clonedFrom->modify('+1 week');
        }

        return $possibleBookingSessions;
    }
}