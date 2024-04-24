<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TestStep;
use App\Models\TestStepResult;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Workflow;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(25)->has(Project::factory()->has(Workflow::factory()->has(TestStep::factory()->has(TestStepResult::factory()->count(1))->count(mt_rand(3, 6)))->count(mt_rand(2, 5)))->count(mt_rand(1, 3)))->create();

        // Make an admin user
        User::factory()->create([
            'username' => 'admin',
            'display_name' => 'Adminis Trator',
            'email' => 'admin@admin.invalid',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'is_admin' => true,
            'verified' => true,
        ]);
    }

}
