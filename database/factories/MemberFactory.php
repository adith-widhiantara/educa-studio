<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

use function now;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'join_date' => $this->faker->date,
            'gender' => $this->faker->randomElement(['L', 'P']),
            'birth_date' => $this->faker->dateTimeBetween(now()->subYears(20), now()->subYears(10)),
        ];
    }
}
