<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestStepResult>
 */
class TestStepResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'based_on_test' => 'default',
            'blindness' => (bool) rand(0, 2),
            'low_vision' => (bool) rand(0, 2),
            'deafness' => (bool) rand(0, 2),
            'motor_impairment' => (bool) rand(0, 2),
            'learning_disability' => (bool) rand(0, 2),
            'neurodivergent' => (bool) rand(0, 2)
        ];
    }
}
