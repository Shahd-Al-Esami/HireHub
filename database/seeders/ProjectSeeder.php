<?php

namespace Database\Seeders;

use App\Enums\BudgetTypeEnum;
use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = User::where('role', 'client')->first();

        Project::create([
            'client_id' => $client->id,
            'status' => ProjectStatusEnum::OPEN,
            'budget_type' => BudgetTypeEnum::FIXED,
            'title' => 'E-commerce Website Development',
            'description' => 'Build an e-commerce website with Laravel and Vue.js',
            'delivery_date' => '2026-12-31',
            'budget_amount' => '1000',
        ]);
    }
}
