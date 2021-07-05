<?php

namespace App\Http\Requests\Api\Department;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|min:5',
            'description' => 'required|string',
            'status'=>'required|integer|'.Rule::in(array_values(config('constants.DEPARTMENT.STATUS'))),
            'department_code' => 'unique:departments,department_code,' . $this->id,
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
            'in' => config('constants.VALIDATE.IN.STATUS'),
            'max' => config('constants.DEPARTMENT.VALIDATE.MAX'),
            'min' => config('constants.DEPARTMENT.VALIDATE.MIN'),
            'department_code.unique' => config('constants.VALIDATE.UNIQUE.DEPARTMENT_CODE'),
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
