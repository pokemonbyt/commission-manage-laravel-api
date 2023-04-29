<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/1 14:45
 */

namespace App\Http\Controllers\Api\Permission;


use App\Http\Controllers\Controller;
use App\Modules\Permission\Entity\MenuVO;
use App\Modules\Permission\ErrorCode\PermissionErrorCode;
use App\Modules\Permission\Request\MenuRequest;
use App\Modules\Permission\Service\MenuService;
use Illuminate\Http\Request;

/**
 * Notes: 菜单控制器
 *
 * Class MenuController
 * @package App\Http\Controllers\Api\Permission
 */
class MenuController extends Controller
{
    private $service;

    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }

    /**
     * Notes: 创建菜单
     * User: admin
     * Date: 2020/1/2 14:34
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(MenuRequest $request)
    {
        $menu = new MenuVO();
        $menu->setRequest($request);

        $result = $this->service->create($menu);
        if ($result === PermissionErrorCode::DUPLICATE_MENU) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除菜单
     * User: admin
     * Date: 2020/1/2 12:30
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|int'
        ]);

        return $this->success($this->service->delete($request->id));
    }

    /**
     * Notes: 创建菜单
     * User: admin
     * Date: 2020/1/2 14:51
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(MenuRequest $request)
    {
        $menu = new MenuVO();
        $menu->setRequest($request);

        $result = $this->service->edit($menu);
        if ($result === PermissionErrorCode::DUPLICATE_MENU) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 获取所有菜单
     * User: admin
     * Date: 2020/1/2 15:36
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        return $this->success($this->service->all());
    }

    /**
     * Notes: 添加权限中的菜单 (menus: 菜单id列表)
     * User: admin
     * Date: 2020/1/3 12:07
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addToPermission(Request $request)
    {
        $this->validate($request, [
            'permission_id' => 'required',
            'menus' => 'required|array',
            'menus.*' => 'int',
        ]);

        $result = $this->service->addToPermission($request->permission_id, $request->menus);
        if ($result === PermissionErrorCode::PERMISSION_DOES_NOT_EXIST ||
            $result === PermissionErrorCode::MENU_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除权限中的菜单 (menus: 菜单id列表)
     * User: admin
     * Date: 2020/1/3 12:09
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function removeToPermission(Request $request)
    {
        $this->validate($request, [
            'permission_id' => 'required',
            'menus' => 'required|array',
            'menus.*' => 'int',
        ]);

        $result = $this->service->removeToPermission($request->menus, $request->permission_id);

        return $this->success($result);
    }

    /**
     * Notes: 查找权限中所有的菜单
     * User: admin
     * Date: 2020/1/7 16:42
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findToPermission(Request $request)
    {
        $this->validate($request, [
            'permission_id' => 'required'
        ]);

        return $this->success($this->service->findToPermission($request->permission_id));
    }

    /**
     * Notes: 查找用户所有能查看的菜单
     * User: admin
     * Date: 2020/1/3 15:20
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findAllToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required'
        ]);

        return $this->success($this->service->findAllToUser($request->username));
    }
}
