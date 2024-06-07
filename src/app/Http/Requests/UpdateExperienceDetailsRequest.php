<?php

namespace App\Http\Requests;

class UpdateExperienceDetailsRequest extends AbstractRequest
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
            'position' => ['max:255'],
            'institution' => ['string'],
            'startedAt' => ['integer'],
            'endedAt' => ['integer'],
            'job_type' => ['in:on-site,remote'],
            'technologies_used' => ['array']
        ];
    }
}
