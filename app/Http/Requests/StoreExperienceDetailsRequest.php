<?php

namespace App\Http\Requests;

class StoreExperienceDetailsRequest extends AbstractRequest
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
            'position' => ['required','max:255'],
            'institution' => ['required','string'],
            'startedAt' => ['required','integer'],
            'endedAt' => ['required','integer'],
            'job_type' => ['required','in:on-site,remote'],
            'responsibilities' => ['required'],
            'technologies_used' => ['required','array']
        ];
    }
}
