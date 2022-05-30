<?php

declare(strict_types=1);

namespace Modules\Availability\Presentation;

use Modules\Availability\Domain\DayEnum;
use Modules\Availability\Domain\SettingsEntity;
use Modules\Availability\Domain\ValueObject\Availability;
use Modules\Availability\Domain\ValueObject\AvailabilityList;
use Modules\Availability\Domain\ValueObject\SettingsId;
use Modules\Availability\Domain\ValueObject\Time;
use Modules\Availability\Domain\ValueObject\TimeInterval;
use Modules\User\Domain\ValueObject\UserId;
use Ramsey\Uuid\Uuid;

final class SettingsArrayTransformer
{
    public function toArray(SettingsEntity $entity): array
    {
        return [
            'id' => $entity->id()->uuid()->toString(),
            'user_id' => $entity->userId()->uuid()->toString(),
            'availabilities' => array_map(static function (Availability $availability) {
                return [
                    'day' => $availability->day()->value,
                    'time_interval' => [
                        'start' => $availability->timeInterval()->start()->time(),
                        'end' => $availability->timeInterval()->end()->time(),
                    ],
                ];
            }, iterator_to_array($entity->availabilityList())),
            'is_recurring' => $entity->isRecurring(),
        ];
    }

    public function fromArray(array $data): SettingsEntity
    {
        return new SettingsEntity(
            new SettingsId(Uuid::fromString($data['id'])),
            new UserId(Uuid::fromString($data['user_id'])),
            new AvailabilityList(...array_map(static function (array $availabilityData): Availability {
                return new Availability(
                    DayEnum::from($availabilityData['day']),
                    new TimeInterval(
                        new Time($availabilityData['time_interval']['start']),
                        new Time($availabilityData['time_interval']['end']),
                    ),
                );
            }, $data['availabilities'])),
            $data['is_recurring'],
        );
    }
}