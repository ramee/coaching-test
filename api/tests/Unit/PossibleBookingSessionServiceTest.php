<?php

declare(strict_types=1);

namespace Tests\Unit;

use Modules\Availability\Domain\DayEnum;
use Modules\Availability\Domain\PossibleBookingSessionService;
use Modules\Availability\Domain\ValueObject\Availability;
use Modules\Availability\Domain\ValueObject\AvailabilityList;
use Modules\Availability\Domain\ValueObject\PossibleBookingSession;
use Modules\Availability\Domain\ValueObject\Time;
use Modules\Availability\Domain\ValueObject\TimeInterval;
use PHPUnit\Framework\TestCase;

class PossibleBookingSessionServiceTest extends TestCase
{
    private PossibleBookingSessionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PossibleBookingSessionService();
    }

    public function testGenerateRecurring_EmptyInput_EmptyOutput(): void
    {
        $possibleBookSessions = $this->service->generateRecurring(
            new AvailabilityList(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable('+2 days')
        );

        $this->assertCount(0, $possibleBookSessions);
    }

    public function testGenerateRecurring_OutOfDateRangeInput_EmptyOutput(): void
    {
        $possibleBookSessions = $this->service->generateRecurring(
            new AvailabilityList(
                new Availability(
                    DayEnum::Thursday,
                    new TimeInterval(
                        new Time('12:30'), new Time('13:15'),
                    ),
                ),
            ),
            new \DateTimeImmutable('2022-05-30 05:40'),
            new \DateTimeImmutable('2022-06-01 01:40')
        );

        $this->assertCount(0, $possibleBookSessions);
    }

    public function testGenerateRecurring_InDate2WeeksRangeInput_ListOutput(): void
    {
        $possibleBookSessions = $this->service->generateRecurring(
            new AvailabilityList(
                new Availability(
                    DayEnum::Monday,
                    new TimeInterval(
                        new Time('08:00'), new Time('14:00'),
                    ),
                ),
                new Availability(
                    DayEnum::Monday,
                    new TimeInterval(
                        new Time('16:00'), new Time('18:00'),
                    ),
                ),
                new Availability(
                    DayEnum::Thursday,
                    new TimeInterval(
                        new Time('08:00'), new Time('18:00'),
                    ),
                ),
            ),
            new \DateTimeImmutable('2022-06-01 01:00'),
            new \DateTimeImmutable('2022-06-15 01:40')
        );

        $this->assertCount(6, $possibleBookSessions);

        $expectedBookingDates = [
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-06 08:00'),
                new \DateTimeImmutable('2022-06-06 14:00')
            ),
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-06 16:00'),
                new \DateTimeImmutable('2022-06-06 18:00')
            ),
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-02 08:00'),
                new \DateTimeImmutable('2022-06-02 18:00')
            ),
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-13 08:00'),
                new \DateTimeImmutable('2022-06-13 14:00')
            ),
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-13 16:00'),
                new \DateTimeImmutable('2022-06-13 18:00')
            ),
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-09 08:00'),
                new \DateTimeImmutable('2022-06-09 18:00')
            ),
        ];

        foreach ($expectedBookingDates as $index => $bookingSession) {
            $this->assertEquals($bookingSession->start()->format('Y-m-d H:i'), $possibleBookSessions[$index]->start()->format('Y-m-d H:i'));
            $this->assertEquals($bookingSession->end()->format('Y-m-d H:i'), $possibleBookSessions[$index]->end()->format('Y-m-d H:i'));
        }
    }

    public function testGenerateOne_WithInput_ListOutput(): void
    {
        $possibleBookSessions = $this->service->generateOne(
            new AvailabilityList(
                new Availability(
                    DayEnum::Wednesday,
                    new TimeInterval(
                        new Time('05:20'), new Time('12:33'),
                    ),
                ),
                new Availability(
                    DayEnum::Friday,
                    new TimeInterval(
                        new Time('08:00'), new Time('16:00'),
                    ),
                ),
                new Availability(
                    DayEnum::Saturday,
                    new TimeInterval(
                        new Time('08:00'), new Time('18:00'),
                    ),
                ),
            ),
            new \DateTimeImmutable('2022-05-30 01:00')
        );

        $expectedBookingDates = [
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-01 05:20'),
                new \DateTimeImmutable('2022-06-01 12:33')
            ),
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-03 08:00'),
                new \DateTimeImmutable('2022-06-03 16:00')
            ),
            new PossibleBookingSession(
                new \DateTimeImmutable('2022-06-04 08:00'),
                new \DateTimeImmutable('2022-06-04 18:00')
            ),
        ];

        foreach ($expectedBookingDates as $index => $bookingSession) {
            $this->assertEquals($bookingSession->start()->format('Y-m-d H:i'), $possibleBookSessions[$index]->start()->format('Y-m-d H:i'));
            $this->assertEquals($bookingSession->end()->format('Y-m-d H:i'), $possibleBookSessions[$index]->end()->format('Y-m-d H:i'));
        }
    }
}
