<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Domain\RoleEnum;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'role' => RoleEnum::Coach->value,
        ];
    }
}
