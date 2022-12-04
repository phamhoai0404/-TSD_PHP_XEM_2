<?php

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\User;
class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userCode' => "required|unique:users,userCode,".$this->id,
        ];
    }

    public function messages()
    {
        return [
            'userCode.required' => __('validation.required'),
            'userCode.unique' => __('validation.unique'),
        ];
    }

    public function attributes()
    {
        return [
            'userCode' => __('messages.user-code'),
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
