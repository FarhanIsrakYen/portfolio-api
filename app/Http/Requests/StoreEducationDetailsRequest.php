<?php

namespace App\Http\Requests;

class StoreEducationDetailsRequest extends AbstractRequest
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
            'title' => ['required','max:255','string'],
            'institution' => ['required','string'],
            'startedAt' => ['required','integer'],
            'endedAt' => ['required','integer']
        ];
    }
}
