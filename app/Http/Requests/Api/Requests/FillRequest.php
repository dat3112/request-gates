<?php

namespace App\Http\Requests\Api\Requests;

use App\Http\Requests\Api\ApiRequest;

class FillRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page' => 'integer',
            'name' => 'string',
            'content'=>'string',
            'created_at'=>'date_format:Y-m-d',
            'status_id'=>'integer',
            'author_id'=>'integer',
            'assign_id'=>'integer',
            'category_id'=>'integer'
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
            'date_format' => config('constants.VALIDATE.DATE_FORMAT'),
            'integer' => config('constants.VALIDATE.INTEGER')
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
