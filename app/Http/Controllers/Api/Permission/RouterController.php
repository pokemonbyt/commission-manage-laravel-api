<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/26 15:04
 */

namespace App\Http\Controllers\Api\Permission;


use App\Http\Controllers\Controller;
use App\Modules\Permission\ErrorCode\PermissionErrorCode;
use App\Modules\Permission\Service\RouterService;
use Illuminate\Http\Request;

/**
 * Notes: 路由控制器
 *
 * Class RouterController
 * @package App\Http\Controllers\Api\Permission
 */
class RouterController extends Controller
{
    private $service;

    public function __construct(RouterService $service)
    {
        $this->service = $service;
    }

    /**
     * Notes: 创建路由
     * User: admin
     * Date: 2019/12/28 18:03
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'routes' => 'required|array',
            'routes.*.name' => 'required',
            'routes.*.url' => 'required',
        ]);

        $result = collect($this->service->create($request->routes));
        if ($result->has('code')) {
            return $this->failed($result['code'], PermissionErrorCode::getText($result['code']), $result['data']);

        } else {
            return $this->success(true);
        }
    }

    /**
     * Notes: 删除路由
     * User: admin
     * Date: 2019/12/27 13:15
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'names' => 'required|array',
        ]);

        $result = $this->service->delete($request->names);

        return $this->success($result);
    }

    /**
     * Notes: 获取所有路由列表
     * User: admin
     * Date: 2019/12/26 17:32
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        return $this->success($this->service->all());
    }

    /**
     * Notes: 添加权限中的路由
     * User: admin
     * Date: 2019/12/27 13:19
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addToPermission(Request $request)
    {
        $this->validate($request, [
            'permission_id' => 'required',
            'routes' => 'required|array',
        ]);

        $result = $this->service->addToPermission($request->permission_id, $request->routes);
        if ($result === PermissionErrorCode::PERMISSION_DOES_NOT_EXIST ||
            $result === PermissionErrorCode::ROUTE_DOES_NOT_EXIST) {
            return $this->failed($result, PermissionErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除权限内的路由 (routes: 路由id列表)
     * User: admin
     * Date: 2019/12/27 13:25
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function removeToPermission(Request $request)
    {
        $this->validate($request, [
            'permission_id' => 'required',
            'routes' => 'required|array',
        ]);

        $result = $this->service->removeToPermission($request->routes, $request->permission_id);

        return $this->success($result);
    }

    /**
     * Notes: 查找权限内的路由
     * User: admin
     * Date: 2020/1/7 17:02
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findToPermission(Request $request)
    {
        $this->validate($request, [
            'permission_id' => 'required',
        ]);

        return $this->success($this->service->findToPermission($request->permission_id));
    }
}
