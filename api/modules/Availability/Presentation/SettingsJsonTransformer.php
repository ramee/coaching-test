<?php

declare(strict_types=1);

namespace Modules\Availability\Presentation;

use Modules\Availability\Domain\SettingsEntity;
use Modules\Availability\Domain\ValueObject\Availability;

final class SettingsJsonTransformer implements \JsonSerializable
{
    private SettingsEntity $entity;

    public function __construct(SettingsEntity $entity)
    {
        $this->entity = $entity;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->entity->id()->uuid()->toString(),
            'user_id' => $this->entity->userId()->uuid()->toString(),
            'availability_list' => array_map(function (Availability $availability) {
                return [
                    'day' => $availability->day()->value,
                    'start_time' => $availability->timeInterval()->start()->time(),
                    'end_time' => $availability->timeInterval()->end()->time(),
                ];
            }, $this->entity->availabilityList()->availabilities()),
        ];
    }
}