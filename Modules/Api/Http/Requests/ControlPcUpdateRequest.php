<?php

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ControlPcUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'controlpcCode' => "required|unique:controlpcs,controlpcCode,".$this->id,
            'ipAddress' => "required|ip",
        ];
    }

    public function messages()
    {
        return [
            'controlpcCode.required' => __('validation.required'),
            'controlpcCode.unique' => __('validation.unique'),
            'ipAddress.required' => __('validation.required'),
            'ipAddress.ip' => __('validation.ip'),
            'ipAddress.unique' => __('validation.unique'),
        ];
    }

    public function attributes()
    {
        return [
            'controlpcCode' => __('messages.controlpc-Code'),
            'ipAddress' => __('messages.ipAddress'),
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
