<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreSkillRequest extends AbstractRequest
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
            'skills' => ['required','array'],
            'skills.*.topic' => [
                'required',
                'string',
                Rule::unique('skills', 'topic')->where('user_id', Auth::user()->id)
            ],
            'skills.*.percentage' => ['required','numeric','between:1,100']
        ];
    }
}
