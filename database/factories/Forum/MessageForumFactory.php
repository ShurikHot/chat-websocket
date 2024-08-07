<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MessageForumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::query()->inRandomOrder()->first()->id;

        return [
            'user_id' => $user_id,
            'content' => fake()->text(150),
            'theme_id' => ''
        ];
    }

    public function forTheme($theme_id){
        return $this->state([
            'theme_id' => $theme_id
        ]);
    }
}
