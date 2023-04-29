<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Permission\Entity\PermissionAndRoleByUser;
use App\Modules\Permission\ErrorCode\PermissionErrorCode;
use App\Modules\Permission\Service\PermissionService;
use App\Modules\Permission\Service\RoleService;
use Illuminate\Http\Request;

/**
 * Notes: 角色控制器
 *
 * Class RoleController
 * @package App\Http\Controllers\Api\Permission
 */
class RoleController extends Controller
{
    private $service;
    /**
     * Notes: 查找用户的权限和角色
     *
     * @var PermissionAndRoleByUser
     */
    private $permissionAndRoleByUser;


    function __construct(RoleService $service, PermissionAndRoleByUser $permissionAndRoleByUser)
    {
        $this->service = $service;

        $this->permissionAndRoleByUser = $permissionAndRoleByUser;
    }

    /**
     * Notes: 增加角色
     * User: admin
     * Date: 2019/12/25 18:51
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'cn_name' => 'required|max:100',
            'description' => 'required|max:255',
            'status' => 'required|boolean'
        ]);

        $result = $this->service->create($request->name, $request->cn_name, $request->description, $request->status);
        if ($result === PermissionErrorCode::DUPLICATE_ROLE ||
            $result === PermissionErrorCode::ROLE_CREATE_EXCEPTION) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除角色
     * User: admin
     * Date: 2019/12/25 18:58
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $result = $this->service->delete($request->id);
        if ($result === PermissionErrorCode::ROLE_DELETE_EXCEPTION) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 编辑角色
     * User: admin
     * Date: 2019/12/25 18:58
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function edit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'cn_name' => 'required|max:100',
            'description' => 'required|max:255',
            'status' => 'required|boolean'
        ]);

        $result = $this->service->edit($request->id, $request->name, $request->cn_name, $request->description, $request->status);
        if ($result === PermissionErrorCode::ROUTE_DOES_NOT_EXIST ||
            $result === PermissionErrorCode::ROLE_EDIT_EXCEPTION) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 查找所有角色
     * User: admin
     * Date: 2019/12/25 19:01
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        return $this->success($this->service->all());
    }

    /**
     * Notes: 给予用户角色
     * User: admin
     * Date: 2019/12/25 19:13
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function assignToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'roles' => 'required',
        ]);

        $result = $this->service->assignToUser($request->username, $request->roles);
        if (gettype($result) === 'object') {
            return $this->failed(PermissionErrorCode::NOT_PERMISSION_GIVE,
                PermissionErrorCode::getText(PermissionErrorCode::NOT_PERMISSION_GIVE),
                [
                    'name' => $result->name,
                ]);

        } else if ($result === PermissionErrorCode::ROLE_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 给予角色权限
     * User: admin
     * Date: 2019/12/25 19:17
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function givePermissionTo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);

        $result = $this->service->givePermissionTo($request->name, $request->permissions);
        if ($result === PermissionErrorCode::ROLE_DOES_NOT_EXIST ||
            $result === PermissionErrorCode::PERMISSION_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            //每当角色里的权限变动，刷新缓存的流程中心的拥有查看类型
//            ProcessInvoiceFindService::resetExceptInvoiceTypeCache();

            return $this->success($result);
        }
    }

    /**
     * Notes: 删除用户身上的角色
     * User: admin
     * Date: 2019/12/25 19:20
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function removeToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'role' => 'required',
        ]);

        $result = $this->service->removeToUser($request->username, $request->role);
        if ($result === PermissionErrorCode::ROLE_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除角色上的权限
     * User: admin
     * Date: 2019/12/25 19:22
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function revokePermissionTo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $result = $this->service->revokePermissionTo($request->name, $request->permission);
        if ($result === PermissionErrorCode::ROLE_DOES_NOT_EXIST ||
            $result === PermissionErrorCode::PERMISSION_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 查找角色的所有权限
     * User: admin
     * Date: 2020/1/7 17:44
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findPermissionTo(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        return $this->success($this->service->findPermissionTo($request->id));
    }

    /**
     * Notes: 删除用户所用角色，再全部同步新角色
     * User: admin
     * Date: 2019/12/25 19:29
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function syncToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'roles' => 'array',
        ]);

        $result = $this->service->syncToUser($request->username, $request->roles);
        if ($result === PermissionErrorCode::ROLE_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            $userModel = User::userByUsername($request->username);
            if($userModel){
//                ProcessInvoiceFindService::resetExceptInvoiceTypeCache($userModel->id);
            }

            return $this->success($result);
        }
    }

    /**
     * Notes: 根据工号查找角色
     * User: admin
     * Date: 2019/12/25 19:32
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function hasToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'role' => 'required',
        ]);

        return $this->success($this->service->hasToUser($request->username, $request->role));
    }

    /**
     * Notes: 查找角色所有的用户
     * User: admin
     * Date: 2019/12/25 19:33
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findInUser(Request $request)
    {
        $this->validate($request, [
            'roles' => 'required',
        ]);

        return $this->success($this->service->findInUser($request->roles));
    }

    /**
     * Notes: 查询用户身上所有角色
     * User: admin
     * Date: 2019/12/28 16:02
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findAllToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
        ]);

        return $this->success($this->service->findAllToUser($request->username));
    }

    /**
     * Notes: 查询用户的所有角色和路由
     * User: admin
     * Date: 2020/1/10 16:23
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findPermissionAndRoleByUsername(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
        ]);

        return $this->success($this->permissionAndRoleByUser->get($request->username));
    }

    /**
     * Notes: 获取我的所有角色和路由
     * User: admin
     * Date: 2021/04/14 10:54
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findMyPermissionAndRole()
    {
        return $this->success($this->permissionAndRoleByUser->get(api_user_model()->username));
    }

    /**
     * Notes: 对比自己和别人的角色
     * User: admin
     * Date: 2020/3/30 15:17
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function compareToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
        ]);

        return $this->success($this->service->compareToUser($request->username));
    }

    /**
     * Notes: 查找我的员工列表(权限系统使用)
     * User: admin
     * Date: 2020/3/31 15:23
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findMyEmployees(Request $request)
    {
        return $this->success($this->service->findMyEmployees());
    }
}
