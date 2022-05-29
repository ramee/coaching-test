<?php

declare(strict_types=1);

namespace Modules\Availability\Infrastructure;

use App\Models\AvailabilitySettings;
use JsonException;
use Modules\Availability\Domain\SettingsEntity;
use Modules\Availability\Domain\SettingsRepositoryInterface;
use Modules\User\Domain\ValueObject\UserId;

final class SettingsEloquentRepository implements SettingsRepositoryInterface
{
    private SettingsEloquentTransformer $transformer;

    public function __construct(SettingsEloquentTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @throws JsonException
     */
    public function findByUserId(UserId $userId): SettingsEntity
    {
        $model = AvailabilitySettings::where('user_id', $userId->uuid()->toString())->firstOrFail();

        return $this->transformer->transformToEntity($model);
    }
}