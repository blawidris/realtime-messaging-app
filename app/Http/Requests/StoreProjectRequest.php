<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true; // Handle in controller with policies
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'parent_id' => 'nullable|exists:projects,id',
            'start_at' => 'nullable|date',
            'due_at' => 'nullable|date|after_or_equal:start_at',
            'meta' => 'nullable|array',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
        ];
    }


    public function prepareForValidation()
    {
        $slug =  null;

        if ($this->name) {
            $slug = \Illuminate\Support\Str::slug($this->name);
        }

        return $this->merge(['slug' => $slug]);
    }
}
