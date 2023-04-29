<?php

namespace App\Modules\Auth\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 登录请求
 * @package App\Modules\Auth\Request
 */
class LoginRequest extends FormRequest
{
    /**
     * 验证用户是否有权限请求
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 请求规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required', //|unique:users,username
            'password' => 'required',
        ];
    }

    /**
     * 错误消息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => ':attribute is required',
            'password.required' => ':attribute is required',
        ];
    }
}
