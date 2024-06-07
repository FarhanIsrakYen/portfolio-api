<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateRoleRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','max:255'],
        ];
    }
}
