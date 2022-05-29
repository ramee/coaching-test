<?php

declare(strict_types=1);

namespace Modules\Availability\Domain;

use Modules\Availability\Domain\ValueObject\AvailabilityList;
use Modules\Availability\Domain\ValueObject\SettingsId;
use Modules\User\Domain\ValueObject\UserId;

final class SettingsEntity
{
    private SettingsId $id;
    private UserId $userId;
    private AvailabilityList $availabilityList;

    public function __construct(SettingsId $id, UserId $userId, AvailabilityList $availabilityList)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->availabilityList = $availabilityList;
    }

    public function id(): SettingsId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function availabilityList(): AvailabilityList
    {
        return $this->availabilityList;
    }
}