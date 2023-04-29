<?php


namespace App\Modules\Permission\Service;

use App\Models\Department;
use App\Models\OfficeAddress;
use App\Models\Position;
use App\Models\User;
use App\Models\UserStatusInfo;
use App\Modules\Permission\Enum\PermissionModelEnum;
use App\Modules\Permission\Enum\PermissionStatusEnum;
use App\Modules\Permission\ErrorCode\PermissionErrorCode;
use App\Modules\Permission\Repository\PermissionOrRoleInfoRepository;
use App\Modules\Permission\Resource\RoleUserInfoListResource;
use App\Modules\User\ErrorCode\UserErrorCode;
use App\Modules\User\Repository\UserRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Notes: 权限业务
 *
 * Class PermissionService
 * @package App\Modules\Permission\Service
 */
class PermissionService
{
    private $userRepository;

    private $permissionOrRoleInfoRepository;

    public function __construct(UserRepository $userRepository, PermissionOrRoleInfoRepository $permissionOrRoleInfoRepository)
    {
        $this->userRepository = $userRepository;
        $this->permissionOrRoleInfoRepository = $permissionOrRoleInfoRepository;
    }

    /**
     * Notes: 增加权限
     * User: admin
     * Date: 2019/12/24 15:24
     *
     * @param $name
     * @param $cnName
     * @param $description
     * @param $status
     * @return bool|int
     */
    public function create($name, $cnName, $description, $status)
    {
        try {
            $model = Permission::query()->where('name', $name)->first();
            if ($model) {
                return PermissionErrorCode::DUPLICATE_PERMISSIONS;
            }

            \DB::transaction(function () use ($name, $cnName, $description, $status) {
                $permission = Permission::create(["name" => $name, 'guard_name' => guard_api()]);

                $this->permissionOrRoleInfoRepository->create($permission->id, PermissionModelEnum::PERMISSION, $cnName, $description, $status);
            });

            return true;

        } catch (\Throwable $e) {
            \Log::error($e);
            return PermissionErrorCode::PERMISSION_CREATE_EXCEPTION;
        }
    }

    /**
     * Notes: 删除权限
     * User: admin
     * Date: 2019/12/24 15:59
     *
     * @param $id
     * @return bool|int
     */
    public function delete($id)
    {
        try {
            \DB::transaction(function () use ($id) {
                Permission::destroy($id);

                $this->permissionOrRoleInfoRepository->delete($id, PermissionModelEnum::PERMISSION);
            });

            return true;

        } catch (\Throwable $e) {
            \Log::error($e);
            return PermissionErrorCode::PERMISSION_DELETE_EXCEPTION;
        }
    }

    /**
     * Notes: 编辑权限
     * User: admin
     * Date: 2019/12/25 10:58
     *
     * @param $id
     * @param $name
     * @param $cnName
     * @param $description
     * @param $status
     * @return bool
     */
    public function edit($id, $name, $cnName, $description, $status)
    {
        $model = Permission::query()->where('id', $id)->first();
        if ($model) {
            try {
                \DB::transaction(function () use ($model, $id, $name, $cnName, $description, $status) {
                    $model->save([
                        'name' => $name
                    ]);

                    $this->permissionOrRoleInfoRepository->edit($id, PermissionModelEnum::PERMISSION, $cnName, $description, $status);
                });

                return true;

            } catch (\Throwable $e) {
                \Log::error($e);
                return PermissionErrorCode::PERMISSION_EDIT_EXCEPTION;
            }
        }

        return PermissionErrorCode::PERMISSION_DOES_NOT_EXIST;
    }

