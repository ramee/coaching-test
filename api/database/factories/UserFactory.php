<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\User\Domain\RoleEnum;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'name' => $this->faker->name(),
            'role' => RoleEnum::Coach->value,
        ];
    }
}
