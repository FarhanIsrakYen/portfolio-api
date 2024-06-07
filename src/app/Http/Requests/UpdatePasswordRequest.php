<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePasswordRequest extends AbstractRequest
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
            'password' => 'required|between:8,255',
            'confirmPassword' => 'min:8|different:password|same:repeatPassword',
            'repeatPassword' => 'min:8',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCurrentPassword($validator);
        });
    }

    protected function validateCurrentPassword($validator)
    {
        $user = Auth::user();

        if (!Hash::check($this->password, $user->password)) {
            $validator->errors()->add('password', 'Incorrect password!');
        }
    }

    public function failedValidation(Validator $validator) : Response {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->getMessageBag()
        ], Response::HTTP_BAD_REQUEST));
    }
}
