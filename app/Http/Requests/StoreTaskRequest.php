<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{

     protected $stopOnFirstFailure = true;
     
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'nullable|exists:projects,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:statuses,id',
            'priority_id' => 'nullable|exists:priorities,id',
            'due_at' => 'nullable|date',
            'estimated_hours' => 'nullable|integer|min:0',
            'assignees' => 'nullable|array',
            'assignees.*' => 'exists:users,id',
            'metadata' => 'nullable|array',
        ];
    }
}
