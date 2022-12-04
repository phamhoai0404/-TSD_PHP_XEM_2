<?php

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Department;
class DepartmentUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'depCode' => "required|alpha_num:/\w\_\./|unique:departments,depCode,".$this->id,
            'depName' => "required",
        ];
    }

    public function messages()
    {
        return [
            'depCode.required' => __('validation.required'),
            'depCode.unique' => __('validation.unique'),
            'depCode.alpha_num' => __('validation.alpha_num'),
            'depName.required' => __('validation.required'),
        ];
    }

    public function attributes()
    {
        return [
            'depCode' => __('messages.dep-code'),
            'depName' => __('messages.dep-name'),
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
