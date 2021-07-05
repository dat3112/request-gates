<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Validation\Rule;

class SettingAccountRequest extends ApiRequest
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
            'avatar' => 'required|max:2048|mimes:'
                . Rule::in(array_values(config("constants.VALIDATE.IMAGE.MIMES.TYPE")))
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
            'phone.digits' => config('constants.VALIDATE.DIGITS'),
            'avatar.mimes' => config('constants.VALIDATE.IMAGE.MIMES.MESSAGE'),
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
