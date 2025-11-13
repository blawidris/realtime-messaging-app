<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartConversationRequest extends FormRequest
{
  protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           "type" => "sometimes|string|in:private,group",
           "name" => "sometimes|required_if:type,group|string|max:255",
           "description" => "sometimes|nullable|string",
           "avatar" => "sometimes|nullable|string|max:255",
           "participant_ids" => "required|array|min:1",
           "participant_ids.*" => "integer|exists:users,id",
        ];
    }
}
