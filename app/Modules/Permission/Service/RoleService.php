<?php


namespace App\Modules\Permission\Service;

use App\Models\User;
use App\Modules\Common\Entity\TreeTools;
use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\Permission\Enum\PermissionModelEnum;
use App\Modules\Permission\Enum\PermissionStatusEnum;
use App\Modules\Permission\ErrorCode\PermissionErrorCode;
use App\Modules\Permission\Repository\PermissionOrRoleInfoRepository;
use App\Modules\Permission\Resource\RoleInfoListResource;
use App\Modules\Permission\Resource\RoleUserInfoListResource;
use App\Modules\User\Repository\UserRepository;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Notes: 角色业务
 *
 * Class RoleService
 * @package App\Modules\Permission\Service
 */
class RoleService
{
    private $userRepository;

    private $permissionOrRoleInfoRepository;

    private $userStatusInfoRepository;

    public function __construct(UserRepository $userRepository,
                                PermissionOrRoleInfoRepository $permissionOrRoleInfoRepository)
    {
        $this->userRepository = $userRepository;
        $this->permissionOrRoleInfoRepository = $permissionOrRoleInfoRepository;
    }

    /**
     * Notes: 增加角色
     * User: admin
     * Date: 2019/12/25 11:07
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
            $model = Role::query()->where('name', $name)->first();
            if ($model) {
                return PermissionErrorCode::DUPLICATE_ROLE;
            }

            \DB::transaction(function () use($name, $cnName, $description, $status) {
                $role = Role::create(["name" => $name, 'guard_name' => guard_api()]);

                $this->permissionOrRoleInfoRepository->create($role->id, PermissionModelEnum::ROLE, $cnName, $description, $status);
            });

            return true;

        } catch (\Throwable $e) {
            \Log::error($e);
            return PermissionErrorCode::ROLE_CREATE_EXCEPTION;
        }
    }

    /**
     * Notes: 删除角色
     * User: admin
     * Date: 2019/12/25 11:12
     *
     * @param $id
     * @return bool|int
     */
    public function delete($id)
    {
        try {
            \DB::transaction(function () use($id) {
                Role::destroy($id);

                $this->permissionOrRoleInfoRepository->delete($id, PermissionModelEnum::ROLE);
            });

            return true;

        } catch (\Throwable $e) {
            \Log::error($e);
            return PermissionErrorCode::ROLE_DELETE_EXCEPTION;
        }
    }

