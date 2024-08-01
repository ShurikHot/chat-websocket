<?php

namespace Database\Seeders;

use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create();
        $issetAdmin = User::query()->where('email', 'admin@admin.com')->exists();
        if (!$issetAdmin) {
            $admin = User::factory()->adminAccount()->create();
            $adminRole = Role::query()->create([
                'title' => 'Admin',
                'code' => 'Admin',
            ]);

            if ($admin && $adminRole) {
                $admin->roles()->toggle([
                    'role_id' => $adminRole->id,
                ]);
            }
        }
    }
}
