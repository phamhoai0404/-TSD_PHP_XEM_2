<?php

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Line;
class LineUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lineCode' => "required|unique:lines,lineCode,".$this->id,
            'userId' => "required",
        ];
    }

    public function messages()
    {
        return [
            'lineCode.required' => __('validation.required'),
            'lineCode.unique' => __('validation.unique'),
            'userId.required' => __('validation.required'),
        ];
    }

    public function attributes()
    {
        return [
            'lineCode' => __('messages.line-code'),
            'userId' => __('messages.line-user'),
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
