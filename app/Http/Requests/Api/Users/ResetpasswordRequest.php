<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;

class ResetpasswordRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => 'required|exists:password_resets,token',
            'email' => 'required|email|exists:password_resets,email',
            'newPassword' => 'required|confirmed',

        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => config('constants.RESET_PASSWORD.LINK_ERROR'),
            'exists' => config('constants.RESET_PASSWORD.LINK_ERROR'),
            'email' => config('constants.RESET_PASSWORD.LINK_ERROR'),
            'confirmed' => config('constants.RESET_PASSWORD.RE_PASSWORD_ERROR')
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }
}
