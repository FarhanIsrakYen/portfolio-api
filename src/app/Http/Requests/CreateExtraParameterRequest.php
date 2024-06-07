<?php

namespace App\Http\Requests;
use Auth;
use Illuminate\Validation\Rule;

class CreateExtraParameterRequest extends AbstractRequest
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
            'parameter_name' => [
                'required',
                'max:255',
                'string',
                Rule::unique('extra_params', 'parameter_name')->where('user_id', Auth::user()->id)
            ],
            'parameter_value' => ['required']
        ];
    }
}
