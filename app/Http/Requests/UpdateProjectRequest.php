<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'sometimes|exists:statuses,id',
            'parent_id' => 'nullable|exists:projects,id',
            'start_at' => 'nullable|date',
            'due_at' => 'nullable|date|after_or_equal:start_at',
            'meta' => 'nullable|array',
        ];
    }
}
