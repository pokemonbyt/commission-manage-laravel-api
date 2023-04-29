<?php


namespace App\Modules\User\Request;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Notes: 创建用户请求
 *
 * Class UserRequest
 * @package App\Modules\User\Request
 */
class UserRequest extends FormRequest
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
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required|max:50',
            'types' => 'required|numeric|min:-128|max:127',
        ];
    }
}
