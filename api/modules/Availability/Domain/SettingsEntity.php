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
    private bool $isRecurring;

    public function __construct(SettingsId $id, UserId $userId, AvailabilityList $availabilityList, bool $isRecurring)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->availabilityList = $availabilityList;
        $this->isRecurring = $isRecurring;
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

    public function isRecurring(): bool
    {
        return $this->isRecurring;
    }
}