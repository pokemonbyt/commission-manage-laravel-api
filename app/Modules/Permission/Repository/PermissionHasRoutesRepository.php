<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/26 15:35
 */

namespace App\Modules\Permission\Repository;

use App\Models\PermissionHasRoutes;

/**
 * Notes: 权限拥有的路由表SQL操作
 *
 * Class PermissionHasRoutesRepository
 * @package App\Modules\Permission\Repository
 */
class PermissionHasRoutesRepository
{
    private $model;

    public function __construct(PermissionHasRoutes $model)
    {
        $this->model = $model;
    }

    /**
     * Notes: 创建路由和权限的关联
     * User: admin
     * Date: 2019/12/27 11:00
     *
     * @param $routerId
     * @param $permissionId
     * @return bool
     */
    public function create($routerId, $permissionId)
    {
        $permissionHasRoutes = new PermissionHasRoutes();
        $permissionHasRoutes->router_id = $routerId;
        $permissionHasRoutes->permission_id = $permissionId;

        return $permissionHasRoutes->save();
    }

    /**
     * Notes: 删除权限内的路由
     * User: admin
     * Date: 2019/12/28 19:01
     *
     * @param $routers
     * @param $permissionId
     * @return int
     */
    public function delete($routers, $permissionId)
    {
        return \DB::table($this->model->getTable())->where(['router_id' => $routers, 'permission_id' => $permissionId])->delete();
    }

    /**
     * Notes: 查找关联关系
     * User: admin
     * Date: 2019/12/27 11:03
     *
     * @param $routerId
     * @param $permissionId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findOne($routerId, $permissionId)
    {
        return PermissionHasRoutes::where(['router_id' => $routerId, 'permission_id' => $permissionId])->first();
    }

    /**
     * Notes: 根据权限ids获取路由ids
     * User: admin
     * Date: 2020/1/7 16:52
     *
     * @param $permissionIds
     * @return \Illuminate\Support\Collection
     */
    public function listRouteIdsByPermissionIds($permissionIds)
    {
        return PermissionHasRoutes::whereIn('permission_id', $permissionIds)->get();
    }
}
