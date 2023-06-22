<?php

namespace Database\Factories;

use Domain\Catalog\Models\Option;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Option>
 */
class OptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word())
        ];
    }
}
