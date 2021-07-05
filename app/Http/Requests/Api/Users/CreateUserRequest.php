<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string',
            'phone' => 'bail|required|digits:10|unique:users,phone',
            'email' => 'bail|required|email|unique:users,email',
            'age' => 'bail|required|integer|min:18',
            'role_id' => 'bail|required|' . Rule::in(array_values(config('constants.ROLE'))),
            'department_id' => 'bail|required|exists:departments,id',
            'gender' => 'bail|required|' . Rule::in(array_values(config('constants.USER.GENDER'))),
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
            'email.email' => config('constants.LOGIN.EMAILERROR'),
            'required' => config('constants.VALIDATE.REQUIRED'),
            'confirmed' => config('constants.RESETPASSWORD.RE_PASSWORD_ERROR'),
            'gender.in' => config('constants.VALIDATE.IN.GENDER'),
            'role_id.in' => config('constants.VALIDATE.IN.ROLE'),
            'email.unique' => config('constants.VALIDATE.UNIQUE.EMAIL'),
            'phone.unique' => config('constants.VALIDATE.UNIQUE.PHONE'),
            'integer' => config('constants.VALIDATE.INTEGER'),
            'exists' => config('constants.VALIDATE.EXISTS'),
            'age.min' => config('constants.VALIDATE.AGE'),
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