    /**
     * Notes: 编辑角色
     * User: admin
     * Date: 2019/12/25 17:28
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
        $model = Role::query()->where('id', $id)->first();
        if ($model) {
            try {
                \DB::transaction(function () use ($model, $id, $name, $cnName, $description, $status) {
                    $model->save([
                        'name' => $name
                    ]);

                    $this->permissionOrRoleInfoRepository->edit($id, PermissionModelEnum::ROLE, $cnName, $description, $status);
                });

                return true;

            } catch (\Throwable $e) {
                \Log::error($e);
                return PermissionErrorCode::ROLE_EDIT_EXCEPTION;
            }
        }

        return PermissionErrorCode::ROUTE_DOES_NOT_EXIST;
    }

    /**
     * Notes: 查找所有角色
     * User: admin
     * Date: 2020/1/7 15:45
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        $name = request()['name'];
        $cn_name = request()['cn_name'];
        $status = request()['status'];

        $select = Role::query()
            ->leftJoin('permission_or_role_info', function ($join) {
                $join->on('roles.id', '=', 'permission_or_role_info.model_id')
                    ->where('permission_or_role_info.model_type', PermissionModelEnum::ROLE);
            })
            ->select('roles.*',
                'permission_or_role_info.name as cn_name',
                'permission_or_role_info.description',
                'permission_or_role_info.status');

        //名称
        if ($name) {
            $select->where('roles.name', 'like', "%{$name}%");
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
     * Notes: 给予用户角色
     * User: admin
     * Date: 2019/12/28 15:54
     *
     * @param $username
     * @param mixed ...$roles
     * @return bool|\Illuminate\Database\Eloquent\Builder|int|mixed|null
     */
    public function assignToUser($username, ...$roles)
    {
        try {
            /**
             * 不是超级管理员，需要检测角色能否能分配给其他用户
             */
            if (!is_super_admin()) {
                $collection = Role::query()->whereIn('name', $roles)->get(['id']);
                $ids = $collection->pluck('id')->toArray();
                //查询所有权限信息
                $models = $this->permissionOrRoleInfoRepository->listByModelIds(PermissionModelEnum::ROLE, $ids);
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
                $user->assignRole($roles);

                return true;
            }
            return false;

        } catch (\Exception $e) {
            \Log::error($e);
            return PermissionErrorCode::ROLE_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 给予用户角色不要检查用户类型
     * User: admin
     * Date: 2021/06/08 15:52
     *
     * @param $username
     * @param mixed ...$roles
     * @return \App\Models\PermissionOrRoleInfo|bool|\Illuminate\Database\Eloquent\Builder|int|mixed
     */
    public function assignToUserWithoutCheck($username, ...$roles)
    {
        try {
            $user = $this->userRepository->findByUserName($username);
            if ($user) {
                $user->assignRole($roles);

                return true;
            }
            return false;

        } catch (\Exception $e) {
            \Log::error($e);
            return PermissionErrorCode::ROLE_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 给予角色权限
     * User: admin
     * Date: 2019/12/25 11:20
     *
     * @param $name
     * @param mixed ...$permissions
     * @return bool
     */
    public function givePermissionTo($name, ...$permissions)
    {
        \Log::info($permissions[0]);
        try {
            Role::findByName($name, guard_api())->givePermissionTo($permissions);

            return true;

        } catch (RoleDoesNotExist $roleDoesNotExist) {
            \Log::error($roleDoesNotExist);
            return PermissionErrorCode::ROLE_DOES_NOT_EXIST;

        } catch (PermissionDoesNotExist $permissionDoesNotExist) {
            \Log::error($permissionDoesNotExist);
            return PermissionErrorCode::PERMISSION_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 删除用户身上的角色
     * User: admin
     * Date: 2019/12/25 18:23
     *
     * @param $username
     * @param $role
     * @return bool
     */
    public function removeToUser($username, $role)
    {
        try {
            $user = $this->userRepository->findByUserName($username);
            if ($user) {
                foreach ($role as $r) {
                    $user->removeRole($r);
                }

                return true;
            }
            return false;

        } catch (\Exception $e) {
            \Log::error($e);
            return PermissionErrorCode::ROLE_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 删除角色上的权限
     * User: admin
     * Date: 2019/12/25 18:25
     *
     * @param $name
     * @param $permission
     * @return bool
     */
    public function revokePermissionTo($name, $permission)
    {
        try {
            Role::findByName($name, guard_api())->revokePermissionTo($permission);

            return true;

        } catch (RoleDoesNotExist $roleDoesNotExist) {
            \Log::error($roleDoesNotExist);
            return PermissionErrorCode::ROLE_DOES_NOT_EXIST;

        } catch (PermissionDoesNotExist $permissionDoesNotExist) {
            \Log::error($permissionDoesNotExist);
            return PermissionErrorCode::PERMISSION_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 查找角色的所有权限
     * User: admin
     * Date: 2020/1/7 17:42
     *
     * @param $id
     * @return array
     */
    public function findPermissionTo($id)
    {
        try {
            $allPermissions = collect(Permission::all());
            $role = Role::findById($id, guard_api());
            $permissions = collect($role->permissions);
            //去除已添加
            $unassigned = $allPermissions->filter(function ($value, $key) use ($permissions) {
                return !$permissions->contains('id', $value['id']);
            })->values();

            return [
                'unassigned' => $this->permissionOrRoleInfoRepository->listByPermission($unassigned->pluck('id')->toArray()),
                'assign' => $this->permissionOrRoleInfoRepository->listByPermission($permissions->pluck('id')->toArray())
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            return ['unassigned' => [], 'assign' => []];
        }
    }

    /**
     * Notes: 删除用户所用角色，再全部同步新角色
     * User: admin
     * Date: 2019/12/25 18:30
     *
     * @param $username
     * @param mixed ...$roles
     * @return bool
     */
    public function syncToUser($username, ...$roles)
    {
        try {
            $user = $this->userRepository->findByUserName($username);
            if (!$user) {
                return false;
            }

            $user->syncRoles($roles);

            return true;

        } catch (\Throwable $e) {
            \Log::error($e);
            return PermissionErrorCode::ROLE_DOES_NOT_EXIST;
        }
    }

    /**
     * Notes: 根据工号查找角色
     * User: admin
     * Date: 2019/12/13 12:57
     *
     * @param $username
     * @param $role
     * @return bool
     */
    public function hasToUser($username, $role)
    {
        $user = $this->userRepository->findByUserName($username);
        if ($user) {
            return $user->hasRole($role, guard_api());
        }

        return false;
    }

    /**
     * Notes: 查找我是否有这个角色
     * User: admin
     * Date: 2020/8/3 21:04
     *
     * @param $role
     * @return bool
     */
    public function meHasRole($role)
    {
        $user = api_user_model();
        if($user) {
            return $user->hasRole($role);
        }

        return false;
    }

    /**
     * Notes: 查找角色所有的用户
     * User: admin
     * Date: 2020/3/30 11:57
     *
     * @param $roles
     * @return array
     */
    public function findInUser($roles)
    {
//        try {
//            $select = User::role($roles)->with([UserStatusInfo::tableName() => function($query) {
//                $query->with([
//                    OfficeAddress::tableName(),
//                    Department::tableName(),
//                    Position::tableName()
//                ]);
//            }]);
//
//            //查找我管理的人
//            $manageFind = (new ManageFind(my_user_id(), WorkArrangementTypeEnum::PERMISSION_MANAGER))->find();
//            //获取查找结果
//            $result = $manageFind->getResult();
//            if ($result !== ServiceUserFind::ALL_USER) {
//                $select->whereIn('id', $result['user_ids']);
//            }
//
//            //筛选是否在职
//            $workStatus = request()->get('work_status');
//            if (!$workStatus) {
//                $workStatus = SwitchEnum::NO;
//            }
//
//            $select->whereHas(UserStatusInfo::tableName(), function ($query) use ($workStatus) {
//                $query->where('work_status', $workStatus);
//            });
//
//            $result = $select->paginate(request()['limit']);
//
//            return utils()->paginate($result, RoleUserInfoListResource::collection($result));
//
//        } catch (\Exception $e) {
//            return [];
//        }
    }

    /**
     * Notes: 查询用户身上所有角色
     * User: admin
     * Date: 2020/3/28 15:31
     *
     * @param $username
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllToUser($username)
    {
        $user = $this->userRepository->findByUserName($username);
        if ($user) {
            //超级管理员
            if (check_super_admin($username)) {
                $ids = Role::all()->pluck('id')->toArray();
            //普通用户
            } else {
                $names = $user->getRoleNames();

                $ids = Role::query()->whereIn('name', $names)->get(['id'])->toArray();
            }

            $result = $this->permissionOrRoleInfoRepository->paginateByRole($ids);

            return utils()->paginate($result, RoleInfoListResource::collection($result));
        }
        return [];
    }

    /**
     * Notes: 对比自己和别人的角色
     * User: admin
     * Date: 2020/3/30 15:17
     *
     * @param $username
     * @return array
     */
    public function compareToUser($username)
    {
        $user = $this->userRepository->findByUserName($username);
        if ($user) {
            //查找用户的所有角色
            $userRoleNames = $user->getRoleNames();

            //查找当前登录用角色
            $meRoleNames = [];
            $me = $this->userRepository->findByUserName(api_user()['username']);
            if ($me) {
                //超级管理员
                if (check_super_admin($me->username)) {
                    $meRoleNames = Role::all()->pluck('name')->toArray();
                //普通
                } else {
                    $meRoleNames = $me->getRoleNames();
                }
            }

            $userRole = Role::query()->whereIn('name', $userRoleNames)->get(['id'])->pluck('id')->toArray();
            $meRole = Role::query()->whereIn('name', $meRoleNames)->get(['id'])->toArray();

            $result = [];
            $meRoleInfo = $this->permissionOrRoleInfoRepository->listByRole($meRole);
            foreach ($meRoleInfo as $item) {
                $result[] = [
                    'id' => $item->model_id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'role_name' => $item->role->name,
                    'status' => $item->status,
                    //是否对比的用户有这个角色
                    'user_has' => $username == api_user()['username']?true:in_array($item['model_id'], $userRole),
                ];
            }

            return $result;
        }
    }

    /**
     * Notes: 查找我的员工列表(权限系统使用)
     * User: admin
     * Date: 2020/3/31 15:38
     *
     * @return array
     */
    public function findMyEmployees()
    {
//        $departmentId = request()['department_id'];
//        $username = request()['username'];
//        $name = request()['name'];
//        $workStatus = request()['work_status'];
//
//        $userIds = (new EmployeesFind(WorkArrangementTypeEnum::PERMISSION_MANAGER))->result();
//
//        $query = $this->userStatusInfoRepository->listUserInfoQuery($userIds);
//        //筛选部门
//        if ($departmentId) {
//            $departmentIds = TreeTools::findMeAndChild(Department::tableName(), $departmentId);
//            $query->whereIn('department_id', $departmentIds);
//        }
//        //筛选工号或者艺名
//        if ($username || $name) {
//            $query->whereHas(User::tableName(), function ($query) use($username, $name) {
//                if ($username) {
//                    $query->where('username', $username);
//                }
//
//                if ($name) {
//                    $query->where('name', $name);
//                }
//            });
//        }
//        //筛选在职
//        if (utils()->boolExist($workStatus)) {
//            $query->where('work_status', $workStatus);
//        }
//
//        $result = $query->paginate(request()['limit']);
//
//        return utils()->paginate($result, UserBaseStatusInfoResource::collection($result));
    }

    /**
     * Notes: 新旧用户的角色替换
     * User: admin
     * Date: 2020/8/1 16:49
     *
     * @param array $oldUserIds //旧的用户列表
     * @param array $newUserIds //新的用户列表
     * @param array $roleNames //需要添加的角色列表
     */
    public function alternateAddition(array $oldUserIds, array $newUserIds, array $roleNames)
    {
        try {
            //移除旧用户列表角色
            $oldUsers = $this->userRepository->listByIds($oldUserIds);
            foreach ($oldUsers as $user) {
                foreach ($roleNames as $roleName) {
                    $user->removeRole($roleName);
                }
            }
            //添加新用户列表角色
            $newUsers = $this->userRepository->listByIds($newUserIds);
            foreach ($newUsers as $user) {
                foreach ($roleNames as $roleName) {
                    $user->assignRole($roleName);
                }
            }

        } catch (\Exception $e) {
            \Log::info("需要自动添加的角色在角色表还没有添加：", [$roleNames]);
            \Log::error($e);
        }
    }

    /**
     * Notes: 比较新老员工id列表,查找出那些是需要移除角色的
     * User: admin
     * Date: 2020/10/22 12:54
     *
     * @param $oldUserIds
     * @param $newUserIds
     * @return array
     */
    public function compareUserList($oldUserIds, $newUserIds)
    {
        //不在新列表的用户id
        $weedOutUserIds = [];

        foreach ($oldUserIds as $userId) {
            if (!in_array($userId, $newUserIds)) {
                $weedOutUserIds[] = $userId;
            }
        }

        return $weedOutUserIds;
    }
}
