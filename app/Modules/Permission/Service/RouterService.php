<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/26 15:10
 */

namespace App\Modules\Permission\Service;

use App\Models\Routes;
use App\Modules\Permission\ErrorCode\PermissionErrorCode;
use App\Modules\Permission\Repository\PermissionHasRoutesRepository;
use App\Modules\Permission\Repository\RoutesRepository;
use Spatie\Permission\Models\Permission;
use function foo\func;

/**
 * Notes: 路由业务
 *
 * Class RouterService
 * @package App\Modules\Permission\Service
 */
class RouterService
{
    private $routesRepository;

    private $permissionHasRoutesRepository;

    public function __construct(RoutesRepository $routesRepository, PermissionHasRoutesRepository $permissionHasRoutesRepository)
    {
        $this->routesRepository = $routesRepository;
        $this->permissionHasRoutesRepository = $permissionHasRoutesRepository;
    }

    /**
     * Notes: 创建路由
     * User: admin
     * Date: 2019/12/28 17:15
     *
     * @param $routes
     * @return array
     */
    public function create($routes)
    {
        $names = collect($routes)->pluck('name');
        //比对数据库内的路由
        $inData = $this->routesRepository->listByName($names);

        //比对项目路由表，查看是否存在
        $projectRoutes = $this->projectRoutes();
        $inProject = collect($routes)->filter(function ($value) use($projectRoutes) {
            return !$projectRoutes->contains('name', $value['name']);
        })->collect();

        if ($inData->isEmpty() && $inProject->isEmpty()) {
            $this->routesRepository->creates($routes);

            return [];
        }

        if ($inData->isNotEmpty()) {
            return [
                'code' => PermissionErrorCode::ROUTE_HAS_BEEN_ADDED,
                'data' => $inData
            ];
        }

        if ($inProject->isNotEmpty()) {
            return [
                'code' => PermissionErrorCode::ROUTE_NOT_FOUND,
                'data' => $inProject
            ];
        }
    }

    /**
     * Notes: 删除路由
     * User: admin
     * Date: 2019/12/28 18:28
     *
     * @param $names
     * @return bool
     */
    public function delete($names)
    {
        $this->routesRepository->delete($names);

        return true;
    }

    /**
     * Notes: 获取所有路由列表 （unassigned：未添加的路由  assign：已添加的路由）
     * User: admin
     * Date: 2019/12/26 17:29
     *
     * @return array
     */
    public function all()
    {
        $routes = $this->routesRepository->all(['name', 'url']);

        return $this->generateRoutesStructure($this->projectRoutes(), $routes);
    }

    /**
     * Notes: 添加权限中的路由
     * User: admin
     * Date: 2019/12/28 18:55
     *
     * @param $permissionId
     * @param $routes
     * @return bool|int
     */
    public function addToPermission($permissionId, $routes)
    {
        try {
            Permission::findById($permissionId, guard_api());
        } catch (\Exception $e) {
            \Log::error($e);
            return PermissionErrorCode::PERMISSION_DOES_NOT_EXIST;
        }

        $routeIds = $this->routesRepository->listByName($routes)->pluck('id')->toArray();
        if (count($routeIds) < count($routes)) {
            return PermissionErrorCode::ROUTE_DOES_NOT_EXIST;
        }

        collect($routeIds)->each(function ($value) use ($permissionId) {
            if (!$this->permissionHasRoutesRepository->findOne($value, $permissionId)) {
                $this->permissionHasRoutesRepository->create($value, $permissionId);
            }
        });

        return true;
    }

    /**
     * Notes: 删除权限内的路由
     * User: admin
     * Date: 2019/12/28 19:00
     *
     * @param $routes
     * @param $permissionId
     * @return bool
     */
    public function removeToPermission($routes, $permissionId)
    {
        $routeIds = $this->routesRepository->listByName($routes)->pluck('id')->toArray();
        collect($routeIds)->each(function ($value) use($permissionId) {
            $this->permissionHasRoutesRepository->delete($value, $permissionId);
        });

        return true;
    }

    /**
     * Notes: 查找权限内的路由
     * User: admin
     * Date: 2020/1/7 16:55
     *
     * @param $permissionId
     * @return array
     */
    public function findToPermission($permissionId)
    {
        $routerIds = $this->permissionHasRoutesRepository
            ->listRouteIdsByPermissionIds([$permissionId])
            ->pluck('router_id')
            ->toArray();

        $allRoutes = $this->routesRepository->all(['name', 'url']);
        $routes = $this->routesRepository->listById($routerIds, ['name', 'url']);

        return $this->generateRoutesStructure($allRoutes, $routes);
    }

    /**
     * Notes: 同步新增路由到路由表
     * User: admin
     * Date: 2020/7/29 12:37
     *
     * @return array|bool
     * @throws \Throwable
     */
    public function syncRouters()
    {
        try {
            \DB::beginTransaction();

            $hasRoutes = $this->routesRepository->all();
            $hasRoutesName = $hasRoutes->pluck('name')->toArray();

            //同步新增
            $addData = [];
            $routes = $this->projectRoutes();
            $routesName = $routes->pluck('name')->toArray();
            foreach ($routes as $route) {
                if (!in_array($route['name'], $hasRoutesName)) {
                    $model = new Routes();
                    $model->name = $route['name'];
                    $model->url = $route['url'];

                    $model->save();

                    $addData[] = $route['name'];
                }
            }
            //同步删除
            $delData = [];
            foreach ($hasRoutes as $route) {
                if (!in_array($route->name, $routesName)) {
                    $route->delete();

                    $delData[] = $route->name;
                }
            }

            \DB::commit();

            return ['add_total' => count($addData), 'add_routes' => $addData, 'del_total' => count($delData), 'del_routes' => $delData];


        } catch (\Throwable $e) {
            \Log::error($e);
            \DB::rollBack();
            return false;
        }
    }

    /**
     * Notes: 生成前端需要的结构
     * User: admin
     * Date: 2020/1/8 15:48
     *
     * @param \Illuminate\Support\Collection $allRoutes
     * @param \Illuminate\Support\Collection $routes
     * @return array
     */
    private function generateRoutesStructure(\Illuminate\Support\Collection $allRoutes, \Illuminate\Support\Collection $routes)
    {
        //去除已经添加的路由
        $unassigned = $allRoutes->filter(function ($value) use ($routes) {
            return !$routes->contains('name', $value['name']);
        })->values()->all();

        return ['unassigned' => $unassigned, 'assign' => $routes];
    }

    /**
     * Notes: 获取项目所有路由
     * User: admin
     * Date: 2019/12/26 16:35
     *
     * @return \Illuminate\Support\Collection
     */
    private function projectRoutes()
    {
        $data = [];

        $routes = \Route::getRoutes();
        foreach ($routes as $route) {
            $middleware = $route->action['middleware'];
            if (is_array($middleware)) {
                if (in_array('api', $middleware)) {
                    $data[] = [
                        'name' => $route->action['as'],
                        'url' => $route->uri,
                    ];
                }
            }
        }

        return collect($data);
    }
}
