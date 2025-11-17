<?php

namespace Tests\Feature;

use App\Models\{Comment, Task, User, Tenant, Project};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_comment_on_task()
    {
        $user = User::factory()->create();
        // $tenant = Tenant::factory()->create();
        $user->tenants()->attach($tenant->id);

        $project = Project::factory()->create();
        $project->members()->attach($user->id);

        $task = Task::factory()->create([
            // 'tenant_id' => $tenant->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson("/api/tasks/{$task->id}/comments", [
                'content' => 'This is a test comment',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'content', 'user']
            ]);

        $this->assertDatabaseHas('comments', [
            'commentable_type' => Task::class,
            'commentable_id' => $task->id,
            'content' => 'This is a test comment',
        ]);
    }

    public function test_user_can_reply_to_comment()
    {
        $user = User::factory()->create();
        // $tenant = Tenant::factory()->create();
        // $user->tenants()->attach($tenant->id);

        $project = Project::factory()->create();
        $project->members()->attach($user->id);

        $task = Task::factory()->create([
            // 'tenant_id' => $tenant->id,
            'project_id' => $project->id,
        ]);

        $comment = Comment::factory()->create([
            // 'tenant_id' => $tenant->id,
            'commentable_type' => Task::class,
            'commentable_id' => $task->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson("/api/comments/{$comment->id}/reply", [
                'content' => 'This is a reply',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('comments', [
            'parent_id' => $comment->id,
            'content' => 'This is a reply',
        ]);
    }
}
