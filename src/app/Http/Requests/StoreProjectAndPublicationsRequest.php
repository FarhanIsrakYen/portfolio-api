<?php

namespace App\Http\Requests;

class StoreProjectAndPublicationsRequest extends AbstractRequest
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
            'name' => ['required','max:255','string'],
            'category' => ['required','in:official,personal'],
            'startedAt' => ['required','string'],
            'endedAt' => ['required','string'],
            'link' => ['required','string'],
            'technologies_used' => ['required','array'],
            'description' => ['required'],
            'images' => ['required','array'],
        ];
    }
}
