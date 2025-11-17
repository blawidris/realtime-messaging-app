<?php

namespace Tests\Feature;

use App\Models\{Project, User, Tenant, Status};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_project()
    {
        $user = User::factory()->create();
        // $tenant = Tenant::factory()->create();
        // $user->tenants()->attach($tenant->id, ['role' => 'admin']);
        // $status = Status::factory()->create(['type' => 'project']);

        $response = $this->actingAs($user)
            ->postJson('/api/projects', [
                'name' => 'Test Project',
                'description' => 'Test description',
                'status_id' => Status::getId("planned"),
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'name', 'slug']
            ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'Test Project',
            // 'tenant_id' => $tenant->id,
        ]);
    }

    public function test_user_cannot_view_project_from_different_tenant()
    {
        $user = User::factory()->create();
        // $tenant1 = Tenant::factory()->create();
        // $tenant2 = Tenant::factory()->create();

        // $user->tenants()->attach();
        $project = Project::factory()->create();

        $response = $this->actingAs($user)
            ->getJson("/api/projects/{$project->id}");

        $response->assertStatus(403);
    }
}
