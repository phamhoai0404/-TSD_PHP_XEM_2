<?php

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userCode' => 'required|unique:users',
            'depId' => 'required',
            'roleId' => 'required',
            'password' => 'required|min:2',
            'confirmPassword' => 'required_with:password|same:password',
        ];
    }

    
    public function messages()
    {
        return [
            'userCode.required' => __('validation.required'),
            'depId.required' => __('validation.required'),
            'roleId.required' => __('validation.required'),
            'userCode.unique' => __('validation.unique'),
            'password.required' => __('validation.required'),
            'password.min' => __('validation.min'),
            'confirmPassword.required_with' => __('validation.required_with'),
            'confirmPassword.same' => __('validation.same'),
        ];
    }

    public function attributes()
    {
        return [
            'userCode' => __('messages.user-code'),
            'password' => __('messages.password'),
            'depId' => __('messages.dep-code'),
            'roleId' => __('messages.role-code'),
            'confirmPassword' => __('messages.confirm-password'),
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
