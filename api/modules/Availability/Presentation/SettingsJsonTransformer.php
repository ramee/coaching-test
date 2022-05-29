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
            'availabilities' => array_map(static function (Availability $availability) {
                return [
                    'day' => $availability->day()->value,
                    'start' => $availability->timeInterval()->start()->time(),
                    'end' => $availability->timeInterval()->end()->time(),
                ];
            }, $this->entity->availabilityList()->availabilities()),
        ];
    }
}