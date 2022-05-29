<?php

declare(strict_types=1);

namespace Modules\Availability\Infrastructure;

use App\Models\AvailabilitySettings;
use JsonException;
use Modules\Availability\Domain\SettingsEntity;
use Modules\Availability\Domain\ValueObject\Availability;
use Modules\Availability\Domain\ValueObject\AvailabilityList;
use Modules\Availability\Domain\ValueObject\SettingsId;
use Modules\Availability\Domain\ValueObject\Time;
use Modules\Availability\Domain\ValueObject\TimeInterval;
use Modules\User\Domain\ValueObject\UserId;
use Ramsey\Uuid\Uuid;

final class SettingsEloquentTransformer
{
    /**
     * @throws JsonException
     */
    public function transformToEntity(AvailabilitySettings $availabilitySettings): SettingsEntity
    {
        return new SettingsEntity(
            new SettingsId(Uuid::fromString($availabilitySettings->id)),
            new UserId(Uuid::fromString($availabilitySettings->user_id)),
            new AvailabilityList(...array_map(static function (object $availabilityData): Availability {
                return new Availability(
                    $availabilityData->day,
                    new TimeInterval(
                        new Time($availabilityData->timeInterval->start),
                        new Time($availabilityData->timeInterval->end),
                    )
                );
            }, json_decode($availabilitySettings->availabilities, false, 512, JSON_THROW_ON_ERROR))),
        );
    }
}