<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/26 15:35
 */

namespace App\Modules\Permission\Repository;

use App\Models\Routes;

/**
 * Notes: 路由表SQL操作
 *
 * Class RoutesRepository
 * @package App\Modules\Permission\Repository
 */
class RoutesRepository
{
    private $routes;

    public function __construct(Routes $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Notes: 创建路由
     * User: admin
     * Date: 2019/12/28 17:04
     *
     * @param $routes
     */
    public function creates($routes)
    {
        collect($routes)->each(function ($value) {
            $router = new Routes();
            $router->name = $value['name'];
            $router->url = $value['url'];

            $router->save();
        });
    }

    /**
     * Notes: 删除路由
     * User: admin
     * Date: 2020/1/8 12:13
     *
     * @param $names
     * @return int
     */
    public function delete($names)
    {
        return Routes::whereIn('name', $names)->delete();
    }

    /**
     * Notes: 返回表中所有的路由
     * User: admin
     * Date: 2019/12/26 16:01
     *
     * @param array $columns
     * @return Routes[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*'])
    {
        return Routes::all($columns);
    }

    /**
     * Notes: 根据名字查找
     * User: admin
     * Date: 2019/12/27 10:23
     *
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findByName($name)
    {
        return Routes::where('name', $name)->first();
    }

    /**
     * Notes: 根据ID查找
     * User: admin
     * Date: 2019/12/27 10:24
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findById($id)
    {
        return Routes::where('id', $id)->first();
    }

    /**
     * Notes: 根据名字返回列表
     * User: admin
     * Date: 2019/12/28 16:38
     *
     * @param $names
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function listByName($names, $columns = ['*'])
    {
        return Routes::whereIn('name', $names)->get($columns);
    }

    /**
     * Notes: 根据id返回列表
     * User: admin
     * Date: 2019/12/28 18:26
     *
     * @param $ids
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function listById($ids, $columns = ['*'])
    {
        return Routes::whereIn('id', $ids)->get($columns);
    }
}
