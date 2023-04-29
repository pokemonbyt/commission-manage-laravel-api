<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Permission\ErrorCode\PermissionErrorCode;
use App\Modules\Permission\Service\PermissionService;
use App\Modules\User\ErrorCode\UserErrorCode;
use Illuminate\Http\Request;

/**
 * Notes: 权限控制器
 *
 * Class PermissionController
 * @package App\Http\Controllers\Api\Permission
 */
class PermissionController extends Controller
{
    private $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * Notes: 增加权限
     * User: admin
     * Date: 2019/12/24 14:56
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
        if ($result === PermissionErrorCode::DUPLICATE_PERMISSIONS ||
            $result === PermissionErrorCode::PERMISSION_CREATE_EXCEPTION) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除权限
     * User: admin
     * Date: 2019/12/24 15:56
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
        if ($result === PermissionErrorCode::PERMISSION_DELETE_EXCEPTION) {
            return $this->failed($result, PermissionErrorCode::getText($result));
        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 编辑权限
     * User: admin
     * Date: 2019/12/25 11:01
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
        if ($result === PermissionErrorCode::PERMISSION_DOES_NOT_EXIST ||
            $result === PermissionErrorCode::PERMISSION_EDIT_EXCEPTION) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 查找所有权限
     * User: admin
     * Date: 2019/12/25 12:27
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        return $this->success($this->service->all());
    }

    /**
     * Notes: 给予用户权限
     * User: admin
     * Date: 2019/12/24 16:22
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function giveToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'permissions' => 'required',
        ]);

        $result = $this->service->giveToUser($request->username, $request->permissions);
        if (gettype($result) === 'object') {
            return $this->failed(PermissionErrorCode::NOT_PERMISSION_GIVE,
                PermissionErrorCode::getText(PermissionErrorCode::NOT_PERMISSION_GIVE),
                [
                    'name' => $result->name,
                ]);

        } else if ($result === PermissionErrorCode::PERMISSION_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else if ($result === UserErrorCode::USER_DOES_NOT_EXIST) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除用户的权限
     * User: admin
     * Date: 2019/12/25 11:41
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function revokeToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'permission' => 'required',
        ]);

        $result = $this->service->revokeToUser($request->username, $request->permission);
        if ($result === PermissionErrorCode::PERMISSION_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else if ($result === UserErrorCode::USER_DOES_NOT_EXIST) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除用户所有旧权限后，再全部同步新权限
     * User: admin
     * Date: 2019/12/25 11:42
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function syncToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'permissions' => 'array',
        ]);

        $result = $this->service->syncToUser($request->username, $request->permissions);
        if ($result === PermissionErrorCode::PERMISSION_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else if ($result === UserErrorCode::USER_DOES_NOT_EXIST) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            $userModel = User::userByUsername($request->username);
            if ($userModel) {
//                ProcessInvoiceFindService::resetExceptInvoiceTypeCache($userModel->id);
            }

            return $this->success($result);
        }
    }

    /**
     * Notes: 根据工号查找用户是否拥有权限
     * User: admin
     * Date: 2019/12/13 12:17
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function hasToUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'permission' => 'required|string',
        ]);

        return $this->success($this->service->hasToUser($request->username, $request->permission));
    }

    /**
     * Notes: 查找权限所在的用户
     * User: admin
     * Date: 2019/12/25 13:46
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findInUsers(Request $request)
    {
        $this->validate($request, [
            'permissions' => 'required',
        ]);

        return $this->success($this->service->findInUsers($request->permissions));
    }

    /**
     * Notes: 查询用户拥有的所有权限
     * User: admin
     * Date: 2019/12/25 13:49
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
     * Notes: 查询我拥有的所有权限
     * User: admin
     * Date: 2021/04/14 11:06
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findAllToMe()
    {
        return $this->success($this->service->findAllToUser(api_user_model()->username));
    }

    /**
     * Notes:查找权限的角色列表
     * User: john
     * Date: 2021-03-30 23:12
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function rolesByPermission(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        return $this->success($this->service->rolesByPermission($request->id));
    }
}
