<?php

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\MicroPC;

class MicroPCUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'microCode' => 'required|unique:micro_pcs,microCode,'.$this->id,
            'ipAddress' => 'required|ip|unique:micro_pcs,ipAddress,'.$this->id,
        ];
    }

    public function messages()
    {
        return [
            'microCode.required' => __('validation.required'),
            'microCode.unique' => __('validation.unique'),
            'ipAddress.required' => __('validation.required'),
            'ipAddress.unique' => __('validation.unique'),
            'ipAddress.ip' => __('validation.ip'),
        ];
    }

    public function attributes()
    {
        return [
            'microCode' => __('messages.micro-code'),
            'ipAddress' => __('messages.ip-address'),
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
