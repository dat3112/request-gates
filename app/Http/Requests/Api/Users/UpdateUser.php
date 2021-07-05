<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends ApiRequest
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
            'phone' => 'bail|required|digits:10',
            'age' => 'bail|required|integer',
            'gender' => 'bail|required|'.Rule::in(array_values(config('constants.USER.GENDER'))),
            'department_id' => 'bail|required|exists:departments,id',
            'role_id' => 'bail|required|'.Rule::in(array_values(config('constants.ROLE'))),
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
            'required' => config('constants.VALIDATE.REQUIRED'),
            'string' => config('constants.VALIDATE.STRING'),
            'integer' => config('constants.VALIDATE.INTEGER'),
            'gender.in' => config('constants.VALIDATE.IN.GENDER'),
            'digits' => config('constants.VALIDATE.DIGITS.PHONE'),
            'exists' => config('constants.VALIDATE.EXISTS'),
            'role_id.in' => config('constants.VALIDATE.IN.ROLE'),
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
