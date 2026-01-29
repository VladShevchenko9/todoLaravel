<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::factory()->create(['name' => Role::ADMIN]);
        Role::factory()->create(['name' => Role::USER]);
        User::factory()->create(['role_id' => $adminRole->id]);

        $users = User::factory(2)->create();

        $users->each(function ($user) {
            Task::factory(30)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
