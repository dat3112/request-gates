<?php

namespace App\Http\Requests\Api\Requests;

use App\Http\Requests\Api\ApiRequest;

class UpdateRequestAdmin extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'assign_id'=>'bail|required|integer|exists:users,id',
            'priority_id'=>'bail|required|integer|exists:priorities,id',
            'status_id'=>'bail|required|integer|exists:statuses,id',
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
            'integer' => config('constants.VALIDATE.INTEGER'),
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
