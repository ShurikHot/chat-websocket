<?php

namespace Database\Seeders;

use App\Models\Forum\Branch;
use Database\Factories\Forum\BranchFactory;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::factory(10)->create();
        Branch::factory()->modifyParent();
    }
}
