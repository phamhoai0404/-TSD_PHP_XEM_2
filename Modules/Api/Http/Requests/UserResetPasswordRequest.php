<?php

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|min:2',
            'confirmPassword' => 'required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => __('validation.required'),
            'password.min' => __('validation.min'),
            'confirmPassword.required_with' => __('validation.required_with'),
            'confirmPassword.same' => __('validation.same'),
        ];
    }

    public function attributes()
    {
        return [
            'password' => __('messages.password'),
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
