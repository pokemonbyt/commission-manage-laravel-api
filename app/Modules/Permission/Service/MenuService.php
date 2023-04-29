<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/1 14:46
 */

namespace App\Modules\Permission\Service;

use App\Modules\Permission\Entity\MenuVO;
use App\Modules\Permission\Entity\MenuTree;
use App\Modules\Permission\ErrorCode\PermissionErrorCode;
use App\Modules\Permission\Repository\MenusRepository;
use App\Modules\Permission\Repository\PermissionHasMenusRepository;
use App\Modules\User\Repository\UserRepository;
use Spatie\Permission\Models\Permission;

/**
 * Notes: 菜单业务
 *
 * Class MenuService
 * @package App\Modules\Permission\Service
 */
class MenuService
{
    private $menusRepository;

    private $permissionHasMenusRepository;

    private $userRepository;

    public function __construct(MenusRepository $menusRepository,
                                PermissionHasMenusRepository $permissionHasMenusRepository,
                                UserRepository $userRepository)
    {
        $this->menusRepository = $menusRepository;
        $this->permissionHasMenusRepository = $permissionHasMenusRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Notes: 创建菜单
     * User: admin
     * Date: 2020/1/1 20:00
     *
     * @param MenuVO $menu
     * @return bool|int
     */
    public function create(MenuVO $menu)
    {
        $model = $this->menusRepository->findByName($menu->getName());
        if ($model) {
            return PermissionErrorCode::DUPLICATE_MENU;
        }

        return $this->menusRepository->create($menu);
    }

    /**
     * Notes: 删除菜单
     * User: admin
     * Date: 2020/1/2 12:27
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->menusRepository->delete($id);
    }

    /**
     * Notes: 编辑菜单
     * User: admin
     * Date: 2020/1/2 14:48
     *
     * @param MenuVO $menu
     * @return bool|int
     */
    public function edit(MenuVO $menu)
    {
        $result = $this->menusRepository->edit($menu);
        if ($result) {
            return $result;
        } else {
            return PermissionErrorCode::DUPLICATE_MENU;
        }
    }

    /**
     * Notes: 获取所有菜单
     * User: admin
     * Date: 2020/1/2 15:34
     *
     * @return array
     */
    public function all()
    {
        $arr = $this->menusRepository->all()->toArray();

        return (new MenuTree($arr))->get();
    }

    /**
     * Notes: 添加权限中的菜单
     * User: admin
     * Date: 2020/1/3 11:50
     *
     * @param $permissionId
     * @param $menus
     * @return bool|int
     */
    public function addToPermission($permissionId, $menus)
    {
        try {
            Permission::findById($permissionId, guard_api());
        } catch (\Exception $e) {
            \Log::error($e);
            return PermissionErrorCode::PERMISSION_DOES_NOT_EXIST;
        }

        $models = $this->menusRepository->listById($menus);
        if ($models->count() < count($menus)) {
            return PermissionErrorCode::MENU_DOES_NOT_EXIST;
        }

        collect($menus)->each(function ($value) use ($permissionId) {
            if (!$this->permissionHasMenusRepository->findOne($value, $permissionId)) {
                $this->permissionHasMenusRepository->create($value, $permissionId);
            }
        });

        return true;
    }

    /**
     * Notes: 删除权限中的菜单
     * User: admin
     * Date: 2020/1/3 11:59
     *
     * @param $menus
     * @param $permissionId
     * @return bool
     */
    public function removeToPermission($menus, $permissionId)
    {
        $this->permissionHasMenusRepository->delete($menus, $permissionId);

        return true;
    }

    /**
     * Notes: 查找权限中所有的菜单
     * User: admin
     * Date: 2020/1/7 16:40
     *
     * @param $permissionId
     * @return array
     */
    public function findToPermission($permissionId)
    {
        //查询我有
        $menuIds = $this->permissionHasMenusRepository
            ->listMenuIdsByPermissionIds([$permissionId])
            ->pluck('menu_id')
            ->toArray();

        //去重
        $ids = collect($menuIds)->unique()->toArray();

        $menus = $this->menusRepository->all();
        foreach ($menus as $value) {
            $value['checked'] = in_array($value['id'], $ids);
        }

        return (new MenuTree($menus))->get();
    }

    /**
     * Notes: 查找用户所有能查看的菜单
     * User: admin
     * Date: 2020/1/3 15:12
     *
     * @param $username
     * @return array
     */
    public function findAllToUser($username)
    {
        $user = $this->userRepository->findByUserName($username);
        if ($user) {
            try {
                //超级管理员直接获取全部菜单
                if (check_super_admin($username)) {
                    $menus = $this->menusRepository->all();

                //普通用户根据权限获取菜单
                } else {
                    $permissionIds = $user->getAllPermissions()->pluck('id');

                    $menuIds = $this->permissionHasMenusRepository
                        ->listMenuIdsByPermissionIds($permissionIds)
                        ->pluck('menu_id')
                        ->toArray();

                    //去重
                    $ids = collect($menuIds)->unique()->toArray();

                    $menus = $this->menusRepository->listById($ids);
                }

                return (new MenuTree($menus))->get();

            } catch (\Exception $e) {
                \Log::error($e);
            }
        }

        return [];
    }
}
