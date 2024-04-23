<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TestStep;
use App\Models\TestStepResult;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Workflow;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(25)->create();
        Project::factory(100)->create();
        Workflow::factory(1000)->create();
        TestStep::factory(10000)->create();
        TestStepResult::factory(40000)->create();
    }

}
