<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/28 12:12
 */

namespace App\Modules\Permission\Traits;


use App\Models\Routes;
use Spatie\Permission\Traits\HasRoles;

/**
 * Notes: 用于挂载路由访问权限的检测
 *
 * Trait HasRouter
 * @package App\Modules\Permission\Traits
 */
trait HasRouter
{
    use HasRoles;

    /**
     * Notes: 检测用户是否有路由的访问权限
     * User: admin
     * Date: 2019/12/28 13:11
     *
     * @param $name
     * @return bool
     */
    public function checkRouterPermission($name)
    {
        $permissions = $this->findPermissionsByName($name);
        if ($permissions->isNotEmpty()) {
            foreach ($permissions as $permission) {
                //检测是否拥有权限
                if ($this->hasPermissionTo($permission->permission_id)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Notes: 查所有拥有这个路由的权限
     * User: admin
     * Date: 2019/12/28 13:05
     *
     * @param $name
     * @return \Illuminate\Support\Collection
     */
    public function findPermissionsByName($name)
    {
        $model = Routes::where('name', $name)->first();
        if ($model) {
            return $model->permissions()->get();
        }
        return collect();
    }
}
