<?php

namespace Database\Seeders;

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
