<?php

declare(strict_types=1);

namespace Modules\Availability\Domain;

use Modules\User\Domain\ValueObject\UserId;

interface SettingsRepositoryInterface
{
    public function findByUserId(UserId $userId): SettingsEntity;

    public function save(SettingsEntity $entity): void;
}
