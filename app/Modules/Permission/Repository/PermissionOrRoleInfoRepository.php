<?php


namespace App\Modules\Permission\Repository;

use App\Models\PermissionOrRoleInfo;
use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\Permission\Enum\PermissionModelEnum;
use App\Modules\Permission\Enum\PermissionStatusEnum;
use Spatie\Permission\Models\Permission;

/**
 * Notes: 权限系统信息表SQL操作
 *
 * Class PermissionSystemInfoRepository
 * @package App\Modules\Permission\Repository
 */
class PermissionOrRoleInfoRepository
{
    /**
     * Notes: 添加信息
     * User: admin
     * Date: 2019/12/24 14:57
     *
     * @param $model_id
     * @param $model_type
     * @param $name
     * @param $description
     * @param int $status
     * @return bool
     * @throws \Exception
     */
    public function create($model_id, $model_type, $name, $description, $status = PermissionStatusEnum::AUTH)
    {
        $model = static::findOne($model_id, $model_type);
        if ($model) {
            throw new \Exception("permission or role info repeat");
        }

        $permissionOrRoleInfo = new PermissionOrRoleInfo();
        $permissionOrRoleInfo->model_id = $model_id;
        $permissionOrRoleInfo->model_type = $model_type;
        $permissionOrRoleInfo->name = $name;
        $permissionOrRoleInfo->description = $description;
        $permissionOrRoleInfo->status = $status;

        return $permissionOrRoleInfo->save();
    }

    /**
     * Notes: 删除信息
     * User: admin
     * Date: 2019/12/24 15:51
     *
     * @param $model_id
     * @param $model_type
     */
    public function delete($model_id, $model_type)
    {
        PermissionOrRoleInfo::where(['model_id' => $model_id, 'model_type' => $model_type])->delete();
    }

    /**
     * Notes: 编辑信息
     * User: admin
     * Date: 2019/12/25 10:57
     *
     * @param $model_id
     * @param $model_type
     * @param $name
     * @param $description
     * @param $status
     * @return bool
     */
    public function edit($model_id, $model_type, $name, $description, $status)
    {
        $model = static::findOne($model_id, $model_type);
        if ($model) {
            $model->name = $name;
            $model->description = $description;
            $model->status = $status;

            return $model->save();
        }
        return false;
    }

    /**
     * Notes: 根据权限id列表查询信息
     * User: admin
     * Date: 2019/12/28 14:37
     *
     * @param $model_type
     * @param array $model_ids
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|PermissionOrRoleInfo[]
     */
    public function listByModelIds($model_type, $model_ids)
    {
        return PermissionOrRoleInfo::where('model_type', $model_type)
            ->whereIn('model_id', $model_ids)
            ->get();
    }

    /**
     * Notes: 根据权限id列表查询信息(分页)
     * User: admin
     * Date: 2020/3/28 15:31
     *
     * @param $model_type
     * @param $model_ids
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateByModelIds($model_type, $model_ids)
    {
        return PermissionOrRoleInfo::where('model_type', $model_type)
            ->whereIn('model_id', $model_ids)
            ->paginate(request()['limit']);
    }

    /**
     * Notes: 查找权限信息
     * User: admin
     * Date: 2020/3/27 20:14
     *
     * @param $modelIds
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|PermissionOrRoleInfo[]
     */
    public function listByPermission($modelIds)
    {
        return PermissionOrRoleInfo::with('permission')
            ->where('model_type', PermissionModelEnum::PERMISSION)
            ->whereIn('model_id', $modelIds)
            ->get();
    }

    /**
     * Notes: 查找权限信息（分页）
     * User: admin
     * Date: 2020/3/28 15:36
     *
     * @param $modelIds
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateByPermission($modelIds)
    {
        return PermissionOrRoleInfo::with('permission')
            ->where('model_type', PermissionModelEnum::PERMISSION)
            ->whereIn('model_id', $modelIds)
            ->paginate(request()['limit']);
    }

    /**
     * Notes: 查找角色信息
     * User: admin
     * Date: 2020/3/28 15:29
     *
     * @param $modelIds
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|PermissionOrRoleInfo[]
     */
    public function listByRole($modelIds)
    {
        return PermissionOrRoleInfo::with('role')
            ->where('model_type', PermissionModelEnum::ROLE)
            ->whereIn('model_id', $modelIds)
            ->get();
    }

    /**
     * Notes: 查找角色信息（分页）
     * User: admin
     * Date: 2020/3/28 15:36
     *
     * @param $modelIds
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateByRole($modelIds)
    {
        $keyword = request()['keyword'];
        $status = request()['status'];

        $select = PermissionOrRoleInfo::with('role')
            ->where('model_type', PermissionModelEnum::ROLE)
            ->whereIn('model_id', $modelIds);
        //筛选关键字
        if ($keyword) {
            $select->whereRaw("concat(name,description) like '%{$keyword}%'");
        }
        //筛选授权状态
        if (utils()->boolExist($status)) {
            $select->where('status', $status);
        }

        return $select->paginate(request()['limit']);
    }

    /**
     * Notes: 查信息
     * User: admin
     * Date: 2019/12/25 17:31
     *
     * @param $model_id
     * @param $model_type
     * @param array $column
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function findOne($model_id, $model_type, $column = ['*'])
    {
        return PermissionOrRoleInfo::where(['model_id' => $model_id, 'model_type' => $model_type])->first($column);
    }
}
