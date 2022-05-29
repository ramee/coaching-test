<?php

declare(strict_types=1);

namespace Modules\Availability\Infrastructure;

use App\Models\AvailabilitySettings;
use JsonException;
use Modules\Availability\Domain\DayEnum;
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
    public function transformToEntity(AvailabilitySettings $model): SettingsEntity
    {
        return new SettingsEntity(
            new SettingsId(Uuid::fromString($model->id)),
            new UserId(Uuid::fromString($model->user_id)),
            new AvailabilityList(
                ...array_map(static function (object $availabilityData): Availability {
                    return new Availability(
                        DayEnum::from($availabilityData->day),
                        new TimeInterval(
                            new Time($availabilityData->time_interval->start),
                            new Time($availabilityData->time_interval->end),
                        )
                    );
                }, json_decode($model->availabilities, false, 512, JSON_THROW_ON_ERROR))
            ),
            $model->is_recurring,
        );
    }

    /**
     * @throws JsonException
     */
    public function transformToModel(SettingsEntity $entity, AvailabilitySettings $model): AvailabilitySettings
    {
        $model->id = $entity->id()->uuid()->toString();
        $model->user_id = $entity->userId()->uuid()->toString();
        $model->is_recurring = $entity->isRecurring();
        $availabilities = array_map(static function (Availability $availability) {
            return [
                'day' => $availability->day()->value,
                'time_interval' => [
                    'start' => $availability->timeInterval()->start()->time(),
                    'end' => $availability->timeInterval()->end()->time(),
                ],
            ];
        }, $entity->availabilityList()->availabilities());

        $model->availabilities = json_encode($availabilities, JSON_THROW_ON_ERROR);

        return $model;
    }
}