<?php

namespace App\Http\Requests;

class UpdateUserRequest extends AbstractRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['max:255'],
            'email' => ['max:255', 'unique:users,email','email:filter'],
            'password' => ['min:8'],
            'address' => ['max:255'],
            'website' => ['max:255'],
            'dob' => ['max:255']
        ];
    }
}
