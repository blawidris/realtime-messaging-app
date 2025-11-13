<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachementRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

  
    public function rules(): array
    {
        return [
            //
        ];
    }
}
