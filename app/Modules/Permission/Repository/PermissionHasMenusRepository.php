<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/1 17:35
 */

namespace App\Modules\Permission\Repository;

use App\Models\PermissionHasMenus;

/**
 * Notes: 权限拥有的菜单表SQL操作
 *
 * Class PermissionHasMenusRepository
 * @package App\Modules\Permission\Repository
 */
class PermissionHasMenusRepository
{
    private $model;

    public function __construct(PermissionHasMenus $model)
    {
        $this->model = $model;
    }

    /**
     * Notes: 创建菜单和权限的管理
     * User: admin
     * Date: 2020/1/3 11:34
     *
     * @param $menuId
     * @param $permissionId
     * @return bool
     */
    public function create($menuId, $permissionId)
    {
        $permissionHasMenus = new PermissionHasMenus();
        $permissionHasMenus->menu_id = $menuId;
        $permissionHasMenus->permission_id = $permissionId;

        return $permissionHasMenus->save();
    }

    /**
     * Notes: 删除权限内的菜单
     * User: admin
     * Date: 2020/1/3 11:43
     *
     * @param $menus
     * @param $permissionId
     * @return int
     */
    public function delete($menus, $permissionId)
    {
        return \DB::table($this->model->getTable())->whereIn('menu_id', $menus)->where('permission_id', $permissionId)->delete();
    }

    /**
     * Notes: 查找关联关系
     * User: admin
     * Date: 2020/1/3 11:48
     *
     * @param $menuId
     * @param $permissionId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findOne($menuId, $permissionId)
    {
        return PermissionHasMenus::where(['menu_id' => $menuId, 'permission_id' => $permissionId])->first();
    }

    /**
     * Notes: 根据权限ids获取菜单ids
     * User: admin
     * Date: 2020/1/3 15:06
     *
     * @param $permissionIds
     * @return \Illuminate\Support\Collection
     */
    public function listMenuIdsByPermissionIds($permissionIds)
    {
        return PermissionHasMenus::whereIn('permission_id', $permissionIds)->get();
    }
}
