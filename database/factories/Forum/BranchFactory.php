<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Branch;
use App\Models\Forum\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $section_id = Section::query()->inRandomOrder()->first()->id;

        return [
            'section_id' => $section_id,
            'parent_id' => null,
            'title' => fake()->text(50),
        ];
    }

    public function modifyParent()
    {
        $branches = Branch::query()->inRandomOrder()->limit(5)->get();
        foreach ($branches as $branch) {
            $branch->update([
                'parent_id' => Branch::query()->where('id', '!=', $branch->id)->inRandomOrder()->first()->id
            ]);
            $branch->save();
        }
    }
}
