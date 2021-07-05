<?php

namespace App\Http\Requests\Api\Category;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'user_id'=>'required|integer|exists:users,id',
            'status'=>'required|integer|'.Rule::in(array_values(config('constants.CATEGORY.STATUS'))),
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
            'string' => config('constants.VALIDATE.STRING'),
            'required' => config('constants.VALIDATE.REQUIRED'),
            'integer' => config('constants.VALIDATE.INTEGER'),
            'in' => config('constants.VALIDATE.IN.STATUS')
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
