<?php

declare(strict_types=1);

namespace Modules\Availability\Domain;

use Modules\Availability\Domain\ValueObject\Availability;
use Modules\Availability\Domain\ValueObject\AvailabilityUserSettingsId;
use Modules\User\Domain\ValueObject\UserId;

final class AvailabilityUserSettings
{
    private AvailabilityUserSettingsId $id;
    private UserId $userId;
    private Availability $availability;

    public function __construct(AvailabilityUserSettingsId $id, UserId $userId, Availability $availability)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->availability = $availability;
    }

    public function id(): AvailabilityUserSettingsId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function availability(): Availability
    {
        return $this->availability;
    }
}