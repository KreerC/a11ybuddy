<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestStep>
 */
class TestStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'workflow_id' => mt_rand(1, 100),
            'name' => fake()->unique()->sentence(),
            'description' => fake()->sentence(),
            'test_step_result_id' => null
        ];
    }
}
