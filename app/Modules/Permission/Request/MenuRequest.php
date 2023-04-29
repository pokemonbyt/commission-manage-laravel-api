<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/2 14:26
 */

namespace App\Modules\Permission\Request;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Notes: 菜单请求 增加/修改请求
 *
 * Class MenuRequest
 * @package App\Modules\Permission\Request
 */
class MenuRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'path' => 'required|string|max:255',
            'component' => 'required_if:outreach,0|string|max:255',
            'redirects' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'hidden' => 'required|boolean',
            'no_cache' => 'required|boolean',
            'outreach' => 'required|boolean',
            'sort' => 'required|int|gt:0',
            'pid' => 'required|int',
        ];
    }
}
