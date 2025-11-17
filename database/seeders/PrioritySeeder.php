<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Global Priorities (tenant_id = null for system-wide)
        $priorities = [
            [
                'name' => 'Low',
                'slug' => 'low',
                'color' => '#10B981', // Green
                'level' => 1,
            ],
            [
                'name' => 'Medium',
                'slug' => 'medium',
                'color' => '#3B82F6', // Blue
                'level' => 2,
            ],
            [
                'name' => 'High',
                'slug' => 'high',
                'color' => '#F59E0B', // Amber/Orange
                'level' => 3,
            ],
            [
                'name' => 'Urgent',
                'slug' => 'urgent',
                'color' => '#EF4444', // Red
                'level' => 4,
            ],
            [
                'name' => 'Critical',
                'slug' => 'critical',
                'color' => '#DC2626', // Dark Red
                'level' => 5,
            ],
        ];

        foreach ($priorities as $priority) {
            Priority::create($priority);
        }

        $this->command->info('✓ Global priorities created successfully!');
    }
}
