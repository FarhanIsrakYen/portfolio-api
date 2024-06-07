<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProjectAndPublicationsRequest extends AbstractRequest
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
            'name' => ['max:255','string'],
            'category' => ['in:official,personal'],
            'startedAt' => ['string'],
            'endedAt' => ['string'],
            'link' => ['string'],
            'technologies_used' => ['array'],
            'images' => ['array'],
        ];
    }
}
