<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:6|max:196',
            'body'  => 'required|min:26|max:10000'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'title.min' => '标题不能少于3个字',
            'title.max' => '标题不能多于98个字',
            'body.required' => '问题内容不能为空',
            'body.min' => '问题内容不能少于13个字',
            'body.max' => '问题内容不能多于5000个字',
        ];
    }
}
