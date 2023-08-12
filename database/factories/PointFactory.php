<?php

namespace Database\Factories;

use App\Models\Point;
use App\Models\Member;
use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Point>
 */
class PointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => function () {
                return Member::query()
                    ->inRandomOrder()
                    ->value('id');
            },
            'institution_id' => function () {
                return Institution::query()
                    ->inRandomOrder()
                    ->value('id');
            },
            'points_earned' => $this->faker->numberBetween(1, 100),
            'transaction_date' => $this->faker->dateTimeBetween(now()->subYears(), now()),
        ];
    }
}
