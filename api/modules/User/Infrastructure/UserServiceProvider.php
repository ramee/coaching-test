<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Modules\User\Domain\UserRepositoryInterface;

final class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
    }
}