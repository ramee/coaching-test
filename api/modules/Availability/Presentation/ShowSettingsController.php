<?php

declare(strict_types=1);

namespace Modules\Availability\Presentation;

use Illuminate\Http\JsonResponse;
use Modules\Availability\Domain\SettingsRepositoryInterface;
use Modules\User\Domain\ValueObject\UserId;

class ShowSettingsController
{
    private SettingsRepositoryInterface $repository;

    public function __construct(SettingsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $userId): JsonResponse
    {
        $userId = UserId::createFromString($userId);
        $settingsEntity = $this->repository->findByUserId($userId);

        return new JsonResponse(new SettingsJsonTransformer($settingsEntity));
    }
}