<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Project::query()->exists()) {
            return;
        }

        Project::factory()
            ->count(10)
            ->hasTasks(3)
            ->create();
    }
}
