<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $branch_id = Branch::query()->inRandomOrder()->first()->id;

        return [
            'title' => fake()->text(50),
            'description' =>  fake()->text(100),
            'branch_id' => $branch_id,
        ];
    }
}
