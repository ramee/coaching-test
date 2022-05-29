<?php

declare(strict_types=1);

namespace Modules\User\Presentation;

use Illuminate\Http\JsonResponse;
use Modules\User\Domain\UserRepositoryInterface;

final class ListController
{
    private UserRepositoryInterface $repository;
    private UserArrayTransformer $transformer;

    public function __construct(UserRepositoryInterface $repository, UserArrayTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    public function __invoke(): JsonResponse
    {
        $userList = $this->repository->findAll();

        return new JsonResponse($this->transformer->transformToArray($userList));
    }
}