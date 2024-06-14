<?php

namespace Database\Seeders;

use App\Models\Forum\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Section::factory(10)->create();
    }
}
