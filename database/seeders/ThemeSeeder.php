<?php

namespace Database\Seeders;

use App\Models\Forum\MessageForum;
use App\Models\Forum\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = Theme::factory(10)->create();

        $themes->each(function ($theme) {
            MessageForum::factory()
                ->count(20)
                ->forTheme($theme->id)
                ->create()
            ;
        });
    }
}
