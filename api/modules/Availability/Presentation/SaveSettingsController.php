<?php

declare(strict_types=1);

namespace Modules\Availability\Presentation;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use Modules\Availability\Domain\DayEnum;
use Modules\Availability\Domain\SettingsRepositoryInterface;
use Modules\Availability\Domain\ValueObject\Time;

final class SaveSettingsController
{
    private SettingsRepositoryInterface $repository;
    private SettingsArrayTransformer $transformer;

    public function __construct(SettingsRepositoryInterface $repository, SettingsArrayTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'id' => ['required', 'uuid'],
            'user_id' => ['required', 'exists:users,id'],
            'availabilities' => ['required', 'array'],
            'availabilities.*.day' => ['required', new Enum(DayEnum::class)],
            'availabilities.*.time_interval' => ['required', 'array'],
            'availabilities.*.time_interval.start' => ['required', sprintf('regex:%s', Time::PATTERN)],
            'availabilities.*.time_interval.end' => ['required', sprintf('regex:%s', Time::PATTERN)],
        ]);

        try {
            $this->repository->save($this->transformer->fromArray($request->all()));
        } catch (\InvalidArgumentException $e) {
            throw ValidationException::withMessages(['*' => $e->getMessage()]);
        }

        return new JsonResponse();
    }
}