<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' => ['required','max:255', 'unique:users,email','email:filter'],
            'password' => ['required','min:8'],
            'phone' => ['required','max:255', 'unique:users'],
            'address' => ['required','max:255'],
            'website' => 'max:255',
            'dob' => ['required','max:255'],
            'objective' => 'required',
            'roles' => 'required',
            'isActive' => 'boolean',
            'interests' => 'max:1000'
        ];
    }
}