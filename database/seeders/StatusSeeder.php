<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            // System-level statuses
            ['name' => 'Pending', 'type' => 'system'],
            ['name' => 'Active', 'type' => 'system'],
            ['name' => 'Inactive', 'type' => 'system'],
            ['name' => 'Suspended', 'type' => 'system'],

            // User presence statuses
            ['name' => 'Online', 'type' => 'user'],
            ['name' => 'Offline', 'type' => 'user'],
            ['name' => 'Busy', 'type' => 'user'],
            ['name' => 'Away', 'type' => 'user'],

            // Message statuses
            ['name' => 'Sent', 'type' => 'message'],
            ['name' => 'Delivered', 'type' => 'message'],
            ['name' => 'Read', 'type' => 'message'],
            ['name' => 'Failed', 'type' => 'message'],

            // Project statuses
            [
                'name' => 'Planned',
                'slug' => 'planned',
                'type' => 'project',

            ],
            [
                'name' => 'In Progress',
                'slug' => 'in_progress',
                'type' => 'project',

            ],
            [
                'name' => 'On Hold',
                'slug' => 'on_hold',
                'type' => 'project',

            ],
            [
                'name' => 'Review',
                'slug' => 'review',
                'type' => 'project',

            ],
            [
                'name' => 'Completed',
                'slug' => 'completed',
                'type' => 'project',

            ],
            [
                'name' => 'Cancelled',
                'slug' => 'cancelled',
                'type' => 'project',

            ],
            [
                'name' => 'Archived',
                'slug' => 'archived',
                'type' => 'project',
            ],

            // task statuses
             [
                'name' => 'To Do',
                'slug' => 'todo',
                'type' => 'task',

            ],
            [
                'name' => 'In Progress',
                'slug' => 'in_progress',
                'type' => 'task',

            ],
            [
                'name' => 'In Review',
                'slug' => 'in_review',
                'type' => 'task',

            ],
            [
                'name' => 'Blocked',
                'slug' => 'blocked',
                'type' => 'task',

            ],
            [
                'name' => 'Testing',
                'slug' => 'testing',
                'type' => 'task',

            ],
            [
                'name' => 'Done',
                'slug' => 'done',
                'type' => 'task',

            ],
            [
                'name' => 'Cancelled',
                'slug' => 'cancelled',
                'type' => 'task',
            ],

        ];

        foreach ($statuses as $status) {
            DB::table('statuses')->updateOrInsert(
                ['slug' => Str::slug($status['name'])],
                [
                    'name' => $status['name'],
                    'slug' => Str::slug($status['name']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

      
    }
}
