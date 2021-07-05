<?php

namespace App\Http\Requests\Api\Requests;

use App\Http\Requests\Api\ApiRequest;

class UpdateRequest extends ApiRequest
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
            'content' => 'bail|required|string',
            'category_id'=>'bail|required|integer|exists:categories,id',
            'assign_id'=>'bail|required|integer|exists:users,id',
            'priority_id'=>'bail|required|integer|exists:priorities,id',
            'due_date'=>'bail|required|date_format:Y-m-d',
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
            'date_format' => config('constants.VALIDATE.DATE_FORMAT'),
            'exists' => config('constants.VALIDATE.EXISTS'),
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