    /**
     * Notes: 查找所有权限
     * User: admin
     * Date: 2020/1/7 15:42
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        $name = request()['name'];
        $cn_name = request()['cn_name'];
        $status = request()['status'];

        $select = Permission::query()
            ->leftJoin('permission_or_role_info', function ($join) {
                $join->on('permissions.id', '=', 'permission_or_role_info.model_id')
                    ->where('permission_or_role_info.model_type', PermissionModelEnum::PERMISSION);
            })
            ->select('permissions.*',
                'permission_or_role_info.name as cn_name',
                'permission_or_role_info.description',
                'permission_or_role_info.status');

        //名称
        if ($name) {
            $select->where('permissions.name', 'like', "%{$name}%");
        }
        //中文名称
        if ($cn_name) {
            $select->where('permission_or_role_info.name', 'like', "%{$cn_name}%");
        }
        //状态
        if (\utils()->boolExist($status)) {
            $select->where('permission_or_role_info.status', (int)$status);
        }

        return $select->paginate(request()['limit']);
    }

    /**
     * Notes: 给予用户权限
     * User: admin
     * Date: 2019/12/28 15:45
     *
     * @param $username
     * @param mixed ...$permissions
     * @return bool|\Illuminate\Database\Eloquent\Builder|int|mixed|null
     */
    public function giveToUser($username, ...$permissions)
    {
        try {
            /**
             * 不是超级管理员，需要检测权限能否能分配给其他用户
             */
            if (!is_super_admin()) {
                $collection = Permission::query()->whereIn('name', $permissions)->get(['id']);
                $ids = $collection->pluck('id')->toArray();
                //查询所有权限信息
                $models = $this->permissionOrRoleInfoRepository->listByModelIds(PermissionModelEnum::PERMISSION, $ids);
                $notAuth = null;
                foreach ($models as $model) {
                    if ($model->status == PermissionStatusEnum::NOT_AUTH) {
                        $notAuth = $model;
                        break;
                    }
                }

                if ($notAuth) {
                    return $notAuth;
                }
            }

            $user = $this->userRepository->findByUserName($username);
            if ($user) {
                $user->givePermissionTo($permissions);

                return true;
            }

            return UserErrorCode::USER_DOES_NOT_EXIST;

        } catch (\Exception $e) {
            \Log::error($e);
            return PermissionErrorCode::PERMISSION_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 删除用户的权限
     * User: admin
     * Date: 2019/12/25 11:33
     *
     * @param $username
     * @param $permission
     * @return bool
     */
    public function revokeToUser($username, $permission)
    {
        try {
            $user = $this->userRepository->findByUserName($username);
            if ($user) {
                $user->revokePermissionTo($permission);

                return true;
            }

            return UserErrorCode::USER_DOES_NOT_EXIST;

        } catch (\Exception $e) {
            \Log::error($e);
            return PermissionErrorCode::PERMISSION_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 删除用户所有旧权限后，再全部同步新权限
     * User: admin
     * Date: 2020/1/7 13:50
     *
     * @param $username
     * @param mixed ...$permissions
     * @return bool|int
     */
    public function syncToUser($username, ...$permissions)
    {
        try {
            $user = $this->userRepository->findByUserName($username);
            if (!$user) {
                return UserErrorCode::USER_DOES_NOT_EXIST;
            }

            $user->syncPermissions($permissions);

            return true;

        } catch (\Exception $e) {
            \Log::error($e);
            return PermissionErrorCode::PERMISSION_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 根据工号查找用户是否拥有权限
     * User: admin
     * Date: 2019/12/13 11:41
     *
     * @param $username
     * @param $permission
     * @return bool
     */
    public function hasToUser($username, $permission)
    {
        $user = $this->userRepository->findByUserName($username);
        if ($user) {
            try {
                return $user->hasPermissionTo($permission);

            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * Notes: 查找权限所在的用户
     * User: admin
     * Date: 2020/4/2 21:32
     *
     * @param $permissions
     * @return array
     */
    public function findInUsers($permissions)
    {
        try {
            $result = User::permission($permissions)->with([UserStatusInfo::tableName() => function ($query) {
                $query->with([
                    OfficeAddress::tableName(),
                    Department::tableName(),
                    Position::tableName()
                ]);
            }])->paginate(request()['limit']);

            return utils()->paginate($result, RoleUserInfoListResource::collection($result));

        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Notes: 查询用户拥有的所有权限
     * User: admin
     * Date: 2019/12/25 15:14
     *
     * @param $username
     * @return array|\Illuminate\Support\Collection
     */
    public function findAllToUser($username)
    {
        $user = $this->userRepository->findByUserName($username);
        if ($user) {
            try {
                $ids = $user->getAllPermissions()->pluck('id')->toArray();

                return $this->permissionOrRoleInfoRepository->listByModelIds(PermissionModelEnum::PERMISSION, $ids);

            } catch (\Exception $e) {
                \Log::error($e);
            }
        }
        return [];
    }

    /**
     * Notes:查找权限的角色列表
     * User: john
     * Date: 2021-03-30 23:22
     *
     * @param $id
     * @return mixed
     */
    public function rolesByPermission($id)
    {
        $result = Permission::where('id', $id)->first();
        $roleIds = $result->roles->pluck('id')->toArray();

        $roles = Role::query()
            ->leftJoin('permission_or_role_info', function ($join) {
                $join->on('roles.id', '=', 'permission_or_role_info.model_id')
                    ->where('permission_or_role_info.model_type', PermissionModelEnum::ROLE);
            })
            ->select('roles.*',
                'permission_or_role_info.name as cn_name',
                'permission_or_role_info.description',
                'permission_or_role_info.status')
            ->whereIn('roles.id', $roleIds);


        return $roles->paginate(request()['limit']);
    }
}
