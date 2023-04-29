<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/10 11:37
 */

namespace App\Modules\Permission\Entity;

use App\Modules\Permission\Enum\PermissionModelEnum;
use App\Modules\Permission\Service\PermissionService;
use App\Modules\Permission\Service\RoleService;
use App\Modules\User\Repository\UserRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Notes: 查询用户的所有角色和权限
 *
 * Class PermissionAndRoleByUser
 * @package App\Modules\Permission\Entity
 */
class PermissionAndRoleByUser
{
    /**
     * Notes: 用户
     *
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Notes: 获取自己角色，权限 和 其他用户的对比
     * User: admin
     * Date: 2020/1/10 19:12
     *
     * @param $username
     * @return array
     */
    public function get($username)
    {
        //获取自己所有的角色和权限
        [$permission, $role] = $this->getUserPermissionAndRole(api_user()['username']);

        $allPermission = $this->all(PermissionModelEnum::PERMISSION, $permission);
        $allRole = $this->all(PermissionModelEnum::ROLE, $role);

        //获取查看的用户
        [$userPermission, $userRole] = $this->getUserPermissionAndRole($username);

        //需要移除树内的权限名字
        $removes = [];

        $userPermission = $userPermission??array();
        $userRole = $userRole??array();

        //生成角色和权限对应的树
        foreach ($allRole as $r) {
            $r['checked'] = in_array($r['name'] , $userRole);

            $ps = $r->permissions;
            foreach ($ps as $p) {
                $p['checked'] = in_array($p['name'] , $userPermission);
                $removes[] = $p['name'];
            }
        }

        //移除自己没有的权限
        $lastPermissions = $allPermission->filter(function ($value) use ($userPermission, $removes) {
            $value['checked'] = in_array($value->name , $userPermission);
            return !in_array($value->name, $removes);
        })->values()->toArray();

        //比较角色是否拥有
        $lastRoles = $allRole->each(function ($value) use ($userRole) {
            $value['checked'] = in_array($value->name , $userRole);
        })->values()->toArray();

        return ['permissions' => $lastPermissions, 'roles' => $lastRoles];
    }

    /**
     * Notes: 获取用户拥有的角色或者路由
     * User: admin
     * Date: 2020/1/10 15:52
     *
     * @param int $enum
     * @param $names
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function all($enum, $names)
    {
        if ($enum == PermissionModelEnum::PERMISSION) {
            $tab = 'permissions';
            $select = Permission::query();

        } else {
            $tab = 'roles';
            $select = Role::query();
        }

        $select->select("{$tab}.*",
                'permission_or_role_info.name as cn_name',
                'permission_or_role_info.description',
                'permission_or_role_info.status')
            ->leftJoin('permission_or_role_info', function ($join) use ($enum, $tab) {
                $join->on("{$tab}.id", '=', 'permission_or_role_info.model_id')
                    ->where('permission_or_role_info.model_type', $enum);
            })
            ->whereIn("{$tab}.name", $names);

        return $select->get();
    }

    /**
     * Notes: 获取用户所有的权限和角色
     * User: admin
     * Date: 2020/1/10 16:06
     *
     * @param $username
     * @return array|bool
     */
    private function getUserPermissionAndRole($username)
    {
        try {
            //超级管理员可以分配所有权限
            if (check_super_admin($username)) {
                $permissions = Permission::all()->pluck('name')->toArray();

                $role = Role::all()->pluck('name')->toArray();

                return [$permissions, $role];
            //普通权限管理员只能分配自己有的权限
            } else {
                $user = $this->userRepository->findByUserName($username);
                if ($user) {
                    $permissions = $user->getAllPermissions()->pluck('name')->toArray();

                    $role = $user->getRoleNames()->toArray();

                    return [$permissions, $role];
                }
            }

        } catch (\Exception $e) {
            return [];
        }
    }
}
