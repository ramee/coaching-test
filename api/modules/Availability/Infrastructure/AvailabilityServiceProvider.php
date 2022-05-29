<?php

declare(strict_types=1);

namespace Modules\Availability\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Modules\Availability\Domain\SettingsRepositoryInterface;

final class AvailabilityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SettingsRepositoryInterface::class, SettingsEloquentRepository::class);
    }

    public function boot(): void
    {
        //
    }
}